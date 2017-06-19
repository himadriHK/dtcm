<?php 
$data = array(
				'ivp_method'	=> "create",
				'ivp_store'	=> '12778' ,
				'ivp_authkey'	=> 'tp3L^9CLZh@QcfTM',
				'ivp_cart'	=> '123',
				'ivp_test'	=> '1',
				'ivp_amount'	=> '1.00',
				'ivp_currency'	=> "AED",
				'ivp_desc'	=> "test",
				'return_auth'	=> "http://www.tktrush.com/return.html",
				'return_can'	=> "http://www.tktrush.com/cancel.html",
				'return_decl'	=> "http://www.tktrush.com/decl.html",
				);

$data = array(
        'ivp_method'  => 'create',
        'ivp_store'   => '12778',
        'ivp_authkey' => 'tp3L^9CLZh@QcfTM',
        'ivp_cart'    => '123',  
        'ivp_test'    => '1',
        'ivp_amount'  => '100.00',
        'ivp_currency'=> 'AED',
        'ivp_desc'    => 'test',
        'return_auth' => 'https://www.tktrush.com/return.html',
        'return_can'  => 'https://www.tktrush.com/cancel.html',
        'return_decl' => 'https://www.tktrush.com/decl.html'
    );


							$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
			curl_setopt($ch, CURLOPT_POST, count($data));
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			$results = curl_exec($ch);
			curl_close($ch);
			var_dump($results);
			$results = json_decode($results,true);
var_dump($results);
			?>