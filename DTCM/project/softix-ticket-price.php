<?php
// session_start();
// if( !isset($_SESSION["softix_token"]) ){
// require_once 'softix-token.php';
// }
// $url = 'https://api.etixdubai.com/performances/ETES2016983G/prices?channel=W&sellerCode=AELAB1';
// $accesstoken = '165c91e5bf2649c98c6e106e2d94fb1f';


// //open connection
// $ch = curl_init();

// //set the url, number of POST vars, POST data
// curl_setopt($ch,CURLOPT_URL, $url);
//  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));
// //curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// //execute post
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $result = curl_exec($ch);
// $result = json_decode($result);
// //var_dump($result);
// //var_dump(curl_getinfo($ch));
// //var_dump(curl_error($ch));
// //var_dump($_SESSION["softix_token"]);
// //var_dump($result->TicketPrices->Prices);
// //var_dump(count($result->TicketPrices->Prices));
// for($i=0; $i<=count($result->TicketPrices->Prices); $i++){
// 	if($result->TicketPrices->Prices[$i]->PriceCategoryCode == '3' && $result->TicketPrices->Prices[$i]->PriceTypeCode == 'A'){
// 		$single_price = ($result->TicketPrices->Prices[$i]->PriceNet)/100;
// 	}
        
//                 if($result->TicketPrices->Prices[$i]->PriceCategoryCode == '3' && $result->TicketPrices->Prices[$i]->PriceTypeCode == 'V'){
// 		$ano_price = ($result->TicketPrices->Prices[$i]->PriceNet)/100;
// 	}
// }
// //var_dump($single_price);
// //var_dump(curl_getinfo($ch));
// //var_dump(curl_error($ch));
// //close connection
// curl_close($ch);
?>