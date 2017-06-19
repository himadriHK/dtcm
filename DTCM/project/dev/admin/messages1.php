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
                        <td height="19">&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="59%"><div align="left">Message title </div></td>
        <td width="31%"><div align="center">Last Update  </div></td>
        <td width="10%">&nbsp;</td>
      </tr>
    <?php  
	require("connection3.php");
	
	$sql="select * from  ticketma_ticketdbff_messages order by message_date desc" ;
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result))
	{
	
	echo"<tr><td><div align='left'>".$row['message_title']."</div></td>
         <td ><div align='center'>".$row['message_date']." </div></td>
         <td ><div align='center'><a href=\"newmessage.php?edit=1&amp;message_id=".$row['message_id']."
	\">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?delete=1&amp;messagedelete_id=".$row['message_id']."
	\">Delete</a></div></td></tr>";}
	  ?>
    </table></td>
  </tr>
                      <tr>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
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
