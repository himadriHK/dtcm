<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);


if($pc)
{
	if($pcategory=="")
	{
		echo"<b><font color=red>Please Enter Photo Category</font></b>";
	}
else
	{
		
	$result1 = mysql_query( "SELECT * FROM tblphotocategory where category='$pcategory'");
	$num_row = mysql_num_rows ($result1);			
	
		
	if($num_row == 0)
		{
			if (@copy ($userfile,"../images/".$userfile_name))
			{
			//echo"Image Copied";
			}
		
		$query = "insert into tblphotocategory(category,image)values('$pcategory','$userfile_name')";
		mysql_query($query);		
		echo"<font color=red size=4 face=verdana>Photo Category Added.</font>";	
		}

	else
		{
		echo"<font color=red size=4 face=verdana>Photo Category already exist.</font>";
		}
	
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
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td width="850" height="22" align="center" valign="top"> <br>
      <table width="80%" border="0" cellspacing="3" cellpadding="1" align="center">
        <tr>
          <td>
		    <form action=<?echo"$PHP_SELF";?> method=post enctype="multipart/form-data">
              <table width="75%" border="1" cellspacing="0" cellpadding="1" align="center" bordercolor="#F3F3F3">
                <tr> 
                  <td align="center" bgcolor="#C0C0C0" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300"><b>Photo 
                    Gallery Category</b></font></td>
                </tr>
                <tr> 
                  <td width="50%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Category</font></td>
                  <td width="50%"> 
                    <input type="text" name="pcategory">                  </td>
                </tr>
                <tr> 
                  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font></td>
                  <td>
                    <input type="file" name="userfile">                  </td>
                </tr>
                <tr> 
                  <td colspan="2" align="center"> 
                    <input type="submit" name="pc" value="Save">                  </td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" height="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="viewphotocategory.php"><font color="#CC3300">View 
                    Photo Category</font></a></font></td>
                </tr>
              </table>
	</form>          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>    </td>
  </tr>
</table>
</body>
</html>
