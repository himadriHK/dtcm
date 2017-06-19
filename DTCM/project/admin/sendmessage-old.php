<?

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?require("title.php");?></title>
<link href="events.css" rel="stylesheet" type="text/css" />

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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php
  require("connection3.php");
  $sql="select * from `ticketma_ticketdbff_events` ";
  $result=mysql_query($sql);
  require("head.php");

  ?></td>
          </tr>
        </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="160" valign="top"><div align="center"></div>
                      <?php  require("contents.php"); ?></td>
                  <td width="1" valign="top" background="images/up-dot.gif"><img src="images/up-dot.gif" width="1" height="3" /></td>
                  <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="5" bgcolor="#C31600">&nbsp;</td>
                              <td height="30" bgcolor="#C31600"><span class="eventHeader">NEWSLETTER</span></td>
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
require("connection3.php");

$message_id=$HTTP_POST_VARS['message_id'];
$sql="select *  from `ticketma_ticketdbff_messages` where (message_id=".$message_id.")";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-style: italic;
	font-weight: bold;
	color: #333333;
}
-->
</style>
</head>

<body>
<table width="100%" height="600" border="0" align="center">
  <tr>
    <td width="15%" height="54" bgcolor="#CCCCCC"> <span class="style1">Ticket Masters </span></td>
    <td width="85%" bgcolor="#CCCCCC"><span class="style1"><img src="images/logo.jpg" width="200" height="100" /></span></td>
  </tr>
  <tr>
    <td height="285" colspan="2"';
$title=$row['message_title'];
$message.=$row['message_content'];
$message.='</td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="left" bgcolor="#CCCCCC"><div align="center"><a href="www.ticketmastersme.com">www.TicketMastersMe.com</a></div></td>
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
$strFrom="info@ticketmastersme.com";
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

                          <center class="style3"> </center>                        </td>
                      </tr>
                      <tr>
                        <td height="75" bgcolor="#E8E8E8"><div align="center" class="style3"><a href="index.php">Admin Page</a></div></td>
                      </tr>
                      <tr>
                        <td height="75">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="1" valign="top" background="images/up-dot.gif"><img src="images/up-dot.gif" width="1" height="3" /></td>
                </tr>
              </table>
          </td>
      </tr>
    </table>
      </td>
  </tr>
</table>
</body>
</html>