<?php
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
	?>
	
	<?php
	$file_path=$_SERVER['DOCUMENT_ROOT'];
	//echo $file_path;
	if(isset($_GET['id'])){
	$sqlstmt= "delete from scroller WHERE id=".$_GET['id'];
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	}
	if(isset($_POST['edit1']))
	{
	$url=addslashes($_POST['url']);
	$status=$_POST['status'];
	$sqlstmt= "UPDATE scroller SET url='$url',status='$status' WHERE id=1";
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	//print_r($_FILES);
	$image = $_FILES['upload']['type'];
	   $img_name= $_FILES['upload']['name'];
	    
	       $img_path="/new_design/scroller/$img_name";
	       $h_time=time();
	  if(is_uploaded_file($_FILES['upload'][tmp_name]))
	  {
	      
	       $tmp_path=$_FILES['upload'][tmp_name];
	      
	       
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	         $sqlstmt= "UPDATE scroller SET image='$img_path' WHERE id=1";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	         if($data)
	         {
	           echo "file is suceesfully updated";
	         }
	       }
	  
	  }
	 
	  
	
	}
	
$query_guidecatRs = "SELECT * FROM `scroller` order by id desc";
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());

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
    <td width="1" valign="top" background="../images/up-dot.gif">
    <img src="../images/up-dot.gif" width="1" height="3"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Scroller
      Image Setting
      </b></font><br>
      <a href="add_scroller.php">Add Image</a>
    
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
       
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Image</font></b></td>
           <td width="10%" height="19">Title</td>
           <td width="10%" height="19" align="center">Image link</td>
              <td width="10%" height="19" align="center">Action</td>
          
        </tr>
        <?php while($banner= mysql_fetch_array($guidecatRs)) { ?>
        <tr valign="top"> 
          <td width="30%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            <img src="<?php echo $banner['image'];?>" border='0' height='107' width='540'>
            
            </font>
            
            </td>
            <td width="20%" align="center" valign="middle"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
           <?php echo $banner['title']; ?>
           </td>
             <td align="center" valign="middle" width="42%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <label><?php echo stripslashes($banner['url']);?></label>
        </td>
            
            <td align="center" valign="middle" width="10%"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <a href="edit_scroller.php?id=<?php echo $banner['id']; ?>" target="_blank">Edit</a>&nbsp;|&nbsp;
            <a href="scroller_list.php?id=<?php echo $banner['id']; ?>" onclick="confirm('Are you want to delete this banner?')">Delete</a>
        </td>
        </tr>
       <?php  } ?>


      </table>
      
         </td>
  </tr>
</table>
</body>
</html>