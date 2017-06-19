<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);


if($save)
{
	if($project=="" || $title=="")
	{
		echo"<b><font color=red>Please Enter Required Field</font></b>";
	}
else
	{
		if (@copy ($userfile,"../images/".$userfile_name))
		{
		//echo"Image Copied";
		}
		if (@copy ($userfile2,"../images/".$userfile2_name))
		{
		//echo"Image Copied";
		}

			
	$result1 = mysql_query( "SELECT * FROM tblproject where project='$project' and title='$title'");
	$num_row = mysql_num_rows ($result1);			
	
		
	if($num_row == 0)
		{
		
		$query = "insert into tblproject(project,title,city,date,description,image,file)values('$project','$title','$city','$date','$description','$userfile_name','$userfile2_name')";
		mysql_query($query);		
		echo"<font color=red size=4 face=verdana>Project Details Added.</font>";	
		}

	else
		{
		echo"<font color=red size=4 face=verdana>Project Details already exist.</font>";
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
    <td width="850" height="22" align="center">
      <form enctype=multipart/form-data method="post" action="<?echo"$PHP_SELF";?>">
        <br>
        <table width="70%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F5F5F5">
          <tr bgcolor="#C0C0C0" align="center"> 
            <td colspan="2" valign="top" height="25"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#CC3300">ADD 
              PROJECT DETAIL</font></b></font></td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Project</font></td>
            <td width="69%"> 
              <input type="text" name="project">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Title</font></td>
            <td width="69%"> 
              <input type="text" name="title">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">City</font></td>
            <td width="69%"> 
              <input type="text" name="city">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Date 
              of Project</font></td>
            <td width="69%"> 
              <input type="text" name="date">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Image</font></td>
            <td width="69%"> 
              <input type="file" name="userfile">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Project 
              Info File</font></td>
            <td width="69%"> 
              <input type="file" name="userfile2">            </td>
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
          <tr align="center" valign="bottom"> 
            <td colspan="2" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="viewproject.php"><font color="#CC3300">View 
              Projects </font></a></font></td>
          </tr>
        </table>
      </form>    </td>
  </tr>
</table>
</body>
</html>
