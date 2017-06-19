<div style="margin: 0 auto; width: 595px; font-family: Arial, Helvetica, sans-serif; background: #fff;">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr style="position:relative; z-index:99999;">
                <td>
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="padding: 0 0 0 10px; width:10%;"><img src="http://www.tktrush.com/images/captcha.png" alt="" width="65" height="66" /></td>
                                <td style="width:54%;"><strong style="font-size: 25px; display: block; margin: 20px 0 0;">This is your ticket</strong> <strong style="font-size: 22px; color: #fc1000;">Make Sure to bring it with you</strong></td>
                                <td><div style="margin:0 0 -49px; position:relative; z-index:9999;"><img src="http://www.tktrush.com/images/ticket.png" alt="" width="118" height="88"  /></div></td>
                                <td style="padding: 0 10px 0 0;"><img src="http://www.tktrush.com/images/logoin.png" alt="" width="76" height="72" /></td>
                            </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            <tr><td style=" height:20px; background:#000; padding: 0 0 5px; position:relative; z-index:9;"></td></tr>
            <tr>
                <td style="margin: 10px 5px;">
                    <table style="background: #f4f3f1; border: 1px solid #000;" border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td align="left" valign="top">
                                    <table style="font-weight: bold; font-size: 13px;" border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td width="52%" style="padding: 5px 10px;">Event Date: %%EventDate%%</td>
                                                <td width="48%" style="padding: 5px 10px;">Transaction Number: %%TransactionNumber%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Event Name: %%EventName%%</td>
                                                <td style="padding: 5px 10px;">Purchase Date: %%PurchaseDate%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Location: %%EventLoc%%</td>
                                                <td style="padding: 5px 10px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Age Limit: %%AgeLimit%%</td>
                                                <td style="padding: 5px 10px;">Face Value: %%FaceValue%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Ticket Category: %%TicketCategory%%</td>
                                                <td style="padding: 5px 10px;">Service Charge: %%ServiceCharge%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Seat Number: %%SeatNumber%%</td>
                                                <td style="padding: 5px 10px;">Credit Card Charge: %%CCCharge%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Ticket Number: %%TicketNumber%%</td>
                                                <td style="padding: 5px 10px;">Total Amount: %%TotalAmount%%</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;">Name:%%Name%%</td>
                                                <td style="padding: 5px 10px;">&nbsp;</td>
                                            </tr>
                                            <?php
                                            if (!isset($_SESSION["softix_token"])) {
                                                require_once 'softix-token.php';
                                            }
                                            //$value_order_id = '20160826,513';
                                            $url = 'https://api.etixdubai.com/orders/' . $value_order_id . '?sellerCode=AELAB1';

//open connection
                                            $ch = curl_init();

//set the url, number of POST vars, POST data
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            //curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . $_SESSION["softix_token"]));
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//execute post
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $order_details_dtcm = curl_exec($ch);
                                            $order_details_dtcm = json_decode($order_details_dtcm);
                                            file_put_contents('dbarcode.txt', $order_details_dtcm);
//close connection
                                            curl_close($ch);
                                            ?>
                                            %%Tickets%%
                                        </tbody>
                                    </table></td>
                                <td align="right" valign="top" style="width:25px; position:relative;"></td>
                            </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #000;">
                    <h5 style="margin-left:10px;">Ticket Barcodes</h5>
                  <div>
                                        <?php foreach ($order_details_dtcm->OrderItems[0]->OrderLineItems as $item) { ?>
                                            <img src="http://www.tktrush.com/barcode.php?code=<?php echo $item->Barcode; ?>" alt="" height="50" width="150" style="padding:15px;"/>
<?php } ?>
                                    </div>  
                </td>
            </tr>
            <tr>
                <td>
                    <table style="vertical-align: top; margin: 0 5px;" border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td valign="top" width="295px;">
                                    <table style="vertical-align: top;" border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td valign="top"><img src="%%EventPicture%%" alt="" width="292" height="200" /></td>
                                            </tr>
                                            <tr>
                                                <td><img src="http://www.tktrush.com/images/comingsoon.png" alt="" width="293" height="132" /></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <div style="border: 1px solid #000; padding: 10px 20px; margin: 6px 5px 10px 2px;"><strong>Information</strong>
                                                        <ul style="margin: 10px 0 0; font-size: 12px; font-weight: bold; padding: 0 0 0 15px;">
                                                            <li>This barcode only allows one entry per scan</li>
                                                            <li>Unauthorised duplicates or sale of this ticket may prevent<br /> you admitance to the event</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td>%%EventSponser%%</td>
                                            </tr>
                                            <tr>
                                                <td><img src="%%VoucherAdvert1%%" alt="" height="240" width="292" />
                                                    <img src="%%VoucherAdvert2%%" alt="" height="152" width="292" />

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="background: #000; padding: 10px 20px; color: #fff; font-size: 12px; line-height: 20px;">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td><strong>Ticket Rush<br /> I Rise Tower / Hessa ST / T-Com / Dubai - United Arab Emirates</strong></td>
                                    <td><br /> <strong>www.tktrush.com</strong></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div> 
                </td>
            </tr>
        </tbody>
    </table>
</div> 