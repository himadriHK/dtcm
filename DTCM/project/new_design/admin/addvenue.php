<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);

if($save)
{
	if($userfile=="none")
	{
		echo"<b><font color=red>Please Browse Image</font></b>";
	}
else
	{
		
	$result1 = mysql_query( "SELECT * FROM tblvenue where image='$image'");
	$num_row = mysql_num_rows ($result1);			
	
		
	if($num_row == 0)
		{
		if (@copy ($userfile,"../venueimages/".$userfile_name))
	{
	//echo"Image Copied";

}
		$query = "insert into tblvenue(catid,description,image)values('$category','$description','$userfile_name')";
		mysql_query($query);		
		echo"<font color=red size=4 face=verdana>Venue Added.</font>";	
		}

	else
		{
		echo"<font color=red size=4 face=verdana>Venue already exist.</font>";
		}
	
	} 
}



if($pc)
{
	if($pcategory=="")
	{
		echo"<b><font color=red>Please Enter Venue Category</font></b>";
	}
else
	{
		
	$result1 = mysql_query( "SELECT * FROM tblvenuecategory where category='$pcategory'");
	$num_row = mysql_num_rows ($result1);			
	
		
	if($num_row == 0)
		{
			if (@copy ($userfile,"../venueimages/".$userfile_name))
			{
			//echo"Image Copied";
			}
		
		$query = "insert into tblvenuecategory(category,image)values('$pcategory','$userfile_name')";
		mysql_query($query);		
		echo"<font color=red size=4 face=verdana>Venue Category Added.</font>";	
		}

	else
		{
		echo"<font color=red size=4 face=verdana>Venue Category already exist.</font>";
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
  
  <tr valign="top">
    <td width="200" bgcolor=<?echo"$contentbg";?>><?php require("contents.php"); ?></td> 
    <td width="1" background="../images/up-dot.gif" bgcolor=<?echo"$contentbg";?>><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center"><form enctype=multipart/form-data method="post" action="<?echo"$PHP_SELF";?>">
        <br>
        <table width="70%" border="0" cellspacing="3" cellpadding="1" align="center">
          <tr>
            <td><table width="100%" border="1" cellspacing="0" cellpadding="1" align="center" bordercolor="#F3F3F3">
                <tr>
                  <td align="center" bgcolor="#C0C0C0" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300"><b>Venue 
                    Gallery Category</b></font></td>
                </tr>
                <tr>
                  <td width="50%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Category</font></td>
                  <td width="50%"><input type="text" name="pcategory">                  </td>
                </tr>
                <tr>
                  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font></td>
                  <td><input type="file" name="userfile2">                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input type="submit" name="pc" value="Save">                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="center" height="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="viewvenuecategory.php"><font color="#CC3300" size="2">View 
                    Venue Category</font></a></font></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000"><b><font size="2">Attention:</font></b> Do not fill data together in both section. If you want to add category, 
              then first add category and then add photo under that category.</font></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="70%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F5F5F5">
          <tr bgcolor="#C0C0C0" align="center"> 
            <td colspan="2" valign="top" height="25"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#CC3300">ADD 
              PHOTO</font></b></font></td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Category</font></td>
            <td width="69%"> 
              <select name="category">
                <?
$query1= "SELECT * FROM tblvenuecategory";
$sqresult = mysql_query($query1);
while ($myrow = mysql_fetch_row($sqresult))
{
$catid=$myrow[0];
$pcategory=$myrow[1];

echo"<option value=$catid>$pcategory</option>";
}
				?>
              </select>            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font></td>
            <td width="69%"> 
              <input type="file" name="userfile">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Decription</font></td>
            <td width="69%"> 
              <textarea name="description" cols="35" rows="6"></textarea>            </td>
          </tr>
          <tr align="center"> 
            <td colspan="2" valign="top"> 
              <input type="submit" name="save" value="Save">
              <input type="reset" name="Submit2" value="Clear">            </td>
          </tr>
          <tr align="center"> 
            <td colspan="2" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="viewvenue.php"><font color="#CC3300">View 
              Photo's </font></a></font></td>
          </tr>
        </table>
      </form>    </td>
  </tr>
</table>
</body>
</html>
