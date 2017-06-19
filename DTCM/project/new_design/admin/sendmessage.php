<?

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?require("title.php");?></title>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {color: #D4D4D4}
.style4 {font-size: 12px}
-->
</style></head>
<body>
<table width="788" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td><table width="765" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php
  require("connection.php");
  $sql="select * from `ticketma_ticketdbff_events` ";
  $result=mysql_query($sql);
  require("head.php");

  ?>
              &nbsp;</td>
          </tr>
        </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="160" valign="top"><div align="center"></div>
                      <?php  require("contents.php"); ?></td>
                  <td width="1" valign="top" background="../../../phpdev/www/form4/admin/images/up-dot.gif"><img src="../../../phpdev/www/form4/admin/images/up-dot.gif" width="1" height="3" /></td>
                  <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="20" background="../../../phpdev/www/form4/admin/images/faselm1n.png"><img src="../../../phpdev/www/form4/admin/images/faselmf1n.png" width="20" height="35" /></td>
                              <td height="30" background="../../../phpdev/www/form4/admin/images/faselm1n.png"><span class="eventHeader">NEWSLETTER</span></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="52">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="75" bgcolor="#E8E8E8"><center class="style3">
  <em><span class="style2"> <span class="style4">
  <?php
require("connection.php");

$message_id=$HTTP_POST_VARS['message_id'];
$sql="select *  from `ticketma_ticketdbff_messages` where (message_id=".$message_id.")";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$message='<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Masters</title>
<style type="text/css">
<!--
.style1 {
	font-size: 36px;
	font-style: italic;
	font-weight: bold;
}
.style3 {color: #666666}
.style4 {
	color: #CC0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="455" border="0" align="center">
  <tr>
    <td height="76" bordercolor="#CC0000" bgcolor="#CCCCCC">&nbsp;<span class="style1">&nbsp;&nbsp;<span class="style3">Ticket Masters Me &nbsp;&nbsp;&nbsp;</span></span><img src="http://ticketmastersme.com/admin/images/logo.jpg" width="150" height="38"></td>
  </tr>
  <tr>
    <td height="291">';
$title=$row['message_title'];
$message.=$row['message_content'];
$message.='</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><p class="style4">&nbsp;</p>
      <p class="style4">General Manager : Mr. Nasser Tabbah</p>
      <table width="326" cellpadding="0" cellspacing="0">
        <TR>
          <TD width="83" height="16">Mobile Phone </TD>
          <TD width="180">00971 50 456 27 78 </TD>
        </TR>
        <TR>
          <TD height="16">Fax:</TD>
          <TD>00971 4 224 2900</TD>
        </TR>
        <TR>
          <TD height="16">Email:</TD>
          <TD><A href="mailto:nasser@ticketmastersme.com">nasser@ticketmastersme.com</A> </TD>
        </TR>
    </table>      <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
';
$sqlch="select *  from `ticketma_ticketdbff_events` ";
$resultch=mysql_query($sqlch);
$count=0;
while ($rowch=mysql_fetch_array($resultch))
{

$name=$rowch['event_name'];
$ch=$HTTP_POST_VARS[$name];
if ($ch!="")
{
$event_id[$count]=$ch;$count++;
}
}
$strFrom="info@TicketMastersMe.com";
$i=0;
$sql="select distinct(email)  from ticketma_ticketdbff_emails_table,ticketma_ticketdbff_link_table where (email_num=e_id)and(allow_in=1)and((event_num=".$event_id[$i].")";
for( $i=1 ;$i<$count ;$i++)
{
$sql.="or (event_num=".$event_id[$i].")";
}
$sql.=")";
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
{

/*mail ( string to, string subject, string message [, string additional_headers [, string additional_parameters]] )   */
@mail("".$row['email']."","".$title.""," ".$message."","From:".$strFrom."\r\nReply-to: ".$strFrom."\r\nContent-type: text/html; charset=us-ascii");
}


echo "Message Send .....!";
?>
  </span></em>.<span>
                                                                                                                                                                                                                                                                    </center>
                          <span class="style3"><br>
                          <br>
                          <center>

                          <center class="style3"> </center>
                          </td>
                      </tr>
                      <tr>
                        <td height="75" bgcolor="#E8E8E8"><div align="center" class="style3"><a href="../../../phpdev/www/form4/admin/index.php">Admin Page</a></div></td>
                      </tr>
                      <tr>
                        <td height="75">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="1" valign="top" background="../../../phpdev/www/form4/admin/images/up-dot.gif"><img src="../../../phpdev/www/form4/admin/images/up-dot.gif" width="1" height="3" /></td>
                  <td width="130" valign="top"><div align="center"></div></td>
                </tr>
              </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><?php require("footer.php"); ?>
                    &nbsp;</td>
                </tr>
            </table></td>
      </tr>
    </table>
       </td>
  </tr>
</table>
</body>
</html>