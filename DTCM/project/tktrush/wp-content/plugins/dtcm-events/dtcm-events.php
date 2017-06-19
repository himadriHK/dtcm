<?php

/*
  Plugin Name: DTCM Events
  Plugin URI: http://wptowncenter.com
  Description: Custom plugin to support DTCM Events
  Version: 1.0
  Author: Rajesh K
  Author URI: http://wptowncenter.com
  Text Domain: dtcm-events
 */

class DTCMMain {

    private $seller_code = "AELAB1";
    private $client_id = "193908c0ac0149f190c678827dab218c";
    private $secret_code = "3182134e601a4d2496f5b6fed9b39aa3";

    function __construct() {
        //add_action('wp_head', array($this, "test_token"));
        add_action('tribe_events_single_meta_details_section_end', array( $this, 'print_ticket_prices_to_event' ));
    }

    function get_dtcm_access_token() {

        $dtcm_acc_token_url = "https://api.etixdubai.com/oauth2/accesstoken";
        $auth = base64_encode($this->client_id . ':' . $this->secret_code);
        $access_token_args = array("headers" => array("Accept" => "application/vnd.softix.api-v1.0+json",
                "Accept-Language" => "en_US",
                "Authorization" => "Basic $auth",
                "Content-Type" => "application/x-www-form-urlencoded"),
            "body" => "grant_type=client_credentials");
        return wp_remote_post($dtcm_acc_token_url, $access_token_args);
    }

    function get_access_token() {
        $current_token_expires = get_option('dtcm_access_token_expires');
        $threshold = time() - 120; //reducing 2 min from current time, good handling
        if ($current_token_expires > $threshold && $current_token_expires && $current_token_expires != 0) {
            return get_option('dtcm_access_token');
        } else {
            $access_token_res = $this->get_dtcm_access_token();
            //var_dump($access_token_res);
            if( !is_wp_error($access_token_res) ){
                //var_dump($access_token_res);
            if ($access_token_res['response']['code'] == 200) {
                $token_res = json_decode($access_token_res['body']);

                update_option('dtcm_access_token', $token_res->access_token);
                update_option('dtcm_access_token_expires', $token_res->expires_in + time());
                return $token_res->access_token;
            } else {
                return false; //something went wrong
            }
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
            //var_dump($price_res);
            if( !is_wp_error($price_avail_res) ){
                if ($price_avail_res['response']['code'] == 200) {
                          return $price_avail_res['body'];
                     } else {
                         return false;
                 }
            }
            else {
                return false;
            }
        } else {
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
            if( !is_wp_error($price_res) ){
                if ($price_res['response']['code'] == 200) {
                          return $price_res['body'];
                     } else {
                         return false;
                 }
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    function post_demands_to_dtcm($demands,$existing_basket = 0){
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
            if( !is_wp_error($add_to_basket_res) ){
                if ($add_to_basket_res['response']['code'] == 201 || $add_to_basket_res['response']['code'] == 200) {
                          return $add_to_basket_res['body'];
                     }else if($add_to_basket_res['response']['code'] == 404){
                          return 404;
                     } else {
                         return false;
                 }
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }
    
   
    function purchase_basket_dtcm($basket_id,$dtcm_amount){
                        $access_token = $this->get_access_token();
        if ($access_token) {

            $endpoint = "https://api.etixdubai.com/baskets/$basket_id/purchase";    
            $purchase_b_data = '{"Seller":"AELAB1","Payments":[{"Amount":'.$dtcm_amount.',"MeansOfPayment":"EXTERNAL"}]}';
            $purchase_args = array("headers" => array("Authorization" => "Bearer $access_token",
                    "Content-Type" => "application/json"),
                "body"=>$purchase_b_data
            );
            $purchase_basket_res = wp_remote_post($endpoint, $purchase_args);
            var_dump($purchase_basket_res);
            if( !is_wp_error($purchase_basket_res) ){
                if ($purchase_basket_res['response']['code'] == 201 || $purchase_basket_res['response']['code'] == 200) {
                          return $purchase_basket_res['body'];
                     } else {
                         return false;
                 }
            }
            else {
                return false;
            }
        } else {
            return false;
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
            if( !is_wp_error($order_res) ){
                if ($order_res['response']['code'] == 200) {
                          return $order_res['body'];
                     } else {
                         return false;
                 }
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    function test_token() {
        var_dump($this->get_access_token());
        echo "<pre>";
        print_r(json_decode($this->get_performance_prices("ETES3EL")));
        echo "</pre>";
    }
    
    function print_ticket_prices_to_event(){
        $event_id = get_the_ID();
        $tk_ticket_type = get_post_meta($event_id, "tk_ticket_type", true);
        $performance_code = get_post_meta($event_id,'dtcm_perf_code',true);
        //var_dump($tk_ticket_type);
         global $woocommerce;
          $ch_url = $woocommerce->cart->get_checkout_url();
       
        if( $tk_ticket_type == "manual"){
          $get_tickets = get_post_meta( $event_id, 'ticket_prod_ids',true);
        
        if( is_array($get_tickets) && !empty($get_tickets) ){
            echo "<form method='get' name='tk_add_to_cart' id='tk_add_to_cart'>";
            echo "<table><tr><th>Ticket</th><th>Price</th></tr>";
             
            foreach($get_tickets as $prod_id){
                ?>
<tr>
        <td><?php echo get_the_title($prod_id); ?></td>
        <td><?php echo get_post_meta($prod_id,'_regular_price',true);
        echo "&nbsp;";
        $manage_stock = get_post_meta($prod_id,'_manage_stock',true);
        $stock_qty = get_post_meta($prod_id,'_stock',true);
        $stock_status = get_post_meta($prod_id, '_stock_status',true);
        if( $stock_status == "outofstock" ){
            echo "<strong>SOLD</strong>";
        }else{
           echo "<select id='prod_id_$prod_id' class='man_event_ticks' name='ticket_man_$prod_id'>";
  for($i = 0; $i<=20; $i++){
           echo "<option value='$i'>$i</option>";
  }
echo "</select>";
//        echo "<input type='number' value='0' id='prod_id_$prod_id' class='man_event_ticks' name='ticket_man_$prod_id' >";
        }
        ?></td>
            </tr><?php
            }
            echo "</table>"; ?>
            <div class='tribe-events-cta' style="text-align: center;">
        <input type="hidden" name="ticket_type" value="manual"/>
        
                 <input type='submit' value='Buy Tickets' id='add-to-cart-cust' class='btn' >
                 <img id="gif-loader" style="display: none;" src="<?php echo  plugins_url( 'img/hourglass.gif', __FILE__ ); ?>">
                 <span class="spinner" id="spinner-tic"></span>
           </div></form>
           <div id="man_res"></div>
            <script type="text/javascript">
                jQuery(document).ready(function(){

                    jQuery("#tk_add_to_cart").submit(function(e){
                        e.preventDefault();
                        document.getElementById("add-to-cart-cust").disabled = true;
                        jQuery("#gif-loader").show();
                        
                        var ticket_data =[];
                        jQuery('.man_event_ticks').each(function(){
                            if( jQuery(this).val() > 0 ){
                            var ticket = {};
                            ticket.prod_id = jQuery(this).attr('id').replace("prod_id_","");
                            ticket.qty = jQuery(this).val();
        ticket_data.push(ticket);                
        }
                        });
                        console.log(ticket_data);
                        console.log(JSON.stringify(ticket_data));
                        if( ticket_data.length == 0 ){
                            alert("Select Atleast One");
                            return false;
                            document.getElementById("add-to-cart-cust").disabled = false;
                                jQuery("#gif-loader").hide();
                        }
                        
                                                   var data = {
            action:"add_to_cart_manual",
            post_id: <?php echo $event_id; ?>,
            ticket_data: JSON.stringify(ticket_data)
        }
                                    jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function (response) {
//                                document.getElementById("add-to-cart-cust").disabled = false;
                                //jQuery('#spinner-tic').removeClass('is-active');
                                 console.log(response);
                                 if(response.all_tic_added == "yes"){
                                    
                                 window.location.replace("<?php echo $ch_url; ?>");
                                 }else{
                                     document.getElementById("add-to-cart-cust").disabled = false;
                                jQuery("#gif-loader").hide();
        var tic_len = response.tickets.length;
        var tic_not_added = [];
        for(var i = 0; i<tic_len; i++){
            console.log(response.tickets[i]);
            if(response.tickets[i].status == 0){
              tic_not_added.push(response.tickets[i].notice);  
            }
        }
        console.log(tic_not_added);
        if(tic_not_added.length > 0){
            jQuery("#man_res").html("Following tickets could not be added, Try other<br>"+tic_not_added.join("<br>"));
        }
    }
                                 //var resObj = JSON.parse(response);
                                 
                            },"json"); 
                    
                    });
                });
                </script>
                <?php
        }
        
        //ajax code for add to cart

            }else{
                
        if( !empty($performance_code) ){
          $dtcm_prices = json_decode($this->get_performance_prices($performance_code)); 
          $dtcm_event_prods = get_post_meta($event_id,$performance_code.'_prods',true);
        if( is_array($dtcm_event_prods) && !empty($dtcm_event_prods)){
                                  echo "<form method='get' name='tk_add_to_cart_dtcm' id='tk_add_to_cart_dtcm'>";
          echo "<strong>Price</strong>";
          echo "<table><tr><th>Ticket</th><th>Price</th></tr>";
            foreach( $dtcm_event_prods as $prods){
             $prod_id = $prods['woo_prod_id'];
             if(get_post_meta($event_id,"show_prod_".$prod_id,true) == "yes"){
             $price_id = $prods['Price_Id']; ?>
                
                <tr><td><?php echo get_the_title($prod_id); ?></td>
                <td><?php
                $price_prod_id = 'priceid_'.$price_id.'_'.$prod_id;
                          echo "<span>&#x62f;&#x2e;&#x625;</span> ".get_post_meta($prod_id,'_regular_price',true);
                          echo "<input type='number' class='dtcm_ticks' id='$price_prod_id' value='0' name='ticket_$price_id' >"; 
                          ?></td></tr>
         
          <?php  }
            }
          echo "</table>"; ?>
                <div class='tribe-events-cta' style="text-align: center;">
        <input type="hidden" name="ticket_type" value="dtcm"/>
                 <input type='submit' value='Buy Tickets' href='#' id='add-to-cart-cust' class='btn'>
                 <img id="gif-loader" style="display: none;" src="<?php echo  plugins_url( 'img/hourglass.gif', __FILE__ ); ?>">
                 </div></form>
                     <script type="text/javascript">
                jQuery(document).ready(function(){
                   

                    jQuery("#tk_add_to_cart_dtcm").submit(function(e){
                        e.preventDefault();
                        document.getElementById("add-to-cart-cust").disabled = true;
                        console.log("submit called");
                        jQuery("#gif-loader").show();
                         //document.getElementById("add-to-cart-cust").disabled = true;
                        var ticket_data =[];
                        jQuery('.dtcm_ticks').each(function(){
                            if( jQuery(this).val() > 0 ){
                            var ticket = {};
                            var price_prod = jQuery(this).attr('id').split("_");
                            ticket.price_id = price_prod[1];
                            ticket.prod_id = price_prod[2];
                            ticket.qty = jQuery(this).val();
        ticket_data.push(ticket);                
        }
                        });
                        console.log(ticket_data);
                        console.log(JSON.stringify(ticket_data));
                        if( ticket_data.length == 0 ){
                            alert("Select Atleast One");
                            document.getElementById("add-to-cart-cust").disabled = false;
                                jQuery("#gif-loader").hide();
                            return false;
                        }
                        
                                                   var data = {
            action:"add_to_cart_dtcm",
            post_id: <?php echo $event_id; ?>,
            ticket_data: JSON.stringify(ticket_data)
        }
        console.log("before ajax");
                                    jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function (response) {


                                 console.log(response);
                                 //var resObj = JSON.parse(response);
                                 if(response.all_tic_added == "yes"){
                                    window.location.replace("<?php echo $ch_url; ?>"); 
                                 }else if(response.msg == 'sold') {
                                     alert("Ticket Sold Out");
                                     document.getElementById("add-to-cart-cust").disabled = false;
                                jQuery("#gif-loader").hide();
                                 }else{
                                     alert("Something went wrong");
                                     document.getElementById("add-to-cart-cust").disabled = false;
                                jQuery("#gif-loader").hide();
                                 }
                            },"json"); 
                    
                    });
                });
                </script>
                     
                <?php
        }

          
        }

        }
         
    }

}


new DTCMMain();

class DTCMSettings {

    function __construct() {
        add_action("add_meta_boxes", array( $this, "add_ticket_meta_box" ) );
        add_action("save_post", array( $this ,"save_ticket_details" ), 10, 3);
        add_action("wp_ajax_add_new_tic_prod", array( $this, "add_woo_prod_by_add_ticket" ));
        add_action("wp_ajax_del_tic_prod", array( $this, "delete_tic_products" ));
        add_action("wp_ajax_dtcm_del_tic_prod", array( $this, "dtcm_delete_tic_products" ));
        add_action("wp_ajax_load_dtcm_tickets", array( $this, "load_dtcm_ticks" ));
        

    }

    function add_ticket_meta_box() {
        add_meta_box("dtcm-perf-details", "Event Tickets Details", array($this, "event_ticket_details"), "tribe_events", "normal", "default", null);
    }
    
    function event_ticket_details( $object ){
        $performance_code = get_post_meta( $object->ID, 'dtcm_perf_code', true);
        $tk_ticket_type = get_post_meta( $object->ID, 'tk_ticket_type', true);
        ?>
<table>
    <tr><td>
            <label for="dtcm_perf_code">Event Type</label></td>
        <td>
            <input type="radio" name="tk_ticket_type" value="manual" <?php echo checked($tk_ticket_type,"manual"); ?>>Manual<br>
        <input type="radio" name="tk_ticket_type" value="dtcm" <?php echo checked($tk_ticket_type,"dtcm"); ?>>DTCM Event
        </td>
    </tr>
    <?php global $post;
    var_dump($post->ID);
    ?>
    <tr class="perf_code_tr"><td>
<label for="dtcm_perf_code">DTCM Performance Code</label></td><td>
        <input type="text" name="dtcm_perf_code" id="dtcm_perf_code" value="<?php echo $performance_code; ?>" >
        <input type="button" name="load_dtcm_tickets" id="load_dtcm_tickets" value="Load DTCM Ticket">
        
        </td>
    </tr>
    <tr class='perf_code_tr'>
        <td>
         Create Tickets   
        </td>
        <td>
         <input type="checkbox" name="load_dtcm_tickets" value='yes'/> <small>NOTE: This should be checked only once to create products. Don't check this if already created.</small>   
         <input type="submit" class='button button-primary' value="Submit" >
        </td>
    </tr>
    <tr class="manual_tic_tr">
        <td>
        <?php  
        $get_tickets = get_post_meta( $object->ID, 'ticket_prod_ids',true);
        
        if( is_array($get_tickets) && !empty($get_tickets) ){
            echo "<table id='existing_tickets'><tr><th>#ID</th><th>Title</th><th>Price</th><th>Actions</th></tr>";
            foreach($get_tickets as $prod_id){
                ?>
    <tr id="tr_prod_id_<?php echo $prod_id; ?>">
        <td><?php echo $prod_id; ?></td>
        <td><?php echo get_the_title($prod_id); ?></td>
        <td><?php echo get_post_meta($prod_id,'_regular_price',true); ?></td>
        <td><a href="<?php echo get_edit_post_link($prod_id); ?>">EDIT</a> | <a href="#" id="prod_id_<?php echo $prod_id; ?>" class="tic_prod_del">Delete</a> <span class="spinner" id="spin-tic-del-<?php echo $prod_id; ?>"></span></td>
    </tr>    <?php
            }
            echo "</table>";
        }
        ?>
        </td></tr>
<tr class="dtcm_tic_tr">
    <?php $dtcm_event_prods = get_post_meta($object->ID,$performance_code.'_prods',true); ?> 
    <td>
                <table id="dtcm_existing_tickets">
            <tr>
                <th>#ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        <?php if( is_array($dtcm_event_prods) && !empty($dtcm_event_prods)){ ?>

            <?php foreach( $dtcm_event_prods as $prods){
                $prod_id = $prods['woo_prod_id'];
                $checked = checked("yes",get_post_meta($object->ID,'show_prod_'.$prod_id,true));?>
            <tr id="dtcm_tr_prod_id_<?php echo $prod_id; ?>">
                <td><input type="checkbox" name="show_prod_<?php echo $prod_id; ?>" <?php echo $checked; ?> value="yes"><?php echo $prods['woo_prod_id']; ?></td>
                <td><?php echo get_the_title($prod_id); ?></td>
                <td><?php echo get_post_meta($prod_id,'_regular_price',true); ?></td>
                <td><a href="<?php echo get_edit_post_link($prod_id); ?>">EDIT</a> | <a href="#" id="dtcm_price_id_<?php echo $prods['Price_Id']; ?>" class="dtcm_tic_prod_del">Delete</a> <span class="spinner" id="dtcm-spin-tic-del-<?php echo $prods['Price_Id']; ?>"></span></td>
            </tr>
            <?php } ?>
        
        <?php } ?>
            </table>
    </td>
</tr>
    <tr>
        <td>
    <a href="#" id="add_new_tic_prod" >Add New Ticket</a>
    <table id="add_new_tic_details">
        <tr>
            <td>
                Ticket Title
            </td>
            <td>
        <input type="text" id="tic_prod_title" name="tic_prod_title" />
            </td>
        </tr>
        <tr>
            <td>
                Ticket Price 
            </td>
            <td>
              <input type="text" id="tic_prod_price" name="tic_prod_price" />  
            </td>
        </tr>
        <tr>
            <td>
    
    <a href="#" class="button" id="new_tic_prod_cancel" >Cancel</a>
            </td>
            <td>
                <span class="spinner" id="spinner-tic"></span>
                <input type="button" href="#" class="button button-primary button-large" id="new_tic_prod_save" value="Save">           
            </td>
    </tr></table>
        </td>
    </tr>
</table>
<style type="text/css">
    #add_new_tic_details{
        display: none;
    }
</style>
<script>
    jQuery(document).ready(function(){
        var ticket_type = jQuery('input[type=radio][name=tk_ticket_type]').val();
        if(ticket_type == 'dtcm'){
            jQuery('.perf_code_tr').show();
        }else if (ticket_type == 'manual'){
            jQuery('.perf_code_tr').hide();
        }
        jQuery('input[type=radio][name=tk_ticket_type]').change(function(){
            if(this.value == 'dtcm'){
                jQuery('.perf_code_tr').show();
                jQuery('#add_new_tic_details').hide();
                jQuery('#add_new_tic_prod').hide();
                jQuery('.manual_tic_tr').hide();
            }else{
                jQuery('.perf_code_tr').hide();
                jQuery('#add_new_tic_prod').show();
                jQuery('.manual_tic_tr').show();
            }
        });
        
        jQuery("#new_tic_prod_save").click(function(e){
            e.preventDefault();
        //ajax 
        document.getElementById("new_tic_prod_save").disabled = true;
        jQuery('#spinner-tic').addClass('is-active');
        var data = {
            action:"add_new_tic_prod",
            post_id: <?php echo $object->ID; ?>,
            prod_title: jQuery('#tic_prod_title').val(),
            prod_price: jQuery('#tic_prod_price').val(),
        }
                                    jQuery.post(ajaxurl, data, function (response) {
                                document.getElementById("new_tic_prod_save").disabled = false;
                                jQuery('#spinner-tic').removeClass('is-active');
                                jQuery('#tic_prod_title').val("");
                                jQuery('#tic_prod_price').val("");
                                 console.log(response);
                                 var resObj = JSON.parse(response);
                                 if( resObj.res == "ok" ){
                                     console.log(resObj);
                                    jQuery('#existing_tickets tr:last').after('<tr id="tr_prod_id_'+resObj.pid+'"><td><input type="checkbox" name="show_prod_'+resObj.pid+'" value="yes" >'+resObj.pid+'</td><td>'+resObj.ptitle+'</td><td>'+resObj.pprice+'</td><td><a href="'+resObj.ep_link+'">EDIT</a> | <a href="#" id="dtcm_prod_id_'+resObj.pid+'" class="tic_prod_del">Delete</a> <span class="spinner" id="spin-tic-del-'+resObj.pid+'"></span></td></tr>'); 
                                 }else{
                                     alert("something went wrong");
                                 }
                            });
        });
        
        jQuery('#dtcm-perf-details').on('click','.tic_prod_del',function(e){
        e.preventDefault();
        var prod_id = jQuery(this).attr('id').replace("prod_id_","");
                jQuery('#dtcm-perf-details #spin-tic-del-'+prod_id).addClass('is-active');
                
        var data = {
            action:"del_tic_prod",
            post_id: <?php echo $object->ID; ?>,
            prod_id: prod_id
        }
                                    jQuery.post(ajaxurl, data, function (response) {
                                
                                 console.log(response);
                                 var resObj = JSON.parse(response);
                                 if( resObj.res == "ok" ){
                                    jQuery('#dtcm-perf-details #tr_prod_id_'+resObj.pid).remove(); 
                                    jQuery('#dtcm-perf-details #spin-tic-del-'+resObj.pid).removeClass('is-active');
                                 }else{
                                     jQuery('#dtcm-perf-details .spinner').removeClass('is-active');
                                     alert("something went wrong");
                                 }
                            });
        });
        
                jQuery('#dtcm-perf-details').on('click','.dtcm_tic_prod_del',function(e){
        e.preventDefault();
        var price_id = jQuery(this).attr('id').replace("dtcm_price_id_","");
                jQuery('#dtcm-perf-details #dtcm-spin-tic-del-'+price_id).addClass('is-active');
                
        var data = {
            action:"dtcm_del_tic_prod",
            post_id: <?php echo $object->ID; ?>,
            price_id: price_id
        }
                                    jQuery.post(ajaxurl, data, function (response) {
                                
                                 console.log(response);
                                 var resObj = JSON.parse(response);
                                 if( resObj.res == "ok" ){
                                    jQuery('#dtcm-perf-details #dtcm_tr_prod_id_'+resObj.pid).remove(); 
                                    jQuery('#dtcm-perf-details #dtcm-spin-tic-del-'+resObj.pid).removeClass('is-active');
                                 }else{
                                     jQuery('#dtcm-perf-details .spinner').removeClass('is-active');
                                     alert("something went wrong");
                                 }
                            });
        });
        
                jQuery("#load_dtcm_tickets").click(function(e){
            e.preventDefault();
        //ajax 
        document.getElementById("load_dtcm_tickets").disabled = true;
        jQuery('#spinner-tic').addClass('is-active');
        var data = {
            action:"load_dtcm_tickets",
            post_id: <?php echo $object->ID; ?>,
            perf_code: jQuery('#dtcm_perf_code').val(),
        }
                                    jQuery.post(ajaxurl, data, function (response) {
                                document.getElementById("load_dtcm_tickets").disabled = false;
                                jQuery('#spinner-tic').removeClass('is-active');
                                 console.log(response);
                                 var resObj = JSON.parse(response);
                                 if( resObj.res == "ok" ){
                                     if (resObj.details !== undefined || resObj.details.length > 0) {
                var len = resObj.details.length;                    
                           for (var i = 0; i < len; i++) {
                               console.log(resObj.details[i]);
                               jQuery('#dtcm_existing_tickets tr:last').after('<tr id="dtcm_tr_prod_id_'+resObj.details[i].p_id+'"><td>'+resObj.details[i].p_id+'</td><td>'+resObj.details[i].p_title+'</td><td>'+resObj.details[i].p_price+'</td><td><a href="'+resObj.details[i].ep_link+'">EDIT</a> | <a href="#" id="dtcm_price_id_'+resObj.details[i].p_PriceId+'" class="dtcm_tic_prod_del">Delete</a> <span class="spinner" id="spin-tic-del-'+resObj.details[i].p_PriceId+'"></span></td></tr>'); 
                            }
                                     console.log(resObj.details);
                                     }
                                    
                                 }else{
                                     alert("something went wrong");
                                 }
                            });
        });
        
        jQuery("#add_new_tic_prod").click(function(e){
            e.preventDefault();
           jQuery("#add_new_tic_details").show();  
        });
        jQuery("#new_tic_prod_cancel").click(function(e){
            e.preventDefault();
           jQuery("#add_new_tic_details").hide(); 
        });
        
    });
    </script>
                <?php
    }
    
    function save_ticket_details( $post_id, $post, $update ){
        if(isset($_POST["dtcm_perf_code"]))
    {
        $perf_code = $_POST["dtcm_perf_code"];
        update_post_meta( $post_id, "dtcm_perf_code", $perf_code);
    }
     if(isset($_POST["tk_ticket_type"]))
    {
        $tk_ticket_type = $_POST["tk_ticket_type"];
        update_post_meta( $post_id, "tk_ticket_type", $tk_ticket_type);
    }
    $performance_code = get_post_meta($post_id,'dtcm_perf_code',true);
    
    $dtcm_event_prods = get_post_meta($post_id,$performance_code.'_prods',true);
    if( is_array($dtcm_event_prods) && !empty($dtcm_event_prods)){
        foreach( $dtcm_event_prods as $prods){
                $prod_id = $prods['woo_prod_id'];
                if(isset($_POST['show_prod_'.$prod_id])){
                    if($_POST['show_prod_'.$prod_id] == "yes"){
                        update_post_meta( $post_id, 'show_prod_'.$prod_id, "yes");
                    }
                }
        }
    }
    
    
    
    //load dtcm tickets
//    if(isset($_POST['load_dtcm_tickets'])){
//        if($_POST['load_dtcm_tickets'] == 'yes'){
//           $dtcm = new DTCMMain();
//           $dtcm_prices = json_decode($dtcm->get_performance_prices($performance_code)); 
//           foreach( $dtcm_prices->PriceCategories as $cat ){
//               
//           }
//        }
//    }
    
    
    }
    
    
    function add_woo_prod_by_add_ticket(){
        
        $p_title = $_POST['prod_title'];
        $p_price = $_POST['prod_price'];
        $post_id = $_POST['post_id'];
        $args = array(  "post_title" => $p_title,
                        "post_status" => "publish",
                        "post_type" => "product" );
        $product_id = wp_insert_post( $args );
        if( $product_id ){
            wp_set_object_terms( $product_id, 'simple', 'product_type' );
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_downloadable', 'no' );
        update_post_meta( $product_id, '_virtual', 'yes' );
        update_post_meta( $product_id, '_regular_price', $p_price );
        update_post_meta( $product_id, '_price', $p_price );
        update_post_meta( $product_id, '_stock_status', 'instock');
        
        
        update_post_meta( $product_id, 'associated_event', $post_id );
        
        $ticket_prod_ids = get_post_meta($post_id, 'ticket_prod_ids',true);
        
        if( !empty( $ticket_prod_ids ) && is_array( $ticket_prod_ids ) ){
            $ticket_prod_ids[] = $product_id;
        }else{
            $ticket_prod_ids = array($product_id);
        }
        update_post_meta($post_id, 'ticket_prod_ids', $ticket_prod_ids);
        
        $res = array( "res" => "ok",
                       "pid" => $product_id,
                       "ptitle" => $p_title,
                       "pprice" => $p_price,
                       "ep_link" => get_edit_post_link($product_id)
                );
                echo json_encode($res);
        }else{
            echo json_encode( array("res" => "notok") );
        }
        exit();
    }
    
    function load_dtcm_ticks(){
        $event_id = $_POST['post_id'];
        $event_code = $_POST['perf_code'];
        //echo "Post ID $event_id $perf_code";
        
    $dtcm = new DTCMMain();
    $dtcm_prices = json_decode($dtcm->get_performance_prices($event_code));
    $dtcm_event_prods = get_post_meta($event_id,$event_code.'_prods',true);
    if(empty($dtcm_event_prods) || !$dtcm_event_prods ){
        $dtcm_event_prods = array();
    }
    $output = array();
          foreach($dtcm_prices->TicketPrices->Prices as $prices){
if(!isset($dtcm_event_prods["PriceId_".$prices->PriceId])){
                             //create product
                             foreach($dtcm_prices->PriceCategories as $cats){
                                 if($prices->PriceCategoryId == $cats->PriceCategoryId){
                                     $price_cat = $cats->PriceCategoryName;
                                 }
                             }
                              foreach($dtcm_prices->PriceTypes as $ptypes){
                                 if($prices->PriceTypeId == $ptypes->PriceTypeId){
                                     $price_type = $ptypes->PriceTypeName;
                                 }
                             }
                             $p_title = get_the_title($event_id)."($price_cat - $price_type)";
                                     $args = array(  "post_title" => $p_title,
                        "post_status" => "publish",
                        "post_type" => "product" );
                                     $p_price = $prices->PriceNet/100;
        $product_id = wp_insert_post( $args );
        if( $product_id ){
            wp_set_object_terms( $product_id, 'simple', 'product_type' );
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_downloadable', 'no' );
        update_post_meta( $product_id, '_virtual', 'yes' );
        update_post_meta( $product_id, '_regular_price', $p_price );
        update_post_meta( $product_id, '_price', $p_price );
        update_post_meta( $product_id, '_stock_status', 'instock');
        
        update_post_meta( $product_id, 'perf_code',$event_code);
        update_post_meta( $product_id, 'dtcm_details',array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
            ));
        update_post_meta( $product_id, 'associated_event', $event_id );
        
                //adding product id to event meta for next usage
        $dtcm_event_prods["PriceId_".$prices->PriceId] =   array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
                                           "woo_prod_id" => $product_id
            );
        
        $output[] = array('p_id'=>$product_id,'p_title'=>$p_title,'p_price'=>$p_price,"ep_link" => get_edit_post_link($product_id),'p_PriceId' => $prices->PriceId);
                     }                    
        }

    }
            update_post_meta($event_id,$event_code.'_prods',$dtcm_event_prods);
    $res = array("res"=>"ok","details"=>$output);
    echo json_encode($res);
        exit();
    }
    
    function delete_tic_products(){
        $post_id = $_POST['post_id'];
        $prod_id = $_POST['prod_id'];
        $ticket_prod_ids = get_post_meta($post_id,'ticket_prod_ids',true);
        if (($key = array_search($prod_id, $ticket_prod_ids)) !== false) {
          unset($ticket_prod_ids[$key]);
          update_post_meta($post_id, 'ticket_prod_ids', $ticket_prod_ids);
          do_action( 'delete_post', $prod_id );
          wp_delete_post( $prod_id, true );
          do_action( 'deleted_post', $prod_id );
          $res = array( "res" => "ok",
                       "pid" => $prod_id
                );
          echo json_encode($res);
         }else{
           echo json_encode( array("res" => "notok") );  
         }
        exit();
    }
    
        function dtcm_delete_tic_products(){
        $post_id = $_POST['post_id'];
        $price_id = $_POST['price_id'];
        $performance_code = get_post_meta($post_id,'dtcm_perf_code',true);
        $dtcm_ticket_prod_ids = get_post_meta($post_id,$performance_code.'_prods',true);
        $prod_id = $dtcm_ticket_prod_ids["PriceId_".$price_id]['woo_prod_id'];
        
          unset($dtcm_ticket_prod_ids["PriceId_".$price_id]);
          update_post_meta($post_id, $performance_code.'_prods', $dtcm_ticket_prod_ids);
          do_action( 'delete_post', $prod_id );
          wp_delete_post( $prod_id, true );
          do_action( 'deleted_post', $prod_id );
          $res = array( "res" => "ok",
                       "pid" => $prod_id
                );
          echo json_encode($res);
       
           //echo json_encode( array("res" => "notok") );  
        
        exit();
    }

}

new DTCMSettings();



function tk_add_to_cart_manual(){
    $ticket_datas = $_POST['ticket_data'];
    //var_dump($_POST);
         global $woocommerce;
        $woocommerce->cart->empty_cart(); 
    $ticket_datas_jd = json_decode(wp_unslash($ticket_datas));
    $res_obj = new stdClass();
    $res_obj->all_tic_added = "yes";
    foreach($ticket_datas_jd as $ticket){
       // echo $ticket->prod_id;
        $passed_validation 	= apply_filters( 'woocommerce_add_to_cart_validation', true, $ticket->prod_id, $ticket->qty );

        if($passed_validation){
        $res = WC()->cart->add_to_cart($ticket->prod_id,$ticket->qty);
        }
        if($res){
        $res_obj->tickets[] = array("prod_id" => $ticket->prod_id,"status" => 1);
        } else{
            
            
            $product_data = wc_get_product( $ticket->prod_id );
            // Force quantity to 1 if sold individually and check for existing item in cart
				if ( $product_data->is_sold_individually() ) {
					$quantity         = apply_filters( 'woocommerce_add_to_cart_sold_individually_quantity', 1, $quantity, $product_id, $variation_id, $cart_item_data );
					$in_cart_quantity = $cart_item_key ? $this->cart_contents[ $cart_item_key ]['quantity'] : 0;

					if ( $in_cart_quantity > 0 ) {
						$notice = sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', wc_get_cart_url(), __( 'View Cart', 'woocommerce' ), sprintf( __( 'You cannot add another &quot;%s&quot; to your cart.', 'woocommerce' ), $product_data->get_title() ) ) ;
					}
				}

				// Check product is_purchasable
				if ( ! $product_data->is_purchasable() ) {
					$notice = __( 'Sorry, this product cannot be purchased.', 'woocommerce' ) ;
				}

				// Stock check - only check if we're managing stock and backorders are not allowed
				if ( ! $product_data->is_in_stock() ) {
					$notice = sprintf( __( 'You cannot add &quot;%s&quot; to the cart because the product is out of stock.', 'woocommerce' ), $product_data->get_title() );
				}

				if ( ! $product_data->has_enough_stock( $quantity ) ) {
					$notice = sprintf(__( 'You cannot add that amount of &quot;%s&quot; to the cart because there is not enough stock (%s remaining).', 'woocommerce' ), $product_data->get_title(), $product_data->get_stock_quantity() );
				}

				// Stock check - this time accounting for whats already in-cart
				if ( $managing_stock = $product_data->managing_stock() ) {
					$products_qty_in_cart = $this->get_cart_item_quantities();

					if ( $product_data->is_type( 'variation' ) && true === $managing_stock ) {
						$check_qty = isset( $products_qty_in_cart[ $variation_id ] ) ? $products_qty_in_cart[ $variation_id ] : 0;
					} else {
						$check_qty = isset( $products_qty_in_cart[ $product_id ] ) ? $products_qty_in_cart[ $product_id ] : 0;
					}

					/**
					 * Check stock based on all items in the cart.
					 */
					if ( ! $product_data->has_enough_stock( $check_qty + $quantity ) ) {
						$notice = sprintf(
							'<a href="%s" class="button wc-forward">%s</a> %s',
							wc_get_cart_url(),
							__( 'View Cart', 'woocommerce' ),
							sprintf( __( 'You cannot add that amount to the cart &mdash; we have %s in stock and you already have %s in your cart.', 'woocommerce' ), $product_data->get_stock_quantity(), $check_qty )
						 );
					}
				}
                                $notice =  $product_data->get_title().": ".$notice;
     $res_obj->tickets[] = array("prod_id" => $ticket->prod_id,"status" => 0,"notice" => $notice);
     $res_obj->all_tic_added = "no";
        }
        
    }
    if( $res_obj->all_tic_added == 'no' ){
              global $woocommerce;
        $woocommerce->cart->empty_cart();   
    }
    $res_obj = json_encode($res_obj);
    echo $res_obj;
    exit();
}
add_action('wp_ajax_add_to_cart_manual','tk_add_to_cart_manual');
add_action('wp_ajax_nopriv_add_to_cart_manual','tk_add_to_cart_manual');




function tk_add_to_cart_dtcm(){
    $ticket_datas = $_POST['ticket_data'];
    $event_id = $_POST['post_id'];
    $booking_tickets = json_decode(wp_unslash($ticket_datas));
    $event_code = get_post_meta($event_id,'dtcm_perf_code',true);
             global $woocommerce;
        $woocommerce->cart->empty_cart(); 
    //var_dump($ticket_datas);
    //var_dump(json_decode(wp_unslash($ticket_datas)));
    
    $dtcm = new DTCMMain();
    $dtcm_prices = json_decode($dtcm->get_performance_prices($event_code));
    $dtcm_event_prods = get_post_meta($event_id,$event_code.'_prods',true);
    
    //var_dump($dtcm_prices);
    //var_dump($dtcm_event_prods);
    $res_obj = new stdClass();
    $avail_res = $dtcm->get_performance_availabilities("ETES3EL");
if(!$avail_res){
 $res_obj->all_tic_added = 'no';
  $res_obj->msg = 'something went wrong';
 global $woocommerce;
$woocommerce->cart->empty_cart(); 
          echo json_encode($res_obj);
          exit();
}
$prds_add_to_cart = array();
$demands = array();
$demands_cat = array();
foreach($booking_tickets as $booking_tic){
    $prod_id = $booking_tic->prod_id;
    $prod_dtcm_details = get_post_meta($prod_id,'dtcm_details',true);
    $Price_Type_Code = $prod_dtcm_details['Price_Type_Code'];
    $Price_Category_Id = $prod_dtcm_details['Price_Category_Id'];
        $availability = json_decode($avail_res);
        foreach($availability->PriceCategories as $pcats){
            if($Price_Category_Id == $pcats->PriceCategoryId){
            $soldout = $pcats->Availability->SoldOut;
            if(!$soldout){
                
                             $cus_obj = new stdClass();
$demands_obj = new stdClass();

$demands_obj->PriceTypeCode = $Price_Type_Code;
$demands_obj->Quantity = $booking_tic->qty;
$demands_obj->Admits = $booking_tic->qty;
$demands_obj->offerCode = '';
$demands_obj->qualifierCode = '';
$demands_obj->entitlement = '';
$demands_obj->Customer = $cus_obj;
$demands_cat[$Price_Category_Id][] = $demands_obj;
$prds_add_to_cart[$Price_Category_Id][$booking_tic->prod_id] = $booking_tic->qty;
                
            }else{
                $res_obj->soldout = 'true';
                $res_obj->soldout_cat = $pcats->PriceCategoryName;
                $res_obj->book_prod_id = $prod_id;
                $res_obj->msg = "sold";
                          echo json_encode($res_obj);
          exit();
            }
            }
            
        }

}


$cart_contents = WC()->cart->cart_contents;
if( empty( $cart_contents ) ){
    $exitsting_basket_id = 0;
}else{
    $exitsting_basket_id = 0;
//    foreach( $cart_contents as $items ){
//        if(isset( $items['dtcm_basket_id'] )){
//           $exitsting_basket_id = $items['dtcm_basket_id']; 
//        }
//    }
}

//add to DTCM Basket

    $fee_obj = new stdClass();
 $fee_obj->Type = "5";
 $fee_obj->Code = 'W';
foreach($demands_cat as $cat_id => $user_demands){

 $area = "@$cat_id";
$fields = array(
	'Channel' => 'W',
	'Seller' => 'AELAB1',
	'Performancecode' => $event_code,
	'Area' => $area,	
	'autoReduce' =>  false,
		"holdcode"=>"",
	'Demand' => $user_demands,
	'Fees' => array($fee_obj)

);
$json_demands = json_encode($fields);
//var_dump($json_demands);


//echo "before poast";
$dres = $dtcm->post_demands_to_dtcm($json_demands,$exitsting_basket_id);

if($dres){
    //var_dump($dres);
    if($dres == 404){
        global $woocommerce;
        $woocommerce->cart->empty_cart(); 
         $res_obj->all_tic_added = 'no';
          $res_obj->msg = 'dtcm basket expired';
          echo json_encode($res_obj);
          exit();
        //echo "dtcm basket expired";
    }else{
    $dres_object = json_decode($dres);
//    echo "<pre>";
//    print_r($dres_object);
//    echo "</pre>";
    $basket_id = $dres_object->Id;
    $cart_item_data = array( "dtcm_basket_id" => $basket_id,"dtcm_price_cat" => $cat_id );
    update_option("dtcm_basket_".$basket_id,$dres_object);
    foreach($prds_add_to_cart[$cat_id] as $prod_id => $qty){
    //var_dump($prod_id);
    //var_dump($qty);
    $res = WC()->cart->add_to_cart($prod_id,$qty,$variation_id = 0, $variation = array(), $cart_item_data);
   // var_dump($res);
        
}
    }
}
}
 $res_obj->all_tic_added = 'yes';
echo json_encode($res_obj);
//var_dump($dres);
//var_dump($prds_add_to_cart);
 //   echo "dcm";
    exit();
}
add_action('wp_ajax_add_to_cart_dtcm','tk_add_to_cart_dtcm');
add_action('wp_ajax_nopriv_add_to_cart_dtcm','tk_add_to_cart_dtcm');


function change_bas_id(){
    
    $cart_contents = WC()->cart->cart_contents;
    var_dump($cart_contents);
    foreach( $cart_contents as $key => $items ){
        if(isset( $items['dtcm_basket_id'] )){
            WC()->cart->cart_contents[$key]['dtcm_basket_id'] = 12345;
        }
    }
    var_dump(WC()->cart->cart_contents);
    
}
//add_action('wp_head','change_bas_id');

//add_action('wp_head','te');
function te(){
               $dtcm = new DTCMMain();
               $performance_code = "ETES3EL";
           $dtcm_prices = json_decode($dtcm->get_performance_prices($performance_code)); 
           echo "<pre>";
           print_r($dtcm_prices);
echo "</pre>";
$event_id = 30;

$event_code = 'ETES3EL';
$booking_tickets = array(array('price_id'=>5,'qty'=>1));
$dtcm_event_prods = get_post_meta($event_id,$event_code.'_prods',true);
var_dump($dtcm_event_prods);
$prds_add_to_cart = array();
$demands = array();
if(empty($dtcm_event_prods)){
    //need to add woo prods
      foreach($dtcm_prices->TicketPrices->Prices as $prices){
                     foreach($booking_tickets as $booking_tic){
                         if($prices->PriceId == $booking_tic['price_id']){
                             //create product
                             foreach($dtcm_prices->PriceCategories as $cats){
                                 if($prices->PriceCategoryId == $cats->PriceCategoryId){
                                     $price_cat = $cats->PriceCategoryName;
                                 }
                             }
                              foreach($dtcm_prices->PriceTypes as $ptypes){
                                 if($prices->PriceTypeId == $ptypes->PriceTypeId){
                                     $price_type = $ptypes->PriceTypeName;
                                 }
                             }
                             $p_title = get_the_title($event_id)."($price_cat - $price_type)";
                                     $args = array(  "post_title" => $p_title,
                        "post_status" => "publish",
                        "post_type" => "product" );
                                     $p_price = $prices->PriceNet/100;
        $product_id = wp_insert_post( $args );
        if( $product_id ){
            wp_set_object_terms( $product_id, 'simple', 'product_type' );
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_downloadable', 'no' );
        update_post_meta( $product_id, '_virtual', 'yes' );
        update_post_meta( $product_id, '_regular_price', $p_price );
        update_post_meta( $product_id, '_price', $p_price );
        update_post_meta( $product_id, '_stock_status', 'instock');
        
        update_post_meta( $product_id, 'perf_code',$event_code);
        update_post_meta( $product_id, 'dtcm_details',array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
            ));
        update_post_meta( $product_id, 'associated_event', $event_id );
        
                //adding product id to event meta for next usage
        $dtcm_event_prods_save =  array( "PriceId_".$prices->PriceId => array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
                                           "woo_prod_id" => $product_id
            ));
        update_post_meta($event_id,$event_code.'_prods',$dtcm_event_prods_save);
        $prds_add_to_cart[$product_id] = $booking_tic['qty'];
        
        //dtcm demands
        $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands[] = $demands_obj;
$demands_obj->PriceTypeCode = $prices->PriceTypeCode;
$demands_obj->Quantity = $booking_tic['qty'];
$demands_obj->Admits = $booking_tic['qty'];
$demands_obj->offerCode = '';
$demands_obj->qualifierCode = '';
$demands_obj->entitlement = '';
$demands_obj->Customer = $cus_obj;
        }
        

        
        }
                     }                    
        }
}else{
    //check if prod exist else create new
    foreach($booking_tickets as $booking_tic){
        $booking_price_id = $booking_tic["price_id"];
        if( isset($dtcm_event_prods["PriceId_".$booking_price_id]) ){
            $woo_prod_id = $dtcm_event_prods["PriceId_".$booking_price_id]["woo_prod_id"];
            $Price_Type_Code = $dtcm_event_prods["PriceId_".$booking_price_id]["Price_Type_Code"];
           $prds_add_to_cart[$woo_prod_id] =  $booking_tic['qty'];
           
                   //dtcm demands
        $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands[] = $demands_obj;
$demands_obj->PriceTypeCode = $Price_Type_Code;
$demands_obj->Quantity = $booking_tic['qty'];
$demands_obj->Admits = $booking_tic['qty'];
$demands_obj->offerCode = '';
$demands_obj->qualifierCode = '';
$demands_obj->entitlement = '';
$demands_obj->Customer = $cus_obj;

        }else{
           //create new product
            foreach($dtcm_prices->TicketPrices->Prices as $prices){
                     
                         if($prices->PriceId == $booking_tic['price_id']){
                             //create product
                             foreach($dtcm_prices->PriceCategories as $cats){
                                 if($prices->PriceCategoryId == $cats->PriceCategoryId){
                                     $price_cat = $cats->PriceCategoryName;
                                 }
                             }
                              foreach($dtcm_prices->PriceTypes as $ptypes){
                                 if($prices->PriceTypeId == $ptypes->PriceTypeId){
                                     $price_type = $ptypes->PriceTypeName;
                                 }
                             }
                             $p_title = get_the_title($event_id)."($price_cat - $price_type)";
                                     $args = array(  "post_title" => $p_title,
                        "post_status" => "publish",
                        "post_type" => "product" );
                                     $p_price = $prices->PriceNet/100;
        $product_id = wp_insert_post( $args );
        if( $product_id ){
            wp_set_object_terms( $product_id, 'simple', 'product_type' );
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_downloadable', 'no' );
        update_post_meta( $product_id, '_virtual', 'yes' );
        update_post_meta( $product_id, '_regular_price', $p_price );
        update_post_meta( $product_id, '_price', $p_price );
        update_post_meta( $product_id, '_stock_status', 'instock');
        
        update_post_meta( $product_id, 'perf_code',$event_code);
        update_post_meta( $product_id, 'dtcm_details',array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
            ));
        update_post_meta( $product_id, 'associated_event', $event_id );
        
        
                //adding product id to event meta for next usage
        $dtcm_event_prods_save =  array( "PriceId_".$prices->PriceId => array( "Price_Id" => $prices->PriceId,
                                           "Price_Type_Code" => $prices->PriceTypeCode,
                                           "Price_Category_Id" => $prices->PriceCategoryId,
                                           "Price_Net" => $prices->PriceNet,
                                           "woo_prod_id" => $product_id
            ));
        update_post_meta($event_id,$event_code.'_prods',$dtcm_event_prods_save);
        $prds_add_to_cart[$product_id] = $booking_tic['qty'];
                         
                //dtcm demands
        $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands[] = $demands_obj;
$demands_obj->PriceTypeCode = $prices->PriceTypeCode;
$demands_obj->Quantity = $booking_tic['qty'];
$demands_obj->Admits = $booking_tic['qty'];
$demands_obj->offerCode = '';
$demands_obj->qualifierCode = '';
$demands_obj->entitlement = '';
$demands_obj->Customer = $cus_obj;
        }
        

        }
                     }                    
        
        }
    }
    
}

//add to DTCM Basket

 
 $fee_obj = new stdClass();
 $fee_obj->Type = "5";
 $fee_obj->Code = 'W';
$fields = array(
	'Channel' => 'W',
	'Seller' => 'AELAB1',
	'Performancecode' => 'ETES3EL',
	'Area' => 'SGA',	
	'autoReduce' =>  false,
		"holdcode"=>"",
	'Demand' => $demands,
	'Fees' => array($fee_obj)

);
$json_demands = json_encode($fields);
var_dump($json_demands);
$cart_contents = WC()->cart->cart_contents;
if( empty( $cart_contents ) ){
    $exitsting_basket_id = 0;
}else{
    $exitsting_basket_id = 0;
    foreach( $cart_contents as $items ){
        if(isset( $items['dtcm_basket_id'] )){
           $exitsting_basket_id = $items['dtcm_basket_id']; 
        }
    }
}

$dres = $dtcm->post_demands_to_dtcm($json_demands,$exitsting_basket_id);

if($dres){
    $dres_object = json_decode($dres);
    echo "<pre>";
    print_r($dres_object);
    echo "</pre>";
    $basket_id = $dres_object->Id;
    $cart_item_data = array( "dtcm_basket_id" => $basket_id );
    update_option("dtcm_basket_".$basket_id,$dres_object);
    foreach($prds_add_to_cart as $prod_id => $qty){
    var_dump($prod_id);
    var_dump($qty);
    $res = WC()->cart->add_to_cart($prod_id,$qty,$variation_id = 0, $variation = array(), $cart_item_data);
   // var_dump($res);
        
}
}
//var_dump($dres);
var_dump($prds_add_to_cart);
//add to site woo cart

//$res = WC()->cart->add_to_cart(33,1);
//var_dump($res);
//WC()->cart->DTCMBID = "some123";
var_dump(WC()->cart);

}


function add_basket_id_to_woo_order($order_id, $posted){
    $cart_contents = WC()->cart->cart_contents;
    $price_cat_baskets = array();
    if(!empty($cart_contents)){
        foreach($cart_contents as $items){
            if(isset( $items['dtcm_basket_id'] )){
                update_post_meta($order_id,'dtcm_'.$items['dtcm_price_cat'].'_basket_id',$items['dtcm_basket_id']);
                if(!isset($price_cat_baskets[$items['dtcm_price_cat']])){
                $price_cat_baskets[$items['dtcm_price_cat']] = $items['dtcm_basket_id'];
                }
//                $dtcm_basket = get_option("dtcm_basket_".$items['dtcm_basket_id']);
//                update_post_meta($order_id,'dtcm_basket',$dtcm_basket);
//                delete_option("dtcm_basket_".$items['dtcm_basket_id']);
                
            }
        }
        update_post_meta($order_id,'dtcm_all_baskets',$price_cat_baskets);
    }
}
add_action('woocommerce_checkout_update_order_meta','add_basket_id_to_woo_order',10,2);


function purchase_dtcm_basket_order_complete($order_id){
    //$dtcm_basket_id = get_post_meta($order_id,'dtcm_basket_id',true);
    $dtcm_all_baskets = get_post_meta($order_id,'dtcm_all_baskets',true);
    $dtcm_order_ids = array();
                $order = new WC_Order($order_id);
    $order_items = $order->get_items();
        $dtcm = new DTCMMain();
    foreach($dtcm_all_baskets as $cat => $dtcm_basket_id){

    $dtcm_amount = 0;
    foreach($order_items as $items){
      $dtcm_details = get_post_meta($items['product_id'],'dtcm_details',true);
      if($dtcm_details && !empty($dtcm_details)){
          if( $dtcm_details['Price_Category_Id'] == $cat){
          $dtcm_amount = $dtcm_amount + ( $dtcm_details['Price_Net']*$items['qty'] );
          }
      }
    }

    $res = $dtcm->purchase_basket_dtcm($dtcm_basket_id,$dtcm_amount);
    $res_obj = json_decode($res);
    $dtcm_order_id = $res_obj->OrderId;
    if($dtcm_order_id){
    $dtcm_order_ids[$dtcm_basket_id] = $dtcm_order_id;
    }
    }
    update_post_meta($order_id,"dtcm_order_ids",$dtcm_order_ids);
    //$dtcm_basket = get_post_meta($order_id,'dtcm_basket',true);

    
}
add_action('woocommerce_order_status_completed','purchase_dtcm_basket_order_complete');
//add_action('wp_footer','purchase_dtcm_basket_order_complete');

function tee(){
    $order_id = 34;
    $order = new WC_Order(34);
    var_dump($order);
    $order_items = $order->get_items();
    $dtcm_amoubt = 0;
    foreach($order_items as $items){
      var_dump($items); 
      $dtcm_details = get_post_meta($items['product_id'],'dtcm_details',true);
      if($dtcm_details && !empty($dtcm_details)){
          $dtcm_amoubt = $dtcm_amoubt + ( $dtcm_details['Price_Net']*$items['qty'] );
      }
    }
    var_dump($dtcm_amoubt);
    $dtcm = new DTCMMain();
    $dtcm_basket_id = "13294-44247417";
    $res = $dtcm->purchase_basket_dtcm($dtcm_basket_id,$dtcm_amoubt);
    $res_obj = json_decode($res);
    $dtcm_order_id = $res_obj->OrderId;
    var_dump($res);
    var_dump($dtcm_order_id);
    update_post_meta($order_id,"dtcm_order_id",$dtcm_order_id);
    
}
//add_action('wp_head','tee');

function avail_test(){
    $dtcm = new DTCMMain();
    $avail_res = $dtcm->get_performance_availabilities("ETES3EL");
    if($avail_res){
        $availability = json_decode($avail_res);
        var_dump($availability);
        foreach($availability->PriceCategories as $pcats){
            var_dump($pcats->Availability->SoldOut);
            var_dump($pcats);
            
        }
    }
    
}
//add_action('wp_head','avail_test');

function dtcm_ticket_details_email( $order, $sent_to_admin, $plain_text, $email){
	$dtcm_order_ids = get_post_meta($order->id,'dtcm_order_ids',true);
	
		if(!empty($dtcm_order_ids)){
			    $dtcm = new DTCMMain();
			echo "<h2>DTCM Order ID</h2>";
			echo "<ul>";
				foreach($dtcm_order_ids as $dtcm_order_id){
					$order_res = $dtcm->get_dtcm_order($dtcm_order_id);
					$order_res_json = json_decode($order_res);
					$barcodeli = '';
					foreach($order_res_json->OrderItems[0]->OrderLineItems as $item){
						$barcodeli .= "<li>$item->Barcode</li>";
					}
		            echo "<li>$dtcm_order_id
					<h4>Barcodes</h4>
					<ul>$barcodeli</ul></li>";
					
					
			}
			echo "</ul>";
		}
	
}
add_action('woocommerce_email_order_meta','dtcm_ticket_details_email', 10, 4);


function order_line_items(){
    $dtcm = new DTCMMain();
    $order_res = $dtcm->get_dtcm_order("20170318,352");
    $order_res_json = json_decode($order_res);
    var_dump($order_res_json->OrderItems[0]->OrderLineItems);
    foreach($order_res_json->OrderItems[0]->OrderLineItems as $item){
        echo $item->Barcode;
    }
    
    
    	$dtcm_order_ids = get_post_meta(134,'dtcm_order_ids',true);
	
		if(!empty($dtcm_order_ids)){
			    $dtcm = new DTCMMain();
			echo "<h2>DTCM Order ID</h2>";
			echo "<ul>";
				foreach($dtcm_order_ids as $dtcm_order_id){
					$order_res = $dtcm->get_dtcm_order($dtcm_order_id);
					$order_res_json = json_decode($order_res);
					$barcodeli = '';
					foreach($order_res_json->OrderItems[0]->OrderLineItems as $item){
                                            $RzStr = $item->Seat->RzStr;
						$barcodeli .= "<li>$item->Barcode & $RzStr</li>";
					}
		            echo "<li>$dtcm_order_id
					<h4>Barcodes & Seats</h4>
					<ul>$barcodeli</ul></li>";
					
					
			}
			echo "</ul>";
		}
    
}
//add_action('wp_head','order_line_items');



function show_dtcm_details_in_order_page( $post_type, $post ) {
    add_meta_box( 
        'dtcm-order-details',
        __( 'DTCM Order Details' ),
        'show_dtcm_order_details',
        'shop_order',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'show_dtcm_details_in_order_page', 10, 2 );

function show_dtcm_order_details(){
    global $post;
        	$dtcm_order_ids = get_post_meta($post->ID,'dtcm_order_ids',true);
	
		if(!empty($dtcm_order_ids)){
			    $dtcm = new DTCMMain();
			echo "<h2>DTCM Order ID</h2>";
			echo "<ul>";
				foreach($dtcm_order_ids as $dtcm_order_id){
					$order_res = $dtcm->get_dtcm_order($dtcm_order_id);
					$order_res_json = json_decode($order_res);
					$barcodeli = '';
					foreach($order_res_json->OrderItems[0]->OrderLineItems as $item){
                                            $RzStr = $item->Seat->RzStr;
						$barcodeli .= "<li>$item->Barcode & $RzStr</li>";
					}
		            echo "<li>$dtcm_order_id
					<h4>Barcodes & Seats</h4>
					<ul>$barcodeli</ul></li>";
					
					
			}
			echo "</ul>";
                }else{
                    echo "No DTCM order found";
                }
}


function add_ticket_pdf_to_cus_comp_order_email($attachments, $status ,  $order ){
    
    if( isset( $status ) &&  $status == "customer_completed_order" ) {
        
        include_once "dompdf/dompdf_config.inc.php";
        $html_file = plugin_dir_path( __FILE__ )."ticketsample.html";
        $html = file_get_contents($html_file);
        //var_dump($html);
            $order_items = $order->get_items();
    if(!empty($order_items)){
        $first_item = reset($order_items);
        $event_id = get_post_meta($first_item['product_id'],'associated_event',true);
        $event_title = get_the_title($event_id);
        $purchase_date = date( get_option('date_format'),  strtotime( $order->order_date ) );
        $event_date = date( get_option('date_format'),  strtotime( get_post_meta($event_id,'_EventStartDate',true) ) )." - ".date( get_option('date_format'),  strtotime( get_post_meta($event_id,'_EventEndDate',true) ) );
        $venue = get_post_meta($event_id,'_VenueVenue',true);
    }

                	$dtcm_order_ids = get_post_meta($order->id,'dtcm_order_ids',true);
	
		if(!empty($dtcm_order_ids)){
                    
                    $RzStr = "";
                    $barcode_img = "";
                    $dtcm = new DTCMMain();
                    foreach($dtcm_order_ids as $dtcm_order_id){
                        		$order_res = $dtcm->get_dtcm_order($dtcm_order_id);
					$order_res_json = json_decode($order_res);
					foreach($order_res_json->OrderItems[0]->OrderLineItems as $item){
                                            $RzStr .= $item->Seat->RzStr." ";
					    $barcode_img .= '<img src="http://www.tktrush.com/barcode128.php?code='.$item->Barcode.'" alt="" height="50" width="150" style="padding:20px 0 0;"/>';
					}

					
					
                    }
                }else{
                    //this is an manual event try to use own barcode number
                }
                $replace_arr = array(
'%%EventDate%%'=>$event_date,
'%%PurchaseDate%%'=> $purchase_date,
'%%TransactionNumber%%'=> $order->id,
'%%EventName%%'=>$event_title,
'%%EventLoc%%'=>$venue,
'%%AgeLimit%%'=>"",
'%%FaceValue%%'=>"",
'%%TicketCategory%%'=>"",
'%%ServiceCharge%%'=>"",
'%%SeatNumber%%'=>$RzStr,
'%%CCCharge%%'=>"",
'%%TicketNumber%%'=>$order->id,
'%%TotalAmount%%'=>$order->get_total(),
'%%Name%%'=>$order->billing_first_name." ".$order->billing_last_name,
'%%barcodes%%'=>$barcode_img,
'%%EventPicture%%'=>'http://www.tktrush.com/data/0001.jpg',
'%%Tickets%%'=>"",
'%%EventSponser%%'=>"",
'%%VoucherAdvert1%%'=>'http://www.tktrush.com/images/controed1.png',
'%%VoucherAdvert2%%'=>'http://www.tktrush.com/images/controed2.png',
);
          foreach($replace_arr as $key => $val){
    	$html = str_replace($key,$val,$html);
    }  
        $dompdf = new DOMPDF() ;
        $dompdf->load_html($html);
        $dompdf->render();
	$pdf = $dompdf->output();
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir["basedir"];
        $ticket_pdf_path = $upload_dir.'/tickets/ticket-'.$order->id.'.pdf';
        file_put_contents($ticket_pdf_path,$pdf);
        //$ticket_pdf_path = get_template_directory() . '/terms.pdf';
        $attachments[] = $ticket_pdf_path;
    }
    return $attachments;
}
add_filter('woocommerce_email_attachments','add_ticket_pdf_to_cus_comp_order_email',10,3);

function get_or(){
    $order = wc_get_order(134);
    var_dump($order->get_items());
    $order_items = $order->get_items();
    if(!empty($order_items)){
        $first_item = reset($order_items);
        echo $first_item['name'];
    }
    var_dump(date( get_option('date_format'),  strtotime( $order->order_date ) ) );
    
    $event_id = get_post_meta($first_item['product_id'],'associated_event',true);
    var_dump($event_id);
    $event_title = get_the_title($event_id);
    var_dump($event_title);
    $event_date = date( get_option('date_format'),  strtotime( get_post_meta($event_id,'_EventStartDate',true) ) )." - ".date( get_option('date_format'),  strtotime( get_post_meta($event_id,'_EventEndDate',true) ) );
    var_dump( $event_date );
    var_dump(get_post_meta($event_id,'_VenueVenue',true));
}
//add_action('wp_head','get_or');
