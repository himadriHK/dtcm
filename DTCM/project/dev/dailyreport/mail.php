<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 *
 * @category	### Gripsell ###
 * @package		### Advanced ###
 * @arch		### Secured  ###
 * @author 		Development Team, Gripsell Technologies & Consultancy Services
 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell Tech}
 * @license		http://www.gripsell.com Clone Portal
 * @version		4.3.3
 * @since 		2011-11-16
 */
ob_start();
 require_once('../Connections/eventscon.php');
require_once('../model_function.php');



$seat_type_arr=get_set_type();
require 'PHPExcel.php';
$objPHPExcel = new PHPExcel();
$oldest_transaction=time();
$newest_transaction=time();
// Set properties
$objPHPExcel->getProperties()->setCreator("----- Web Server");
$objPHPExcel->getProperties()->setLastModifiedBy("-----Web Server");
$objPHPExcel->getProperties()->setTitle("Daily Payment Report");
$objPHPExcel->getProperties()->setSubject("Daily Payment report");
$objPHPExcel->getProperties()->setDescription("Daily Report on Payment");
$objPHPExcel->getProperties()->setKeywords("Daily Report");
$objPHPExcel->getProperties()->setCategory("Payment report");

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);    

// format the heading
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Daily Report on Payment - ran on '.date('d/m/y', time()));
$objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
//$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Date Range: '.date('m/d/Y', $oldest_transaction).' to '.date('m/d/Y', $newest_transaction));
//$objPHPExcel->getActiveSheet()->mergeCells('E1:J1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray(
        array(
            'font'    => array(
                'size'      => '12',
                'bold'      => true
            )
        ),
        'A1:I1'
);

// add column labels
$objPHPExcel->getActiveSheet()->setCellValue('A2', '#ID');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Event Title');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Event Date');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Ticket Type');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Ticket Price');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Adult Tickets');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Child Tickets');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Payment type');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Voucher Number');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Customer Email');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Customer Name');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Customer Mobile');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Customer Address');
$objPHPExcel->getActiveSheet()->setCellValue('N2', 'Delivery');
$time=time()-(24*60*60);

$order_sql = "SELECT tkt.*,cust.*,evn.title FROM ticket_orders as tkt left JOIN customers as cust on tkt.cust_id=cust.cust_id  left JOIN events as evn on tkt.tid=evn.tid WHERE order_date>"."'".date('Y-m-d',$time)."'";

$order_query = mysql_query($order_sql, $eventscon) or die(mysql_error());

$totalRows_order = mysql_num_rows($order_query);


//echo date('Y-m-d H:i:s A',$time);exit;

$i=3;
$j=1;
while($order=mysql_fetch_assoc($order_query))
{
	//echo '<pre>';
	//print_r($order);
	$selected_seats=unserialize($order['selected_seats']);
	if(!empty($selected_seats))
	{
		foreach($selected_seats['tickets'] as $seat=>$quantity)
		{
			if($selected_seats['tickets'][$seat]!=0 || $selected_seats['ctickets'][$seat]!=0)
			{
				$sql="select * from event_prices where pid=$seat";

			$price_query = mysql_query($sql, $eventscon) or die(mysql_error());

			$price_values = mysql_fetch_assoc($price_query);

			$ticket_price=$price_values['price']*$selected_seats['tickets'][$seat] + $price_values['cprice']*$selected_seats['ctickets'][$seat];
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $j);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $order['title']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, date('d M Y',strtotime($order['event_date'])));
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $seat_type_arr[$price_values['stand']]);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $order['ticket_price']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $selected_seats['tickets'][$seat]);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $selected_seats['ctickets'][$seat]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$order['payment_type']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$order['order_number']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $order['email']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, trim($order['fname'].' '.$order['lname']));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $order['mobile']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $order['address'].', '.$order['city'].', '.$order['country']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, ($order['ticket_price']>$ticket_price)?'Yes':'No');
			$i++;
			$j++;
			}
		}
	}
}
 include 'PHPExcel/IOFactory.php';
    $file_name = date('d-m-Y', $oldest_transaction);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($_SERVER['DOCUMENT_ROOT'].'/dailyreport/'.$file_name.'.xls');
	
	 // $headers .= "Content-type: text/html; charset=us-ascii\n";
//    $headers .= "MIME-Version: 1.0\n";
//    $headers .= "Content-Type: application/octet-stream; name=\"xsl/\"\n";
//    $headers .= "From: $business\n";
//    $headers .= "Content-Disposition: attachment; filename=\"".$file_name.".xls\"\n\n";
//    @mail("pradeep_bose1@yahoo.com", "AB-MXR",  "hello is it working ", $headers);
   // header ("location:http://www.domain.com/cache/temp/".$file_name.".xls");
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, "", $header)) {
        echo "mail send ... OK"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
    }
}
//$mailto="pradeep_bose1@yahoo.com";
$mailto="nasser@tktrush.com";
$my_file = $file_name.".xls";
$my_path = $_SERVER['DOCUMENT_ROOT']."/dailyreport/";
$my_name = "TktRush";
$my_mail = 'nasser@tktrush.com';
$my_replyto = "nasser@tktrush.com";
$my_subject = "Order report on ".date('d-m-Y', $oldest_transaction);
$my_message = "Hello,\r\n Please download the attachment of ticket orders on ".date('d-m-Y', $oldest_transaction).".\r\n\r\n";
mail_attachment($my_file, $my_path, $mailto, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
@unlink($_SERVER['DOCUMENT_ROOT']."/dailyreport/".$my_file);
?>