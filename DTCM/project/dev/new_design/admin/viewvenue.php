<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);

if($yes)
{

	$query = "Delete from tblvenue where venueid=$del";
	mysql_query($query);
}

if($update)
{

	
	if($userfile=="none")
		{
			$query_up = "UPDATE tblvenue SET description='$description',image='$image' where venueid=$venueid";
			mysql_query($query_up);	
		}
	else
		{			
			if (@copy ($userfile,"../venueimages/".$userfile_name))
			{
				//echo"Image Copied";
			}
			
						
			$query_up = "UPDATE tblvenue SET description='$description',image='$userfile_name' where venueid=$venueid";
			mysql_query($query_up);
			
		}
	
}


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
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>View 
      Photo </b></font><br>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	  
  	<?
$query1= "SELECT * FROM tblvenuecategory";
$sqresult = mysql_query($query1);
while ($myrow = mysql_fetch_row($sqresult))
{
$catid=$myrow[0];
$pcategory=$myrow[1];
$catimage=$myrow[2];

     echo"<td align=center><a href=$PHP_SELF?more=$catid><font face=verdana size=1 color=#cc3300><img src=../venueimages/$catimage border=0 width=75 height=75></font></a><br>";
     echo"<a href=$PHP_SELF?more=$catid><font face=verdana size=1 color=#cc3300>$pcategory</font></a></td>";

}
?>
	</tr>
      </table>
      <br>
	 <?
	 if($more)
	 {
	 ?>
<form action=<?echo"$PHP_SELF";?> method=post>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
          <tr bgcolor="#CCCCCC"> 
            <td width="18%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Image</font></b></td>
            <td width="41%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Description</font></b></td>
            <td width="10%" height="19" align="center"> </td>
            <td width="11%" height="19" align="center"> </td>
          </tr>
          <?
$result = mysql_query( "SELECT * FROM tblvenue where catid=$more");
$num_fields = mysql_num_rows ($result);		
while($row = mysql_fetch_array($result)) 
		{   
		 
   
   $venueid=$row[0];
   $catid=$row[1];
   $image=$row[2];
   //$title=$row[3];
   $description=$row[4];
   
?>
          <tr valign="top"> 
            <td width="18%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?echo"<img src=../venueimages/$image border=0 height=75 width=75>";?>
              </font></td>
            <td width="41%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?echo"$description";?>
              </font></td>
            <td width="10%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#CC3300"> 
              <?echo"<a href=venueedit.php?venueid=$venueid><font color=#cc3300>Edit</font></a>";?>
              </font></td>
            <td width="11%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#CC3300">
              <?echo"<a href=venuedel.php?del=$venueid&more=$more><font color=#cc3300>Delete</font></a>";?>
              </font> </td>
          </tr>
          <?
}
?>
        </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
            <td align="right">  </td>
        </tr>
      </table>
</form>
<?}?>    </td>
  </tr>
</table>
</body>
</html>

