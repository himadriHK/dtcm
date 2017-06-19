<?php
 //include('connection.php');

if($_POST['Subscribe'])
{
  
  @mysql_connect("localhost","nasserdx_boss","12121212");
 
  @mysql_select_db('nasserdx_tm');
  
    $sub_country= $_POST['country']; //echo $sub_country;
    $sub_email=$_POST['email_id']; // echo $sub_email;
    $sub_phone=$_POST['phone_num'];  //echo $sub_phone;
    $sub_created= time();
    $sqlstmt="INSERT INTO subscribes(country,email,phone,created_time)VALUES('$sub_country','$sub_email','$sub_phone','$sub_created')";
    
    $data=mysql_query($sqlstmt)or die(mysql_error());
    
    if($data)
    {
    
        //$to=array();
 
 $sqlstmt= "SELECT * FROM subscribes WHERE id>0 ORDER BY id DESC";
  
    $record=mysql_query($sqlstmt)or die(mysql_error());
  
  $subject="Ticket master:subscription";
  
  $meassage="hello this is my email subscription";
  
  $rec=mysql_fetch_assoc($record);
   
        
        $to= $rec['email'];
        mail($to,$subject,$meassage);
    }
    @mysql_free_result($record);
}



?>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="/new_design/js/jquery.form.js"></script>
<script type="text/javascript">
	$(function() {
    $(".datepicker").datepicker();
	});
	</script>
 <script type="text/javascript">
 
  

	  var regexp = "/^[\w\-\.]+@[\w\-]+(\.[\w\-]+)*(\.[a-z]{2,})$/";
	function check(){
		
		
		phone=document.getElementById("phone_num")
		email=document.getElementById("email_id")
	   if(email.value=="")
	   {
	   alert("email is empty")
	   return false;
	   }
	   else if(phone.value=="")
	   {
	   alert("phone is empty")
	   return false;
	   }
	   else
	     {
	    return true;
	     //alert("post");
	     
    
		 }
	}
	
	

	</script>


<div class="content-left">
<div class="browse-col">

<h1>Browse for tickets</h1>
<div class="browse-form">
<form action="search.php" method="post">
<!--<label>Select Categroy:</label>
<select name="categroy">
 <option value="0" selected >Select Categroy</option>
 <option value="1"  >On Going</option>
 <option value="2" >Up Coming</option>
 <option value="3" >Guest Line</option>
</select>
-->
<label>Select Country:</label>
<script type="text/javascript">
                  function ajaxcall(v){
                  
                   $.ajax({

                type	: "GET",

                cache	: false,

                url		: "/new_design/admin/add_events.php?getcity="+v,

                data	: $(this).serializeArray(),

                success: function(data) {

                  document.getElementById("city").innerHTML=data

                }
            });
                  }
                  </script>
<select name="country" onchange="ajaxcall(this.value);">
 <option value="0" >Select Country</option>
                      <?php 
//$query_countryRs = "SELECT * FROM shippingrates ORDER BY countryid ASC";
$query_countryRs = "SELECT country FROM events group by country";
$countryRs = mysql_query($query_countryRs) or die(mysql_error());
while ($row = mysql_fetch_assoc($countryRs)){ 
$sql = "SELECT * FROM shippingrates where countryid=".$row['country'];
$query = mysql_query($sql) or die(mysql_error());
$row_countryRs= mysql_fetch_assoc($query);
?>

                      <option value="<?php echo $row_countryRs['countryid']?>" ><?php echo $row_countryRs['name']?></option>

                      <?php

} 

?>

</select>
<label>Select City:</label>
<select name="city" id="city">
 
</select>
<label>Select Date From:</label>
<input type="text" class="datepicker"  name="date_start" value="<?php echo date('m/d/Y',time()); ?>"  style=" border: medium none;border-radius: 5px 0 0 5px;float: left;height: 17px;padding: 5px;width: 127px;">
<img src="img/icon.png" style="background: none repeat scroll 0 0 #FFFFFF;border: medium none;border-radius: 0 5px 5px 0;float: left;padding: 2px;"  id="from">
<label style="margin-top:15px;">Select Date To:</label>
<input type="text" class="datepicker" name="date_end" value="<?php echo date('m/d/Y',time()+(24*60*60)); ?>" style=" border: medium none;border-radius: 5px 0 0 5px;float: left;height: 17px;padding: 5px;width: 127px;">
<img src="img/icon.png" style="background: none repeat scroll 0 0 #FFFFFF;border: medium none;border-radius: 0 5px 5px 0;float: left;padding: 2px;">
<span style=" background: none repeat scroll 0 0 #B13C4F !important;float: right; margin-top: 8px;">
<input style=" background: none repeat scroll 0 0 #222222;border-radius:4px; padding:4px 10px; box-shadow: 0 0 10px #000000 inset;    color: #FFFFFF; border:none;    float: right;    width: auto;" type="submit" name="search" value="Search"/></span></form>
</div>



</div>

<div class="browse-col-news">
<h1>Subscribe to our news letter and SMS alerts</h1>
<form method="post"   onSubmit="return check()">
<div>
<?php

if($data)
    { ?>
       <span style="color:#ff0000 !important;">Email Subscribed Successfully</span>
   <?php }

?>
</div>
<div class="browse-form-news">
<label>Conuntry</label>
<select name="country">
 <?php 

//$query_countryRs = "SELECT country FROM events group by country";
$query_countryRs = "SELECT * FROM country";
$countryRs = mysql_query($query_countryRs) or die(mysql_error());
while ($row = mysql_fetch_assoc($countryRs)){ 

//$sql = "SELECT * FROM shippingrates where countryid=".$row['country'];
//$query = mysql_query($sql) or die(mysql_error());
//$row_countryRs= mysql_fetch_assoc($query);
?>

                      <option value="<?php echo $row['name']?>" ><?php echo $row['name']?></option>

                      <?php

} 

?>
</select>
<label>Email Address</label>
<input type="text" name="email_id" id="email_id" value="">
<label>Phone Number</label>
<input type="text" name="phone_num" id="phone_num" value="">
<input style="background: none repeat scroll 0 0 #222222; box-shadow: 0 0 10px #000000 inset; color: #FFFFFF; float: right;  width: auto;" type="submit" name="Subscribe" value="Subscribe">

</div>

</form>

</div>

<div class="left-add" style="display:none;"><img src="img/left-banner.jpg" /></div>

<div class="hot-tickets" style="display:none;">

<h1>Hot Tickets</h1>
<div class="reviews-white">
<div class="reviews-heading">Jimmy Buffet</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
<div class="reviews-white" style="background:none;">
<div class="reviews-heading">Bille Joy</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
<div class="reviews-white">
<div class="reviews-heading">Jimmy Buffet</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
<div class="reviews-white" style="background:none;">
<div class="reviews-heading">Bille Joy</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
<div class="reviews-white">
<div class="reviews-heading">Jimmy Buffet</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
<div class="reviews-white" style="background:none;">
<div class="reviews-heading">Bille Joy</div>
<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>
</div>
</div>

<div class="hotel-box" style="float:left;">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><table width="165" cellspacing="0" cellpadding="0" border="0">
  
  <tbody><tr>
    <td><table cellspacing="0" cellpadding="0" border="0" align="center" style="width:145px;">
      <tbody><tr>
        <td style="width:145px;"><img width="214" height="150" border="0" src="banner_ad/aramex.png"></td>
      </tr>
      <tr>
        <td style="width:145px; height:10px;"></td>
      </tr>
      <tr>
        <td style="width:145px;"><img width="214" height="150" border="0" src="banner_ad/paymentoptions.png"></td>
      </tr>
      <tr>
        <td style="width:145px; height:10px;"></td>
      </tr>
      <tr>
        <td style="width:145px;"><a href="http://www.octopustravel.com/em/Home.jsp;jsessionid=D8741B72720CFF30CEDBB2C27F9347B1.01HJW"><img width="214" height="150" border="0" src="banner_ad/hotelbooking.png"></a></td>
      </tr>
      <tr>
        <td style="width:145px; height:10px;"></td>
      </tr>
      
    </tbody></table></td>
  </tr>
  
</tbody></table>
</td>
                </tr>
              </tbody></table>
</div>
<!--facebook like box-->
<div class="left-add">
<div class="box_left" style="background: none repeat scroll 0 0 #B13C4F; border-radius: 10px 10px 10px 10px;  padding: 5px 10px;">
             <div class="box_middle" style="background: none repeat scroll 0 0 #FFFFFF;">

            <p><iframe src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/Ticket-Masters-ME/283385145084848&width=245&colorscheme=light&connections=10&stream=false&header=true&height=300" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:300px;" allowTransparency="true"></iframe></p> 

          </div>

          </div>
</div>
</div>