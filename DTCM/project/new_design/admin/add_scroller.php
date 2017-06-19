<?php
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

	$file_path=$_SERVER['DOCUMENT_ROOT'];
	//echo $file_path;
	
	if(isset($_POST['add']))
	{
	$url=addslashes($_POST['url']);
	
	$image = $_FILES['upload']['type'];
	   $img_name= $_FILES['upload']['name'];
	 $img_path="/new_design/scroller/$img_name";
	 $insertSQL = sprintf("INSERT INTO scroller (title, image, url) VALUES (%s, %s, %s)",

                       GetSQLValueString($_POST['title'], "text"),

                       GetSQLValueString($img_path, "text"),

		       GetSQLValueString($url, "text"));
	$Result1 = mysql_query($insertSQL) or die(mysql_error());
	 
	      
	      
	  if(is_uploaded_file($_FILES['upload'][tmp_name]))
	  {
	      
	       $tmp_path=$_FILES['upload'][tmp_name];
	      
	       
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	           header("location: scroller_list.php");                
	         
	       }
	  
	  }
	 
	  
	
	}
	
//$query_guidecatRs = "SELECT * FROM `scroller`";
//$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
//$banners= mysql_fetch_array($guidecatRs);

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
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Add
      Image </b></font><br>
      <a href="scroller_list.php">View List</a>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
        <form method="post" action="#" enctype="multipart/form-data">
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19">Image Title</td>
          
           <td width="70%" height="19" align="center"><input style="width:400px;" type="text" name="title" ></td>
          
        </tr>
         <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19">Upload Image</td>
          
           <td width="70%" height="19" align="center"><input style="width:400px;" type="file" name="upload" ></td>
        </tr>
    </tr>
         <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19">Image url</td>
          
           <td width="70%" height="19" align="center"><input style="width:400px;" type="text" name="url" ></td>
          
        </tr>
        <tr><td colspan="2" align="center"><input type="submit" name="add" value="Add"/></td></tr>
      </table>
      </form>
         </td>
  </tr>
</table>
</body>
</html>