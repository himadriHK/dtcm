<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);

if($yes)
{

	$query = "Delete from tblvenuecategory where catid=$del";
	mysql_query($query);
}

if($update)
{

	
	if($userfile=="none")
		{
			$query_up = "UPDATE tblvenuecategory SET category='$category',image='$image' where catid=$catid";
			mysql_query($query_up);	
		}
	else
		{			
			if (@copy ($userfile,"../venueimages/".$userfile_name))
			{
				//echo"Image Copied";
			}
			
						
			$query_up = "UPDATE tblvenuecategory SET category='$category',image='$userfile_name' where catid=$catid";
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
    <td width="200" valign="top" bgcolor=<?echo"$contentbg";?>><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>View 
      Venue Category</b></font><br>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
        
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="18%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Image</font></b></td>
          <td width="20%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Category</font></b></td>
          <td width="10%" height="19" align="center"> </td>
          <td width="11%" height="19" align="center"> </td>
        </tr>
        <?
$query1= "SELECT * FROM tblvenuecategory";
$sqresult = mysql_query($query1);
while ($myrow = mysql_fetch_row($sqresult))
{
$catid=$myrow[0];
$category=$myrow[1];
$image=$myrow[2];
   
?>
        <tr valign="top"> 
          <td width="18%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            <?echo"<img src=../venueimages/$image border=0 height=107 width=140>";?>
            </font></td>
          <td width="20%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            <?echo"$category";?>
            </font></td>
          <td width="10%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#CC3300"> 
            <?echo"<a href=venuecategoryedit.php?catid=$catid><font color=#cc3300>Edit</font></a>";?>
            </font></td>
          <td width="11%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#CC3300"> 
            <?echo"<a href=venuecategorydel.php?del=$catid><font color=#cc3300>Delete</font></a>";?>
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
    </table>    </td>
  </tr>
</table>
</body>
</html>

