  <?php require_once('Connections/eventscon.php'); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/date.js"></script>
<link href="css/TM_style.css" rel="stylesheet" type="text/css" />
</head>

<body onLoad="goforit()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">&nbsp;</td>
    <td width="140" align="center" valign="top">&nbsp;</td>
    <td width="993" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><span style="width:773px;">
          <?php require("headmain.php"); ?>
        </span></td>
      </tr>
      <tr>
        <td background="images/nav-bg.png"><span style="width:773px;">
          <?php require("head.php"); ?>
        </span></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="15" valign="top" background="images/shaffaf.png" >&nbsp;</td>
                  <td valign="top" background="images/shaffaf.png" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="images/up_coming_events_t.png" width="255" height="32" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><p align="justify"><b>Ticket Masters-ME Purchase Policy</b><br />
                                      <b class="arrow">Our goal:</b> To make your purchasing experience as much enjoyable as the event you about to embark on. We guarantee a easy and efficient process.</p></td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><p align="justify"><b>Purchase Policy</b><br />
                                      <b class="arrow">Ticket sales:</b> Ticket Master-ME sells tickets on behalf of promoters. The promoters set the ticket price and allocate the seating.</p></td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><p align="justify"><b class="arrow">Exchange Policy:</b> No exchange or refund after purchase has been made for lost, stolen, damaged or destroyed tickets. Tickets purchased on Ticket Master-ME are non-refundable only in case of events cancellation and per promoter regulations.</p></td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><b class="arrow">WARNING</b> direct sunlight or heat can sometimes damage tickets.</td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><b>Cancellation Policy:</b><br />
                                Events may sometimes be cancelled or postponed by the promoter for a variety of reasons.</td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:432px;">If the event of cancellation, a refund form from the responsible party will be issued.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:432px;">If the event was moved or rescheduled, the promoter may set refund limitations. Contact us for exact instructions.</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td style="height:10px;"></td>
                            </tr>
                            <tr>
                              <td><p align="justify">Please contact us on Mobile No, 050-2562778 to receive information about the purchase you made. Please keep you reference number at hand which you will receive at the conclusion of placing an order.</p></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><b>Ticket Terms and Conditions</b><br />
                                Promoter/producer &ndash; Produce the event for which you buy a ticket.</td>
                            </tr>
                            <tr>
                              <td style="height:5px;"></td>
                            </tr>
                            <tr>
                              <td><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:521px;">Ticket Master-ME   sells tickets on behalf of the promoter or producer that produces the event for which you buy a ticket.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>This ticket remains the property of the Promoter/producer. Admission may be refused at any time upon refunding the printed purchase price.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>The purchaser represents and warrants that the ticket is purchased for personal use only, and that it is not purchased as part of any form of business or commercial activity.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>The ticket may not be resold or offered for resale by anyone whether at a premium or otherwise.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>Ticket may not be used for advertising, promotion (including contests and sweepstakes) or for any other trade purposes.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>Resale or attempted resale at a price higher than that printed herein is grounds for cancellation without refund or other compensation.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>The Promoter/producer its affiliates and successors. Except as provided above, that this agreement does not create any right enforceable by any person who is not a party to it under the Act, but does not affect any right or remedy that a third party has which exists or is available apart from that Act.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>It is the responsibility of the purchaser to re confirm whether an event has been cancelled and the date and time of any rearranged event. In the event of cancellation or rescheduling, Ticket Master-ME will use reasonable endeavours to notify ticket holders of the cancellation once we have received the relevant authorisation from the Promoter/producer. We do not guarantee that ticket holders will be informed of such cancellation before the date of the event.</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><b>Cancellation of Events</b></td>
                            </tr>
                            <tr>
                              <td style="height:5px;"></td>
                            </tr>
                            <tr>
                              <td><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:521px;">We regret that tickets cannot be exchanged or refunded after purchase unless the performance is cancelled.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>If a performance is cancelled, ticket holders will be offered seats at any rescheduled performance (subject to availability)  to the face value of the tickets or, if the ticket holder is unable to attend the rescheduled performance or the performance is not rescheduled a full refund will be offered.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>Full refunds for tickets purchased prior to the date of the original event will be given up to the face value of the tickets purchased plus the relevant per ticket booking fee.</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><b>How to claim your refund</b></td>
                            </tr>
                            <tr>
                              <td style="height:5px;"></td>
                            </tr>
                            <tr>
                              <td><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:521px;">Please apply in writing to your point of purchase. You must enclose your unused tickets. The venue reserves the right to refuse admission should patrons breach any Rules and Regulations of the venue or Promoter/Producer.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>We regret that tickets cannot be exchanged or refunded after purchase unless the performance is cancelled. If a performance is cancelled, ticket holders will be offered seats at any rescheduled performance (subject to availability) up to the face value of the tickets or, if the ticket holder is unable to attend the rescheduled performance or the performance</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><b>Security </b></td>
                            </tr>
                            <tr>
                              <td style="height:5px;"></td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:521px;">The venue may on occasions have to conduct security searches to ensure the safety of the patrons.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>Ticket Master-ME will not be responsible for any tickets that are lost or stolen.</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><b>Seating</b></td>
                            </tr>
                            <tr>
                              <td style="height:5px;"></td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td style="width:521px;">The ticket holder has a right only to a seat of a value corresponding to that stated on the ticket.</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="top" style="width:17px;"><img src="images/arrow.gif" width="17" height="19" /></td>
                                    <td>The Promoter or Producer reserves the right to provide alternative seats to those specified on the ticket.</td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                          </table></td>
                        </tr>

                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                    </table></td>
                  <td width="15" valign="top" background="images/shaffaf.png" >&nbsp;</td>
                  <td style="width:5px; height:24px;"></td>
                  <td width="200" align="center" valign="top" background="images/shaffaf.png" style="width:200px; height:24px;"><span> </span>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center"><?php require("right_side.php"); ?></td>
                        </tr>
                    </table></td>
                </tr>
            </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="140" align="center" valign="top"><?php require("cintentsr.php");?></td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100" align="center" bgcolor="#000000"><span style="width:773px;">
      <?php require("footer.php"); ?>
    </span></td>
  </tr>
</table>
<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-11947961-2");

pageTracker._trackPageview();

} catch(err) {}</script>
</body>

</html>

