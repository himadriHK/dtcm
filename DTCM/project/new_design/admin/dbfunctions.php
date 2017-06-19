<?
include_once("messages.php");
$admin_email = "nasser@ticketmastersme.com";

function contactadmin($name,$email,$phone,$company,$message1){
       global $admin_email;
       $to = $admin_email;
	   $subject =" Advertise with Us/Contact Us mail";
	   $message = "Message Sender Information\n";
       $message.= "Name : $name\n";
       $message.= "Company : $company\n";
       $message.= "E Mail : $email\n";
       $message.= "Phone : $phone\n";
       $message.= $message1;
	   $message = stripslashes($message);
             //add From: header 
		$headers = "From: $email\r\n"; 
 	@mail($to, $subject, $message, $headers);


}
function getLimit(){
	$sql = "Select deallimit from tblmisc";
	$rs = mysql_query($sql);
	if(!mysql_num_rows($rs))
	 return 0;
	else{
	 $row = mysql_fetch_object($rs);
	 return $row->deallimit;
	}
}

function limitOver($userid){
$sql = "Select startdate from tblads Where userid = '$userid'and languageid='1'";
$rs = mysql_query($sql);
$deallimit = getLimit();
$today = getdate();  
$userdeal = 0;
while($row = mysql_fetch_object($rs)){
  $date1 = explode("-",$row->startdate);
  if(($date1[0] == $today[year]) && ($date1[1] == $today[mon]))
    $userdeal++;
}
if($userdeal < $deallimit)
return 1;
else 
return 0;
}
function lock_unlockuser($userid){
$row = getUser($userid,1);
if($row->lockstatus){
$sql = "Update tblusers SET `lockstatus` = '0' Where userid = '$userid'";
mysql_query($sql) or die("Error in Lock query");

}
if(!$row->lockstatus){
$sql = "Update tblusers SET `lockstatus` = '1' Where userid = '$userid'";
mysql_query($sql) or die("Error in Lock query");

}

}
function tellafriend($to,$from)
{
       
	  
	   $subject =" Dubai Deal Tell a friend Message";
		$message = "Hi,\nDubai Deals The Hotest Deal in Town\n";
       $message.= "Click here to Go http://www.ticketmastersme.com\n";
	   $message = stripslashes($message);
       //add From: header 
		$headers = "From: $from\r\n"; 
		if($mimetype =="html"){
			/* To send HTML mail, you can set the Content-type header. */
			$headers  .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

		}
      	@mail($to, $subject, $message, $headers);
	   }
	   
	   function subscribe($name,$email)
{
       $sql = "select * from tblnewsletter where email = '$email'";
       $rs = mysql_query($sql) or die("Error in news selection");
	   if(mysql_num_rows($rs)) return 0;
	   $sql = " INSERT INTO tblnewsletter (name,email)   VALUES (";
	   $sql= $sql."'$name','$email')";
	    mysql_query($sql) or die("error in query");
	   ?>
	   <Script language="JavaScript">
	   alert("Subcription Process Completed ");
	  </Script>
	   
	   <?
	return 1;
}
function unsubscribe($name,$email)
{
       $sql = "select * from tblnewsletter where email ='$email'";
       $rs = mysql_query($sql) or die("Error in news selection");
	   if(!mysql_num_rows($rs)) return 0;
	   $sql = " Delete from tblnewsletter Where email='$email'";
	 
	   mysql_query($sql) or die("error in query");
	   ?>
	   <Script language="JavaScript">
	   alert("UnSubcription Process Completed ");
	  </Script>
	   
	   <?
	return 1;
}

function sendnews($from,$subject,$message,$mimetype)
{
       $message = stripslashes($message);
       //add From: header 
		$headers = "From: $from\r\n"; 
		if($mimetype =="html"){
			/* To send HTML mail, you can set the Content-type header. */
			$headers  .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

		}
       $sql = "select * from tblnewsletter";
       $rs = mysql_query($sql) or die("Error in news selection");
	   while($row = mysql_fetch_object($rs)){
	    $to = $row->email;
		@mail($to, $subject, $message, $headers);
	   }
	   ?>
	   <Script language="JavaScript">
	   alert("News Letter Delivered Successfully");
	  </Script>
	   
	   <?
	
}

function setCategory($categoryid,$ename,$aname)
{
	$sql = "UPDATE tblcategories SET categoryname ='$aname' where categoryid = '$categoryid' and languageid ='2'";
	mysql_query($sql) or die("Error in update query"); 
	$sql = "UPDATE tblcategories SET categoryname ='$ename' where categoryid = '$categoryid' and languageid ='1'";
	mysql_query($sql) or die("Error in update query"); 
	?>
   <Script language="JavaScript">
   alert("Category Updated Successfully");
  </Script>
 <?
}

function addCategory($ename,$aname)	{
       $sql = "Select categoryid from tblcategories ORDER by categoryid DESC";
	
	   $rs = mysql_query($sql) or die ("error in SelectCategory query");
	   
		$row = mysql_fetch_object($rs);
		if(!$row)
			$id = 0;
		else
			$id = $row->categoryid;
		$id++;
		$sql="INSERT INTO tblcategories(categoryname,languageid,categoryid) VALUES ('$ename', '1','$id')";
			
		$rs = mysql_query($sql) or die ("error in addCategory query");
		
				
		$sql="INSERT INTO tblcategories(categoryname,languageid,categoryid) VALUES ('$aname', '2','$id')";
		
		$rs = mysql_query($sql) or die ("error in addCategory query");
	}

function getCategory($categoryid,$code)
{
    	$sql="select * from tblcategories where categoryid ='$categoryid' and languageid ='$code'";
		$rs = mysql_query($sql) or die ("error in query");
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return( mysql_fetch_object($rs));
		
}
function getCategories($code)
{
		
		$sql="select * from tblcategories Where languageid = '$code' ORDER BY categoryname ASC ";
		$rs = mysql_query($sql) or die ("error in query");
			
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return($rs);
		
}
function deleteCategory($categoryid)
{
$sql = "delete from tblcategories where categoryid = ".$categoryid;
mysql_query($sql) or die("Error in delete query"); 
?>
   <Script language="JavaScript">
   alert("Category Deleted Successfully");
  </Script>
 <?
}
function deleteUser($userid){
$sql = "delete from tblusers where userid = '$userid'";
mysql_query($sql) or die("Error in delete query"); 
?>
   <Script language="JavaScript">
   alert("Dealer Deleted Successfully ");
  </Script>
 <?
}
function checkUser($user)
	{
		$sql="select * from tblusers where userid ='".$user."'";
		$rs = mysql_query($sql) or die ( "error in query");
		if(mysql_num_rows($rs) == 0)
		 return false;
		 else
		 return true;
	}

function addUser($userid,$firstname,$afirstname,$city,$job,$email,$phoneno,$mobile,$address,$aaddress,$website,$companyname,$acompanyname,$password,$map,$logo)
{
	global $msg9,$msg10;
	if(checkUser($userid)){
	?>
	<Script language="JavaScript">
   alert("Userid Already Exists Please try Another");
  </Script>
  <?
   return 0;
	}
	else{
		
	   $sql = " INSERT INTO tblusers (userid,firstname,city,job,email,phone,mobile,address,website,companyname,`password`,map,logo,languageid)   VALUES (";
	   $sql.="'$userid','$firstname','$city','$job','$email','$phoneno', '$mobile', '$address','$website','$companyname','$password','$map','$logo','1')";
	    mysql_query($sql) or die("error in query");
 $sql = " INSERT INTO tblusers (userid,firstname,city,job,email,phone,mobile,address,website,companyname,`password`,map,logo,languageid)   VALUES (";
	   $sql.="'$userid','$afirstname','$city','$job','$email','$phoneno', '$mobile', '$aaddress','$website','$acompanyname','$password','$map','$logo','2')";
	    mysql_query($sql) or die("error in query");
  		global $admin_email;
          //add From: header 
	     $rowu = getUser($userid,1);
		$headers = "From: $rowu->email\r\n"; 
		$subject ="New Dealer Approval Request ";
		$message .=" To Approve the Dealer Click Here\n";
		$message .= " http://www.ticketmastersme.com/admin/viewuser.php?Submit=1&action=approve&userid='".$rowu->userid."'";
		$to = $admin_email;
		@mail($to, $subject, stripslashes($message), $headers);
	   ?>
	   <Script language="JavaScript">
	   alert("Dealer Registered Successfully");
	  </Script>
	   
	   <?
	}
	return 1;
}
function getUser($userid,$code)
{
		$sql="select * from tblusers where userid ='".$userid."' and languageid ='$code'";
		$rs = mysql_query($sql) or die ("error in query");
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return( mysql_fetch_object($rs));
		
}
function setUser($userid,$firstname,$afirstname,$city,$job,$email,$phoneno,$mobile,$address,$aaddress,$website,$companyname,$acompanyname,$password,$map,$logo)
{  
    global $msg19;
	$row = getUser($userid,1);
	$sql = "UPDATE tblusers SET firstname='$firstname',job='$job',email='$email',phone='$phoneno',mobile='$mobile',address='$address',website='$website',companyname='$companyname',password='$password' where userid = '$userid' and languageid='1'";
	mysql_query($sql) or die("Error in update query"); 
	$sql = "UPDATE tblusers SET firstname='$afirstname',job='$job',email='$email',phone='$phoneno',mobile='$mobile',address='$aaddress',website='$website',companyname='$acompanyname',password='$password' where userid = '$userid' and languageid='2'";
	mysql_query($sql) or die("Error in update query"); 
	if($map){
    if($row->map)  
	@unlink($row->map);
	$sql = "Update tblusers SET map = '$map' Where userid = '$userid'";
	mysql_query($sql) or die("Error in update query"); 
	}
	if($logo){
    if($row->map)  
	@unlink($row->logo);
	$sql = "Update tblusers SET logo ='$logo' Where userid = '$userid'";
	mysql_query($sql) or die("Error in update query"); 
	}
	?>
	<Script language="JavaScript">
	   alert("Profile Updated Successfully");
	  </Script>
	<?
	
}
function approveAgent($userid,$password)
{  
     $sql = "Update tblusers SET password = '$password' Where userid='$userid'";
	 mysql_query($sql) or die("Error in update query"); 
	$row = getUser($userid,1);
	 // Email to the Client 
		$to = $row->email;
		$headers = "From: Dubai Deal Administration <admin@dubaideal.com>\r\n";
		$subject = "Dubai Deal Company Registration";
		$message = "Hi ".$row->firstname.",\n"."Your Company Request has been approved by the Administrative Panel of Dubai Deal. ";
		$message.="user ID:  $row->userid\n Password : $row->password\n";
		$message.="Login by Click here http://www.dubaideal.com/login.php\n";
		$message.="With regards \n Web Master";
		$message = stripslashes($message);
		//echo $message;
		@mail($to,$subject,$message,$headers);
		
	?>
	<Script language="JavaScript">
	   alert("Agent Approved Successfully");
	  </Script>
	<?
}
function forgetpassword($userid,$email){
global $admin_email;
if($userid){
$password = getPassword($userid);
if($password){
$row = getUser($userid,1);
	 // Email to the Client 
		$to = $row->email;
		$headers = "From: $admin_email\r\n";
		$subject = "Dubai Deals Password Recovery Service";
		$message = "Hi ".$row->firstname.",\n"."Your Password Information is enclosed in this mail";
		$message.="user id $row->userid\n Password : $row->password\n";
		$message.="With regards \n Web Master";
		$message = stripslashes($message);
		//echo $message;
		@mail($to,$subject,$message,$headers);
		return 1;

}
}
if($email){
$sql = "Select * from tblusers Where email='$email'";
$rs = mysql_query($sql);
if(mysql_num_rows($rs)) $passsend =1;
while($row1 = mysql_fetch_object($rs)){
$row = getUser($row1->userid); 
// Email to the Client 
		$to = $row->email;
		$headers = "From: admin@dubaideals.com\r\n";
		$subject = "Dubai Deals Password Recovery Service";
		$message = "Hi ".$row->firstname.",\n"."Your Password Information is enclosed in this mail";
		$message.="user id $row->userid\n Password : $row->password\n";
		$message.="With regards \n Web Master";
		$message = stripslashes($message);
		//echo $message;
		@mail($to,$subject,$message,$headers);
}
if($passsend){
  ?>
	   <Script language="JavaScript">
	   alert("Password Retrieved Successfully");
	  </Script>
<?
}
else
{
 ?>
	   <Script language="JavaScript">
	   alert("Sorry You are not a User Here");
	  </Script>
<?
}
}//if email
}
function getPassword($userid)
{
		$sql="select * from tblusers where userid ='".$userid."'";
		$rs = mysql_query($sql) or die ("error in query");
		if(mysql_num_rows($rs) == 0)
		  return 0;
		else
		{
		  $row = mysql_fetch_object($rs);
		  return($row->password);
    	}
}
 function setPassword($userid,$password){
 
	$sql = "UPDATE tblusers SET password ='$password' where userid= '$userid'";
	mysql_query($sql) or die("Error in update query"); 
	?>
	<Script language="JavaScript">
	   alert("Password Changed Successfully");
	  </Script>
 <?
 
 }

function addAd($userid,$categoryid,$startdate,$enddate,$price,$discount,$etitle,$edescription,$atitle,$adescription,$shipdub,$shipabu,$shipala,$shipsha,$shipajm,$shipfuj,$shipras,$shipuma,$image)	{
      
      if(!$startdate)
	   $startdate = date("Y-m-d");
     if(!$enddate)
	   $enddate = date("Y-m-d",time()+14*24*3600);
	  
	    $date1 = explode("-",$startdate);
		 $date2 = explode("-",$enddate);
		 $startdate=date("Y-m-d",mktime(0, 0, 0, $date1[1], $date1[2], $date1[0]));
		 $enddate =date("Y-m-d",mktime(0, 0, 0, $date2[1], $date2[2], $date2[0]));
		// echo "datediff".dateDiff(mktime(0, 0, 0, 2, 1, 2002),mktime(0, 0, 0, 2, 2, 2002));  
	   if(dateDiff(mktime(0, 0, 0, $date1[1], $date1[2], $date1[0]),mktime(0, 0, 0, $date2[1], $date2[2], $date2[0]))>14){
	    $enddate = date("Y-m-d",mktime(0, 0, 0, $date1[1], $date1[2], $date1[0])+14*24*3600);
	   }  
	//    echo $startdate;
	 //  echo "<br/>".$enddate."<br/>";
	   $sql = "Select adid from tblads ORDER by adid DESC";
	
	   $rs = mysql_query($sql) or die ("error in SelectAd query");
	   
		$row = mysql_fetch_object($rs);
		if(!$row)
			$id = 0;
		else
			$id = $row->adid;
		$id++;
		$sql="INSERT INTO tblads(adid,userid,languageid,categoryid,price,discount,startdate,enddate,title,description,shipdub,shipabu,shipala,shipsha,shipajm,shipfuj,shipras,shipuma,image) VALUES ";
                $sql.="('$id','$userid','1','$categoryid','$price','$discount','$startdate','$enddate','$etitle','$edescription','$shipdub','$shipabu','$shipala','$shipsha','$shipajm','$shipfuj','$shipras','$shipuma','$image')";
			//echo $sql;
		$rs = mysql_query($sql) or die ("error in add Ad1 query");
		$sql="INSERT INTO tblads(adid,userid,languageid,categoryid,price,discount,startdate,enddate,title,description,shipdub,shipabu,shipala,shipsha,shipajm,shipfuj,shipras,shipuma,image) VALUES ";
                $sql.="('$id','$userid','2','$categoryid','$price','$discount','$startdate','$enddate','$atitle','$adescription','$shipdub','$shipabu','$shipala','$shipsha','$shipajm','$shipfuj','$shipras','$shipuma','$image')";
			//echo $sql;
		$rs = mysql_query($sql) or die ("error in add Ad2 query");
					
		
	}

function setAd($adid,$categoryid,$price,$discount,$etitle,$edescription,$atitle,$adescription,$shipdub,$shipabu,$shipala,$shipsha,$shipajm,$shipfuj,$shipras,$shipuma,$image)	{

        $row = getAd($adid,1);
    if($image){
	    if($row->image)
     	@unlink("../".$row->image);
          }
 $sql = "UPDATE tblads SET categoryid ='$categoryid',price ='$price',discount ='$discount',shipabu ='$shipabu',shipdub ='$shipdub',shipsha ='$shipsha',shipajm ='$shipajm',shipfuj ='$shipfuj',shipala ='$shipala',shipras ='$shipras',shipuma ='$shipuma',title ='$etitle',description ='$edescription' where adid= '$adid' and languageid='1'";
// echo $sql;
	mysql_query($sql) or die("Error in update query"); 
	$sql = "UPDATE tblads SET categoryid ='$categoryid',price ='$price',discount ='$discount',shipabu ='$shipabu',shipdub ='$shipdub',shipsha ='$shipsha',shipajm ='$shipajm',shipfuj ='$shipfuj',shipala ='$shipala',shipras ='$shipras',shipuma ='$shipuma',title ='$atitle',description ='$adescription' where adid= '$adid' and languageid='2'";
	//echo $sql;
	mysql_query($sql) or die("Error in update query"); 
       if($image){
	$sql = "UPDATE tblads SET image ='$image' where adid= '$adid'";
	mysql_query($sql) or die("Error in update query"); 

       }
}

function getAd($adid,$code){
    	$sql="select * from tblads where adid ='$adid' and languageid ='$code'";
		$rs = mysql_query($sql) or die ("error in query");
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return( mysql_fetch_object($rs));
		
}
function getAds1($userid,$code)
{
		$sql="select * from tblads Where userid='$userid' and languageid = '$code' ORDER BY name ASC ";
		$rs = mysql_query($sql) or die ("error in query");
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return($rs);
}
function getAds($userid)
{
		
		$sql="select * from tblads where userid='$userid' ORDER BY adid DESC ";
		$rs = mysql_query($sql) or die ("error in query");
		
			
		if(mysql_num_rows($rs) == 0)
		 return 0;
		 else
		 return($rs);
		
}
function deleteAd($adid)
{
$sql = "delete from tblads where adid = '$adid'";
mysql_query($sql) or die("Error in delete Ad  query"); 
}
function dateDiff($date, $date2 = 0)
{
    if(!$date2) {
        $date2 = mktime();
    }

    $date_diff = array('seconds'  => '',
                       'minutes'  => '',
                       'hours'    => '',
                       'days'     => '',
                       'weeks'    => '',
                       
                       'tseconds' => '',
                       'tminutes' => '',
                       'thours'   => '',
                       'tdays'    => '',
                       'tdays'    => '');

    ////////////////////
    
    if($date2 > $date) {
        $tmp = $date2 - $date;
    }

    else {
        $tmp = $date - $date2;
    }

    $seconds = $tmp;

    // Relative ////////
    $date_diff['weeks'] = floor($tmp/604800);
    $tmp -= $date_diff['weeks'] * 604800;

    $date_diff['days'] = floor($tmp/86400);
    $tmp -= $date_diff['days'] * 86400;

    $date_diff['hours'] = floor($tmp/3600);
    $tmp -= $date_diff['hours'] * 3600;

    $date_diff['minutes'] = floor($tmp/60);
    $tmp -= $date_diff['minutes'] * 60;

    $date_diff['seconds'] = $tmp;
    
    // Total ///////////
    $date_diff['tweeks'] = floor($seconds/604800);
    $date_diff['tdays'] = floor($seconds/86400);
    $date_diff['thours'] = floor($seconds/3600);
    $date_diff['tminutes'] = floor($seconds/60);
    $date_diff['tseconds'] = $seconds;

    return $date_diff['tdays'];
}
?>
