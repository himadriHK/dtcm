<?php
/*
Plugin Name: Telr Secure Payments
Plugin URI: https://www.telr.com/
Description: Telr Hosted Payment Pages for WooCommerce
Version: 2.0
Author: Telr
Author URI: https://www.telr.com/
License: GPL2
*/

if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
if (!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option('siteurl').'/wp-content'); }
if (!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins'); }
if (!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH.'wp-content'); }
if (!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins'); }

function telr_init() {
	/**
	* __construct function.
	*
	* @access public
	* @return void
	*/
	class WC_Gateway_Telr extends WC_Payment_Gateway {

		public function __construct() {
			global $woocommerce;

			$this->min_wc_ver="2.3.8";
			$this->id = 'telr';
			$this->has_fields = false;	// No additional fields in checkout page
			$this->method_title = __('Telr', 'woocommerce');
			$this->method_description = __('Telr Checkout', 'telr-for-woocommerce');
			$this->order_button_text = __( 'Proceed to Telr', 'telr-for-woocommerce' );
			$this->woocom_ver = $woocommerce->version;

			// Load the settings.
			$this->init_form_fields();	// Config page fields
			$this->init_settings();

			if ($this->can_init()) {
				$preload='<iframe style="width:1px;height:1px;visibility:hidden;display:none;" src="https://secure.telrcdn.com/preload.html"></iframe>';
				$this->enabled			= $this->get_config_option('enabled');
				$this->title			= $this->get_config_option('title');
				$this->description		= $this->get_config_option('description').$preload;
				$this->store_id			= $this->get_config_option('store_id');
				$this->store_secret		= $this->get_config_option('store_secret');
				$this->testmode			= $this->get_config_option('testmode');
				$this->debug			= $this->get_config_option('debug');
				$this->order_status		= $this->get_config_option('order_status');
				$this->cart_desc		= $this->get_config_option('cart_desc');
				$this->form_submission_method	= true;
				$this->api_endpoint = 'https://secure.telr.com/gateway/order.json';

				// Actions
				add_action('woocommerce_update_options_payment_gateways_'.$this->id, array($this, 'process_admin_options'));
				add_action( 'woocommerce_thankyou', array($this, 'update_order_status'));

			} else {
				$this->enabled = false;
			}

		}

 		private function can_init() {
			if (version_compare(PHP_VERSION, '5.5.0') < 0) {
				//return false;
			}
			if (!function_exists('curl_version')) { return false; }
			if (!function_exists('curl_init')) { return false; }
			if (version_compare($this->woocom_ver,$this->min_wc_ver) < 0) {
				return false;
			}
			return true;
		}


		public function update_order_status($order_id) {
			global $woocommerce;

			$order = new WC_Order( $order_id );
			$order_check = $this->check_order($order_id);

			if($order_check) {
				$new_status = $this->sorder_status;
				if (empty($new_status)) { $new_status="completed"; }
				$order->update_status($new_status);
			}
		}


		/**
		* Process the payment and return the result.
		*
		* @access public
		* @return array
		*/
		function process_payment($order_id) {
			$order = new WC_Order($order_id);
			$result = $this->generate_request($order);
			$telr_ref = trim($result['order']['ref']);
			$telr_url= trim($result['order']['url']);

			if (empty($telr_ref) || empty($telr_url)) {
				wc_add_notice('Payment API Failure, Please try again.', 'error');
			} else {
				update_post_meta( $order_id, '_telr_ref', $telr_ref);
			}

			return array(
				'result'	=> 'success',
				'redirect'	=> $telr_url,
			);

		}

		public function generate_request($order) {
			global $woocommerce;

			$order_id = $order->id;

			$cart_id = $order_id."_".uniqid();
			$cart_desc=trim($this->cart_desc);
			if (empty($cart_desc)) { $cart_desc='Order {order_id}'; }
			$cart_desc = preg_replace('/{order_id}/i',$order_id,$cart_desc);

			$test_mode = ($this->testmode == 'yes') ? 1 : 0;
			$return_url = 'auto:'.add_query_arg('utm_nooverride','1',$this->get_return_url($order));
			$cancel_url = 'auto:'.$order->get_cancel_order_url();

			$data = array(
				'ivp_method'	=> "create",
				'ivp_source'	=> 'WooCommerce '.$woocommerce->version,
				'ivp_store'	=> $this->store_id ,
				'ivp_authkey'	=> $this->store_secret,
				'ivp_cart'	=> $cart_id,
				'ivp_test'	=> $test_mode,
				'ivp_amount'	=> $order->order_total,
				'ivp_currency'	=> get_woocommerce_currency(),
				'ivp_desc'	=> $cart_desc,
				'return_auth'	=> $return_url,
				'return_can'	=> $cancel_url,
				'return_decl'	=> $cancel_url,
				'bill_fname'	=> $order->billing_first_name,
				'bill_sname'	=> $order->billing_last_name,
				'bill_addr1'	=> $order->billing_address_1,
				'bill_addr2'	=> $order->billing_address_2,
				'bill_city'	=> $order->billing_city,
				'bill_region'	=> $order->billing_state,
				'bill_zip'	=> $order->billing_postcode,
				'bill_country'	=> $order->billing_country,
				'bill_email'	=> $order->billing_email,
				);

			if (is_ssl() && is_user_logged_in()) {
				$data['bill_custref'] = get_current_user_id();
			}

			$response = $this->api_request($data);
			return $response;
		}

		public function check_order($order_id) {
			global $woocommerce;

			$order_ref = get_post_meta($order_id, '_telr_ref', true);

			$data = array(
				'ivp_method'	=> "check",
				'ivp_store'	=> $this->store_id ,
				'order_ref'	=> $order_ref,
				'ivp_authkey'	=> $this->store_secret,
				);

			$response = $this->api_request($data);

			$order_status_arr = array(2,3);
			$transaction_status_arr = array('A', 'H');

			if (array_key_exists("order", $response)) {
				$order_status = $response['order']['status']['code'];
				$transaction_status = $response['order']['transaction']['status'];
				if ( in_array($order_status, $order_status_arr) && in_array($transaction_status, $transaction_status_arr)) {
					return true;
				}
			}
			return false;
		}

		public function api_request($data) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->api_endpoint);
			curl_setopt($ch, CURLOPT_POST, count($data));
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			$results = curl_exec($ch);
			curl_close($ch);
			$results = json_decode($results,true);
			return $results;
		}


		/* ------------------------------ Admin setting page ------------------------------------------------ */

		public function get_config_option($key) {
			return $this->get_option($key);
		}

		public function admin_options() {
			if ($this->can_init()) {
				$this->show_admin_options();
			} else {
				$this->not_available();
			}
		}

		public function not_available() {
			?>
			<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'woocommerce' ); ?></strong>: <?php _e( sprintf('Requires WooCommerce %s or later, PHP 5.5 or later, and PHP cURL',$this->min_wc_ver), 'woocommerce' ); ?></p></div>
			<?php
		}

		public function show_admin_options() {
			// Admin Panel Options
			$configured = true;
			if ((empty($this->store_id)) || (empty($this->store_secret))) { $configured=false; }

			?>
			<h3><?php _e('Telr', 'woocommerce'); ?></h3>
			<?php if (!$configured) : ?>
				<div id="wc_get_started">
				<span class="main"><?php _e('Telr Hosted Payment Page', 'woocommerce'); ?></span>
				<span><a href="https://www.telr.com/" target="_blank">Telr</a> <?php _e('are a PCI DSS Level 1 certified payment gateway. We guarantee that we will handle the storage, processing and transmission of your customer\'s cardholder data in a manner which meets or exceeds the highest standards in the industry.', 'woocommerce'); ?></span>
				<span><br><b>NOTE: </b> You must enter your store ID and authentication key</span>
				</div>
			<?php else : ?>
				<p><?php _e('Telr Hosted Payment Page', 'woocommerce'); ?></p>
			<?php endif; ?>

			<table class="form-table">
			<?php $this->generate_settings_html(); ?>
			</table><!--/.form-table-->
			<?php
		}

		// Admin settings fields
		function init_form_fields() {
			// Initialise Gateway Settings Form Fields
			$this->form_fields = array(
				'enabled' => array(
					'title'		=> __('Enable/Disable', 'woocommerce'),
					'type'		=> 'checkbox',
					'label'		=> __('Enable Telr', 'woocommerce'),
					'default'	=> 'yes'
				),
				'title' => array(
					'title'		=> __('Title', 'woocommerce'),
					'type'		=> 'text',
					'description'	=> __('This controls the title which the user sees during checkout.', 'woocommerce'),
					'default'	=> __('Credit/Debit card', 'woocommerce'),
					'desc_tip'	=> true,
				),
				'description' => array(
					'title'		=> __('Description', 'woocommerce'),
					'type'		=> 'textarea',
					'description'	=> __('This controls the description which the user sees during checkout.', 'woocommerce'),
					'default'	=> __('Pay using a credit or debit card via Telr Secure Payments', 'woocommerce'),
					'desc_tip'	=> true,
				),
				'cart_desc' => array(
					'title'		=> __('Transaction description', 'woocommerce'),
					'type'		=> 'text',
					'description'	=> __('This controls the transaction description shown within the hosted payment page.', 'woocommerce'),
					'default'	=> __('Your order from StoreName', 'woocommerce'),
					'desc_tip'	=> true,
				),
				'store_id' => array(
					'title'		=> __('Store ID', 'woocommerce'),
					'type'		=> 'text',
					'description'	=> __('Enter your Telr Store ID.', 'woocommerce'),
					'default'	=> '',
					'desc_tip'	=> true,
					'placeholder'	=> '[StoreID]'
				),
				'store_secret' => array(
					'title'		=> __('Authentication Key', 'woocommerce'),
					'type'		=> 'text',
					'description'	=> __('This value must match the value configured in the hosted payment page V2 settings', 'woocommerce'),
					'default'	=> '',
					'desc_tip'	=> true,
					'placeholder'	=> '[Authentication Key]'
				),
				'testmode' => array(
					'title'		=> __('Test Mode', 'woocommerce'),
					'type'		=> 'checkbox',
					'label'		=> __('Generate transactions in test mode', 'woocommerce'),
					'default'	=> 'yes',
					'description'	=> __('Use this whilst testing your integration. You must disable test mode when you are ready to take live transactions')
				),
				'order_status' => array(
					'title'		=> __('Order Status', 'woocommerce'),
					'type'		=> 'select',
					'label'		=> __('Order status for authorised payments', 'woocommerce'),
					'default'	=> 'processing',
					'description'	=> __('Set the WooCommerce order status that will be used for authorised transations', 'woocommerce'),
					'options'	=> array(
						'processing'	=> __( 'Processing', 'woocommerce' ),
						'completed'	=> __( 'Completed', 'woocommerce' )
					)
				)
			);
		}


	}
}



if(!function_exists('telr_list_network_plugins')) {
	function telr_list_network_plugins() {
		if (!is_multisite()) {
			return false;
		$sitewide_plugins = array_keys((array) get_site_option('active_sitewide_plugins'));
		}
		if (!is_array($sitewide_plugins)) {
			return false;
		}
		return $sitewide_plugins;
	}
}

function add_telr_gateway($methods) {
	$methods[] = 'WC_Gateway_Telr';
	return $methods;
}

// Add plugin to wordpress/woocommerce
if ((in_array('woocommerce/woocommerce.php', (array)get_option('active_plugins'))) || (in_array('woocommerce/woocommerce.php', (array)telr_list_network_plugins()))) {
	add_action('plugins_loaded', 'telr_init', 0);
	add_filter('woocommerce_payment_gateways', 'add_telr_gateway');
}
?>
