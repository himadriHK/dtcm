<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);

?>
<html>
<head>
<title><?require"title.php";?></title>
<link href="events.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3"><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif" bgcolor=<?echo"$contentbg";?>><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td width="850" align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Venue edit </b></font><br>
<?
$result = mysql_query( "SELECT * FROM tblvenue where venueid=$venueid");
$num_fields = mysql_num_rows ($result);		
while($row = mysql_fetch_array($result)) 
		{   
		 
   
   $venueid=$row[0];
   $catid=$row[1];
   $image=$row[2];
   //$title=$row[3];
   $description=$row[4];
}
?>
      <form ENCTYPE=multipart/form-data method="post" action="viewphoto.php">
	  <?
	  	echo"<input type=hidden name=more value=$catid>";
			  	echo"<input type=hidden name=venueid value=$venueid>";
	  ?>
        <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4F4F4">
          <tr valign="top"> 
            <td width="24%" bgcolor="#F0F0F0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300"> 
              <?echo"<input type=hidden name=eventid value=$eventid>";?>
              </font></td>
            <td> 
              <textarea name="image"><?echo"$image";?></textarea>            </td>
            <td> 
              <input type="file" name="userfile">            </td>
          </tr>
          <tr valign="top"> 
            <td width="24%" bgcolor="#F0F0F0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Description</font></td>
            <td colspan="2"> 
              <textarea name="description"><?echo"$description";?></textarea>            </td>
          </tr>
          <tr valign="bottom" align="center"> 
            <td colspan="3" height="40"> 
              <input type="submit" name="update" value="Update">            </td>
          </tr>
        </table>
      </form>
    <br>    </td>
  </tr>
</table>
</body>
</html>
