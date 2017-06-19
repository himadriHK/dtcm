<?php
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
	 $url=$_SERVER['DOCUMENT_ROOT'];
	 
	if($_REQUEST['id'])
	{
	 $id=$_REQUEST['id'];
	
	 $sqldel="DELETE FROM subscribes WHERE id=$id";
	 if(mysql_query($sqldel))
	 {
	  
	   header("Location:/admin/Subscription_list.php");
	   
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
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3">
    <img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300">
    <b>Subscription List</b></font><br>
    <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   
        <form method="post" action="#">
      <table width="98%" border="" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="5%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif"  size="2">ID</font></b></td>

          <td width="20%" height="19" align="center">Email</td>
          
          <td width="20%" height="19" align="center">Country</td>
          
          <td width="20%" height="19" align="center">Phone</td>
          
          <td width="20%" height="19" align="center">Time</td>
          
          <td width="20%" height="19" align="center">Action</td>
          
        </tr>
        <?php
        $sqlstmt= "SELECT * FROM subscribes";
	         $data=mysql_query($sqlstmt)or die(mysql_error());
	         if($data)
	         {
	          
	         while($record=mysql_fetch_array($data))
	         {
	         
          echo "<tr>";
          echo "<td id='td1'>$record[0]</td><td>$record[2]</td><td>$record[1]</td><td>$record[3]</td><td>".date('Y/m/d H:i',$record[4])."</td><td><a href='/new_design/admin/Subscription_list.php?id=".$record[0]."' title='Delete' style='text-align:center;'>Delete</a></td>";
         echo "</tr>";
        }
         
        }
       ?>


      </table>
      </form>
         </td>
  </tr>
</table>
   
    </body>
    </html>
    
   