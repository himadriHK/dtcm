<?php 
include('dtcm_api.php');

class DTCMMain {

    private $seller_code = "AELAB1";
    private $client_id = "193908c0ac0149f190c678827dab218c";
    private $secret_code = "3182134e601a4d2496f5b6fed9b39aa3";

    function __construct() {
        //add_action('wp_head', array($this, "test_token"));
        //add_action('tribe_events_single_event_after_the_meta', array( $this, 'print_ticket_prices_to_event' ));
    }

    function get_dtcm_access_token() {

        $dtcm_acc_token_url = "https://api.etixdubai.com/oauth2/accesstoken";
        $auth = base64_encode($this->client_id . ':' . $this->secret_code);
        $access_token_args = array("headers" => array("Accept" => "application/vnd.softix.api-v1.0+json",
                "Accept-Language" => "en_US",
                "Authorization" => "Basic $auth",
                "Content-Type" => "application/x-www-form-urlencoded"),
            "body" => "grant_type=client_credentials");
        $tmp['body']=wp_remote_post($dtcm_acc_token_url, $access_token_args);//'{"access_token":"78169748cf6642c58a98a99a44f36a57","token_type":"Bearer","expires_in":86399,"scope":"https://api.etixdubai.com/performances.* https://api.etixdubai.com/baskets.* https://api.etixdubai.com/orders.* https://api.etixdubai.com/inventory.* https://api.etixdubai.com/customers.* https://api.etixdubai.com/tixscan"}';//wp_remote_post($dtcm_acc_token_url, $access_token_args);
return $tmp;
    }
function get_access_token() {
        $current_token_expires = get_option('dtcm_access_token_expires');
        $threshold = time() - 120; //reducing 2 min from current time, good handling
		
        if ($current_token_expires > $threshold && $current_token_expires && $current_token_expires != 0) {
            return get_option('dtcm_access_token');
        } else {
            $access_token_res = $this->get_dtcm_access_token();
            //var_dump($access_token_res);
            if($access_token_res){
                //var_dump($access_token_res['body']);
				$tmp_2=$access_token_res['body'];
				//var_dump($access_token_res);
				//var_dump($tmp_2);
            //if ($access_token_res['response']['code'] == 200) {
                $token_res = json_decode($tmp_2,true);
				//var_dump( $token_res);

                update_option('dtcm_access_token', $token_res['access_token']);
                update_option('dtcm_access_token_expires', $token_res['expires_in'] + time());
                //var_dump($access_token_res);
                return $token_res['access_token'];
            //} else {
            //    return false; //something went wrong
            //}
            }else{
                //var_dump($access_token_res);
                return false;
            }
        }
    }
function get_performance_availabilities($performance_code){
        $access_token = $this->get_access_token();
        if ($access_token) {
            $endpoint = "https://api.etixdubai.com/performances/$performance_code/availabilities?channel=W&sellerCode=$this->seller_code";
            $perf_price_avail_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json")
            );
            $price_avail_res = wp_remote_get($endpoint, $perf_price_avail_args);
            //var_dump($price_avail_res);
            if($price_avail_res){
//                if ($price_avail_res['response']['code'] == 200) {
                          return $price_avail_res['body'];
//                     } else {
//                         return false;
                 }
            }
            else {
                return false;
            }
        } 
    
function get_performance_prices($performance_code) {
        $access_token = $this->get_access_token();
        if ($access_token) {
            $endpoint = "https://api.etixdubai.com/performances/$performance_code/prices?channel=W&sellerCode=$this->seller_code";
            $perf_price_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json")
            );
            $price_res = wp_remote_get($endpoint, $perf_price_args);
            //var_dump($price_res);
            if( $price_res){
               
                          return $price_res['body'];
                   
                 }
            else {
                return false;
            }
    }
}

function post_demands_to_dtcm($args){
	$demands=$args[0];
	$existing_basket=$args[1];
        $access_token = $this->get_access_token();
        if ($access_token) {
            if($existing_basket){
            $endpoint = "https://api.etixdubai.com/baskets/$existing_basket";
            }else{
            $endpoint = "https://api.etixdubai.com/baskets";    
            }
            $demands_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json"),
                "body"=>$demands
            );
            $add_to_basket_res = wp_remote_post($endpoint, $demands_args);
            //var_dump($add_to_basket_res);
            if( $add_to_basket_res){
                 return $add_to_basket_res['body'];
                }
            else {
                return false;
            }
        }
}

function purchase_basket_dtcm($args){
	
	$basket_id=$args[0];
	$dtcm_amount=$args[1];
                        $access_token = $this->get_access_token();
        if ($access_token) {

            $endpoint = "https://api.etixdubai.com/baskets/$basket_id/purchase";    
            $purchase_b_data = '{"Seller":"AELAB1","Payments":[{"Amount":'.$dtcm_amount.',"MeansOfPayment":"EXTERNAL"}]}';
            $purchase_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json"),
                "body"=>$purchase_b_data
            );
            $purchase_basket_res = wp_remote_post($endpoint, $purchase_args);
            //var_dump($purchase_basket_res);
            if($purchase_basket_res){
                  return $purchase_basket_res['body'];
                
            }
            else {
                return false;
            }
        
        
    }
}
 function get_dtcm_order($dtcm_order_id){
        $access_token = $this->get_access_token();
        if ($access_token) {
            $endpoint = "https://api.etixdubai.com/orders/$dtcm_order_id?sellerCode=$this->seller_code";
            $order_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json")
            );
            $order_res = wp_remote_get($endpoint, $order_args);
            //var_dump($price_res);
            if($order_res){
                return $order_res['body'];
                     } 
else 
{
                         return false;
                      }
            }
            
    }

}

$dtcm_=new DTCMMain();
//echo isset($_POST['dtcm_command']);
//var_dump ($_POST);
global $dtcm_;

if(isset($_POST['dtcm_command']) && isset($_POST['dtcm_arg']))
{
	//var_dump ($_POST);
	if($_POST['dtcm_command']=='perfprice')
	{
    //echo "before";
	echo $dtcm_->get_performance_prices($_POST['dtcm_arg']);
	//echo "after";
	}
	if($_POST['dtcm_command']=='perfavail')
	{
    //echo "before";
	echo $dtcm_->get_performance_availabilities($_POST['dtcm_arg']);
	//echo "after";
	}
	if($_POST['dtcm_command']=='demandset')
	{
    //echo "before";
	echo $dtcm_->post_demands_to_dtcm($_POST['dtcm_arg']);
	//echo "after";
	}
	if($_POST['dtcm_command']=='purchase')
	{
    //echo "before";
	echo $dtcm_->purchase_basket_dtcm($_POST['dtcm_arg']);
	//echo "after";
	}
	if($_POST['dtcm_command']=='orderdetails')
	{
    //echo "before";
	echo $dtcm_->get_dtcm_order($_POST['dtcm_arg']);
	//echo "after";
	}
}
//echo $dtcm_->get_performance_availabilities("ETES3EL");//("ETES3EL");
//var_dump(json_decode($dtcm_->get_performance_prices("ETES3EL"),true)['TicketPrices']);
?>

