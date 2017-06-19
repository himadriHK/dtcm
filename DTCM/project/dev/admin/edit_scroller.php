<?php
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
	?>
	
	<?php
	
	$file_path=$_SERVER['DOCUMENT_ROOT'];
	//echo $file_path;
	
	if(isset($_POST['edit']))
	{
	$query_guidecatRs = "SELECT * FROM `scroller` where id=".$_REQUEST['bid'];
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
$banner= mysql_fetch_array($guidecatRs);
	$image=$file_path.$banner['image'];
	$url=addslashes($_POST['url']);
	$title=$_POST['title'];
	$tmp_path=$_FILES['upload'][tmp_name];
	$image = $_FILES['upload']['type'];
	   $img_name= $_FILES['upload']['name'];
	   
	 $img_path="/scroller/$img_name";
	
	$sqlstmt= "UPDATE scroller SET url='$url',title='$title' WHERE id=".$_REQUEST['bid'];
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	
	
	   
	  if(is_uploaded_file($_FILES['upload'][tmp_name]))
	  {
	      @unlink($image);
	       
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	        $sqlstmt= "UPDATE scroller SET image='$img_path' WHERE id=".$_REQUEST['bid'];
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	  
	       }
	  
	  }
	 
	  
	
	}
	
$query_guidecatRs = "SELECT * FROM `scroller` where id=".$_GET['id'];
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
$banners= mysql_fetch_array($guidecatRs);

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
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Scroller
      Image Setting</b></font><br>
      <a href="scroller_list.php">View List</a>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
        <form method="post" action="#" enctype="multipart/form-data">
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Image</font></b></td>
         <td width="10%" height="19" align="center">Image Title</td>
         <td width="10%" height="19" align="center">Image Url</td>
              <td width="10%" height="19" align="center">Action</td>
          
        </tr>
        
        <tr valign="top"> 
          <td width="30%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            <img src="<?php echo $banners['image'];?>" border='0' height='107' width='240'>
            
            </font>
            <input type="file" name="upload" valign="middle"/></td>
            </td>
            <td align="center" valign="middle" width="42%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <input type="text" style="width:402px;" name="title" value="<?php echo stripslashes($banners['title']);?>" /> 
        </td>
             <td align="center" valign="middle" width="42%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <input type="text" style="width:402px;" name="url" value="<?php echo stripslashes($banners['url']);?>" /> 
            <input type="hidden" name="bid" value="<?php echo $_GET['id']; ?>"/>
        </td>
           
            <td align="center" valign="middle" width="10%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <input type="Submit" name="edit" value="Edit" > 
        </td>
        </tr>
       


      </table>
      </form
         </td>
  </tr>
</table>
</body>
</html>