<?php
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
	?>
	
	<?php
	$file_path=$_SERVER['DOCUMENT_ROOT'];
	//echo $file_path;
	$query_guidecatRs = "SELECT * FROM `banners`";
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
$banners= mysql_fetch_array($guidecatRs);
	if(isset($_POST['edit']))
	{
	$url=addslashes($_POST['h_url']);
	$status=$_POST['h1_status'];
	$sqlstmt= "UPDATE banners SET h_url='$url',h1_status='$status' WHERE id=1";
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	$image = $_FILES['upload']['type'];
	   $img_name= time().$_FILES['upload']['name'];
	       $img_path="/img/$img_name";
	       $h_time=time();
	         $status=$_POST['status'];
	  if(is_uploaded_file($_FILES['upload'][tmp_name])&& $image=="image/jpeg")
	  {
	       @unlink($_SERVER['DOCUMENT_ROOT'].$banners['h_image']);
	       $tmp_path=$_FILES['upload'][tmp_name];
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	         $sqlstmt= "UPDATE banners SET h_image='$img_path',status='$status',h_time='$h_time' WHERE id=1";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	       }
	  }else{
	     
	       $sqlstmt= "UPDATE banners SET status='$status',h_time='$h_time' WHERE id=1";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	  }
	  $url=addslashes($_POST['h1_url']);
	  $status=$_POST['h2_status'];
	$sqlstmt= "UPDATE banners SET h1_url='$url',h2_status='$status' WHERE id=1";
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	$image = $_FILES['upload1']['type'];
	   $img_name= time().$_FILES['upload1']['name'];
	       $img_path="/img/$img_name";
	  if(is_uploaded_file($_FILES['upload1'][tmp_name])&& $image=="image/jpeg")
	  {
	       @unlink($_SERVER['DOCUMENT_ROOT'].$banners['h1_image']);
	       $tmp_path=$_FILES['upload1'][tmp_name];
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	         $sqlstmt= "UPDATE banners SET h1_image='$img_path',status='$status',h_time='$h_time' WHERE id=1";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	       }
	  }
	  $url=addslashes($_POST['h2_url']);
	  $status=$_POST['h3_status'];
	$sqlstmt= "UPDATE banners SET h2_url='$url',h3_status='$status' WHERE id=1";
	   $data=mysql_query($sqlstmt)or die(mysql_error());
	$image = $_FILES['upload2']['type'];
	   $img_name= time().$_FILES['upload2']['name'];
	       $img_path="/img/$img_name";
	  if(is_uploaded_file($_FILES['upload2'][tmp_name])&& $image=="image/jpeg")
	  {
	       @unlink($_SERVER['DOCUMENT_ROOT'].$banners['h2_image']);
	       $tmp_path=$_FILES['upload2'][tmp_name];
	       if(move_uploaded_file($tmp_path,$file_path.$img_path))
	       {
	         $sqlstmt= "UPDATE banners SET h2_image='$img_path',status='$status',h_time='$h_time' WHERE id=1";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	       }
	  }
     }
	
$query_guidecatRs = "SELECT * FROM `banners`";
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
$banners= mysql_fetch_array($guidecatRs);
$checked1=($banners['status']=='ON')?'checked':'';
$checked2=($banners['status']=='OFF')?'checked':'';

$checked11=($banners['h1_status']=='ON')?'checked':'';
$checked21=($banners['h1_status']=='OFF')?'checked':'';

$checked12=($banners['h2_status']=='ON')?'checked':'';
$checked22=($banners['h2_status']=='OFF')?'checked':'';

$checked13=($banners['h3_status']=='ON')?'checked':'';
$checked23=($banners['h3_status']=='OFF')?'checked':'';
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
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300"><b>Header
      Image Setting</b></font><br>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
        <form method="post" action="#" enctype="multipart/form-data">
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19" align="center" ><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Image</font></b></td>
          <td width="10%" height="19" align="center">Image link</td>
           <td width="10%" height="19" align="center" ><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Availability</font></b></td>
          <td width="10%" height="19" align="center" ><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">Status</font></b></td>
              <td width="10%" height="19" align="center">Action</td>
          
        </tr>
        
        <tr valign="top"> 
          <td>
            <img src="<?php echo $banners['h_image'];?>" border='0' height='107' width='200'>
            <input type="file" name="upload" valign="middle"/>
             <img src="<?php echo $banners['h1_image'];?>" border='0' height='107' width='200'>
            <input type="file" name="upload1" valign="middle"/>
             <img src="<?php echo $banners['h2_image'];?>" border='0' height='107' width='200'>
            <input type="file" name="upload2" valign="middle"/>
            
            </td>
             <td align="center" valign="middle" width="42%">
              <ul>
                <li style="margin-top:-4px;"> <input type="text" style="width:402px;" name="h_url" value="<?php echo stripslashes($banners['h_url']);?>" /> </li>
                <li style="margin-top:121px;"> <input type="text" style="width:402px;" name="h1_url" value="<?php echo stripslashes($banners['h1_url']);?>" /> </li>
               <li style="margin-top:100px;"> <input type="text" style="width:402px;" name="h2_url" value="<?php echo stripslashes($banners['h2_url']);?>" /> </li>
             </ul>
           </td>
            <td align="center" valign="middle" width="42%">
              <ul>
                <li style="margin-top:-4px;">  <input type="radio" name="h1_status" <?php echo $checked11;?> value="ON">ON
           <input type="radio" name="h1_status"  <?php echo $checked21;?> value="OFF">OFF </li>
           
                <li style="margin-top:121px;">  <input type="radio" name="h2_status" <?php echo $checked12;?> value="ON">ON
           <input type="radio" name="h2_status"  <?php echo $checked22;?> value="OFF">OFF </li>
           
               <li style="margin-top:100px;">  <input type="radio" name="h3_status" <?php echo $checked13;?> value="ON">ON
           <input type="radio" name="h3_status"  <?php echo $checked23;?> value="OFF">OFF </li>
             </ul>
           </td>
            <td width="20%" align="center" valign="middle"><font color="#CC3300" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
           <input type="radio" name="status" <?php echo $checked1;?> value="ON">ON
           <input type="radio" name="status"  <?php echo $checked2;?> value="OFF">OFF
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