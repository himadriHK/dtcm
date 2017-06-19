<?

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?require("title.php");?></title>
<link href="events.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script language="javascript">
function checkform()
{ 
var b=false;
for(var i = 0; i < form1.length; i++) {

        var e = form1.elements[i];
         
        if (e.type=="checkbox")  

           //  check choose events 
        {if (e.checked){ b=true;break;}}
                       }
                     
if (b!=true)
{ 
alert("You Don't choose any group to send Message");
return false;} 
else return true;

}
</script>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php
  require("connection3.php");
  $sql="select * from `ticketma_ticketdbff_events` ";
  $result=mysql_query($sql);
  require("head.php");

  ?></td>
          </tr>
        </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="160" valign="top"><div align="center"></div>
                      <?php  require("contents.php"); ?>			</td>
                  <td width="1" valign="top" background="images/up-dot.gif"><img src="images/up-dot.gif" width="1" height="3" /></td>
                  <td valign="top">
				  <table width="100%" border="0" cellspacing="1" cellpadding="0">
				  <form name="form1" method="post" action="sendmessage.php" onSubmit="return checkform()">
                      <tr align="center">
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="5" bgcolor="#C31600">&nbsp;</td>
                              <td height="30" bgcolor="#C31600"><span class="eventHeader">NEWSLETTER
							  		  <?php 
	require("connection3.php");
	
	
	$submit=$HTTP_POST_VARS['submit'];
	
	if (isset($submit)) 
	{
	
	$title=$HTTP_POST_VARS['mtitle'];
	$message=$HTTP_POST_VARS['message'];
	$edit_id=$HTTP_POST_VARS['edit_id'];
    
	
	if(isset($edit_id))
	{
	if($edit_id==0)
	{
	
	$sql="select max(message_id) + 1 as max_id from ticketma_ticketdbff_messages "  ; 
	     $Max = mysql_query($sql);
      $Max_Ordre = mysql_fetch_array($Max);
      $message_id = $Max_Ordre["max_id"];
     if($message_id == null)
     {
     $message_id = 1;
     }
	 
	 $sql="insert into ticketma_ticketdbff_messages (message_id,message_title,message_content,message_date) values (".$message_id.",'". $title."','".$message."',
	 '".date("y/m/d")."')";
	  mysql_query($sql);}
	  else
	  {
	  $message_id=$edit_id;
	  $sql="update ticketma_ticketdbff_messages SET   message_title='".$title."',message_content='".$message."',message_date='".date("y/m/d")."'
	  where message_id='".$message_id."'";
	   mysql_query($sql);
	  }
	  
	  }}
	
	  $delete=$HTTP_GET_VARS['delete'];
	  $delete_id=$HTTP_GET_VARS['messagedelete_id'];
	  if (isset($delete_id)&& isset($delete))
	  {$sql="delete from ticketma_ticketdbff_messages where message_id ='".$delete_id."'";
	  mysql_query($sql);
	  }?>
	  </span>							 </td>
                            </tr> 
				<?php if ($submit=="send")		
				echo'<tr>
                 <td width="20" background="images/faselm1n.png"></td>
                 <td height="30" background="images/faselm1n.png"><span class="eventHeader">
				 <input type="submit" name="Send Message...!" value="Send Message...!">
                 <input type="hidden" name="message_id" value="'.$message_id.'"> 
                 </td>
                   </tr> 
			<tr><td width="20" ></td><td height="30" >';?>
    <?php
if ($submit=="send")
	  {
	  
	  echo '<table width="100%" border="0" cellspacing="1" cellpadding="0">';            
	 $sql="select * from ticketma_ticketdbff_events` ";
      $result=mysql_query($sql);
                        echo "<tr>";
                        $i=0;
                        while($row=mysql_fetch_array($result))
                        {
                          echo"<td width='20' height='20'><input type='checkbox' name='".$row['event_name']."' value='".$row['event_id']."' /></td>
                          <td bgcolor='#F3F3F3'><p class='formField'>".$row['event_name']."</p></td>";
                          $i++;
                          if ($i%3==0) echo "</tr><tr>";
                         }
        echo "</td></tr></table>";                
	  } 
	  ?>
                            
                        </table></td>
                      </tr>
                      <tr>
                        <td width="96%">
						
						
<!-- Main table User to Display Emails-->
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor='#CAD0CE'>

	<?php 
    $sql="select * from  ticketma_ticketdbff_emails_table order by e_date desc" ;
	$result=mysql_query($sql);
	
	
		while($row=mysql_fetch_array($result))
	{
    $linksql="select * from  ticketma_ticketdbff_link_table where email_num=".$row['e_id']." " ;
	$linkresult=mysql_query($linksql);
	$name="";
	while($linkrow=mysql_fetch_array($linkresult))
	{
	if($linkrow['event_num']<10) $name="".$name."0".$linkrow['event_num'];
	else $name="".$name."".$linkrow['event_num']."";
	}

echo"
<tr >
  <td width='65%'><em>Name : ".$row['first']." ".$row['last']."</em></td>
  <td width='35%'><em>Age : ".$row['age']."</em></td>
</tr>
<tr>
  <td colspan='2'><em>Country : ".$row['Country']."</em></td>
</tr>
<tr>
  <td><em>Org :".$row['organization']." </em></td>
  <td><em>Position :".$row['position']."</em></td>
</tr>
<tr>
  <td><em>Email :  ".$row['email']."</em></td>
  <td><em>Tel: ".$row['tel']."</em></td></tr> 
  <tr bgcolor='#FFFFFF' height=10>
  
  <td colspan='2'><em></em></td></tr> 
  ";}	?>				  
   </table>   </td>
                      </tr>
                      <tr>
                        <td>&nbsp;		</td>
                      </tr>
				    </form>
                  </table></td>
                  <td width="1" valign="top" background="images/up-dot.gif"><img src="images/up-dot.gif" width="1" height="3" /></td>
                </tr>
              </table>
          </td>
      </tr>
    </table>
      </td>
  </tr>
</table>
</body>
</html>
