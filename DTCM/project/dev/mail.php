/*<?php
 @mysql_connect("localhost","nasserdx_boss","12121212");
 @mysql_select_db('nasserdx_tm');
  
  $val=array();
 
 $sqlstmt= "SELECT * FROM subscribes WHERE id>0 ORDER BY id DESC";
  
    $record=mysql_query($sqlstmt)or die(mysql_error());
  
  $subject="Ticket master:subscription";
  
  $meassage="hello this is my subscription";
  
  $rec=mysql_fetch_assoc($record);
   
        
         //echo $rec['email'];
   
      
     // mail($val,$subject,$meassage);
      
   
?>*/