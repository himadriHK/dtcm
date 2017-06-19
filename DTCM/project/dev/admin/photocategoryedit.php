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
    <td><?php require("head.php"); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td width="850" align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Edit 
      Photo Category</b></font><br>
<?
$query1= "SELECT * FROM tblphotocategory where catid=$catid";
$sqresult = mysql_query($query1);
while ($myrow = mysql_fetch_row($sqresult))
{
$catid=$myrow[0];
$category=$myrow[1];
$image=$myrow[2];
}
?>
      <form ENCTYPE=multipart/form-data method="post" action="viewphotocategory.php">
        <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4F4F4">
          <tr valign="top"> 
            <td width="24%" bgcolor="#F0F0F0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300"> 
              <?echo"<input type=hidden name=catid value=$catid>";?>
              </font></td>
            <td> 
              <textarea name="image"><?echo"$image";?></textarea>            </td>
            <td> 
              <input type="file" name="userfile">            </td>
          </tr>
          <tr valign="top"> 
            <td width="24%" bgcolor="#F0F0F0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Category</font></td>
            <td colspan="2"> 
              <textarea name="category"><?echo"$category";?></textarea>            </td>
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
