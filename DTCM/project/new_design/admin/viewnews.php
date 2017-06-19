<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);

if($yes)
{

	$query = "Delete from tblnews where newsid=$del";
	mysql_query($query);
}
if($update)
{
	if($userfile=="none")
		{
		$query_up = "UPDATE tblnews SET title='$title', date='$date',month='$month', year='$year', image='$image', description='$description' where newsid=$newsid";
		mysql_query($query_up);
		}
	else
		{
		if (@copy ($userfile,"../images/".$userfile_name))
		{
		//echo"Image Copied";
		}
		$query_up = "UPDATE tblnews SET title='$title', date='$date',month='$month', year='$year', image='$userfile_name', description='$description' where newsid=$newsid";
		mysql_query($query_up);
		}	
}
?>
<html>
<head>
<title><?require"title.php";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?require("head.php");?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr> 
    <td width="200" valign="top"><?require("contents.php");?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> <br>
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#eeeeee">
        <tr bgcolor="#F2F2F2" align="center"> 
          <td colspan="6" height="19"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#999999"><font color="#FF9900">VIEW 
            NEWS</font></font></b></font></td>
        </tr>
        <tr bgcolor="#F2F2F2"> 
          <td width="18%" height="19" bgcolor="#F2F2F2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Title</font></td>
          <td width="24%" height="19" bgcolor="#F2F2F2"><font face="Verdana, Arial, Helvetica, sans-serif" color="#000066" size="2">Date</font></td>
          <td width="33%" height="19" bgcolor="#F2F2F2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Description</font></td>
          <td width="12%" height="19">&nbsp;</td>
          <td width="7%" height="19">&nbsp;</td>
          <td width="6%" height="19">&nbsp;</td>
        </tr>
        <?
$result = mysql_query( "SELECT * FROM tblnews order by date desc");
$num_fields = mysql_num_rows ($result);		
while($row = mysql_fetch_array($result)) 
		{   
		 
   $newsid=$row[newsid];
   $title=$row[title];
   $image=$row[image];
   $date=$row[date];
   $month=$row[month];
   $year=$row[year];
   $description=$row[description];	
   $description = substr($description, 0, 25);											                
   
?>
        <tr valign="top"> 
          <td width="18%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066"> 
            <?echo"<font color=#000066>$title</font>";?>
            </font></td>
          <td width="24%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066"> 
            <?echo"$date-$month,$year";?>
            </font></td>
          <td width="33%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066"> 
            <?
			  	  echo"$description....";
			  ?>
            </font></td>
          <td width="12%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066"> 
            <?
              if($image!="")
              {
              echo"<img src=../images/$image border=0 width=90 height=115>";
              }
              ?>
            </font></td>
          <td width="7%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"> 
            <?echo"<a href=newsedit.php?newsid=$newsid><font color=#ff3300>Edit</font></a>";?>
            </font></td>
          <td width="6%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"> 
            <?echo"<a href=newsdel.php?del=$newsid><font color=#ff3300>Delete</font></a>";?>
            </font> </td>
        </tr>
        <?
}
?>
      </table>    </td>
  </tr>
</table>
</body>
</html>
