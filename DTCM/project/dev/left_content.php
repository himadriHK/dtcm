<?php
 //include('connection.php');

if($_POST['Subscribe'])
{
  
 // @mysql_connect("localhost","betagri_tktrush","MBa5xGJ^ko[x");
 
 // @mysql_select_db('betagri_tktrush');
  
    $sub_country= $_POST['country']; //echo $sub_country;
    $sub_email=$_POST['email_id']; // echo $sub_email;
    $sub_phone=$_POST['phone_num'];  //echo $sub_phone;
    $sub_created= time();
    $sqlstmt="INSERT INTO subscribes(country,email,phone,created_time)VALUES('$sub_country','$sub_email','$sub_phone','$sub_created')";
    
    $data=mysql_query($sqlstmt, $eventscon)or die(mysql_error());
    
    if($data)
    {
    
        //$to=array();
 
 $sqlstmt= "SELECT * FROM subscribes WHERE id>0 ORDER BY id DESC";
  
    $record=mysql_query($sqlstmt, $eventscon)or die(mysql_error());
  
  $subject="Ticket Rush:subscription";
  
  $meassage="hello this is my email subscription";
  
  $rec=mysql_fetch_assoc($record);
   
        
        $to= $rec['email'];
        mail($to,$subject,$meassage);
    }
    @mysql_free_result($record);
}



?>

<!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery.form.js"></script>
<script type="text/javascript">
	$(function() {
    $(".datepicker").datepicker();
	});
	</script>-->
<script src="js/jquery.cycle.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
		jQuery('.slideshow').cycle({			
			fx:  'turnUp',			
			speed:  2000,
			timeout: 5000
		});		
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
<div class="left_block">
<?php 
if($category_details){
$cat_id=$category_details['id'];
$query_string=" AND category='$cat_id'";
}else {
	$cat_id ='all';
}
$query_advertRs = "SELECT * FROM event_adverts where category = '".$cat_id."'";

$advertRs = mysql_query($query_advertRs, $eventscon) or die(mysql_error());

$row_advertRs = mysql_fetch_assoc($advertRs);
?>
<div class="addin">
<?php if($row_advertRs['image']!='') { ?>
<a href="<?php echo $row_advertRs['link'];?>" target="_blank"><img src='data/advert/<?php echo $row_advertRs['image'];?>' /></a>
	
	
<?php
}
?>
</div>
<?php if($row_advertRs['video']!='') {
		$youtube_url='http://www.youtube.com/embed/';
			$str=strstr($row_advertRs['video'],'v=');
			if($str){
				$str=substr($str,2);
				$final_url=$youtube_url.$str;
			}else{
				$final_url=$row_advertRs['video'];
			}

	 ?>
<div class="videoin">
<iframe width="280" height="300" frameborder="0"
src="<?php echo $final_url; ?>">
</iframe>
</div>
<?php } else { ?>
<?php }?>

</div>



<div class="left_block">
<h1>Events by Category</h1>
<div class="list_block">
<ul>
<li><a href="ongoing_events.php?cat=all">All</a></li>
<?php
$query_categoryRs = "SELECT * FROM category";
$categoryRs = mysql_query($query_categoryRs) or die(mysql_error());
while ($category = mysql_fetch_assoc($categoryRs)){ 
	$query_eventCat = "SELECT tid FROM events  WHERE ongoing='".ONGOING."' AND city='{$default_city_id}' AND date_end>='".date('Y-m-d')."'  AND category='".$category['id']."'";
	$catevents = mysql_query($query_eventCat, $eventscon) or die(mysql_error());
	if(mysql_num_rows($catevents)>0) {
?>
<li><a href="ongoing_events.php?cat=<?php echo $category['ename'];?>">
<?php if($category['image']!='') 
echo '<img src="upload/category/'.$category['image'].'" alt="'.$category['name'].'" width="25px" />'; ?> 
<?php echo $category['name'];?></a></li>
<?php } } ?>
</ul>
</div>

</div>
<?php 
$result = mysql_query( "SELECT * FROM tblnews order by date desc");
$num_fields = mysql_num_rows ($result);		
if($num_fields>0){
?>

<div class="left_block" style="height:auto;">
<h1>News</h1>
<div class="slideshow">
<?php 
while($row = mysql_fetch_array($result)) 
{   
		 
   $newsid=$row['newsid'];
   $title=$row['title'];
   $image=$row['image'];
   $date=$row['date'];
   $month=$row['month'];
   $year=$row['year'];
   $description=$row['description'];	
   $url = $row['url'];
?>
	<div class="slide2">
		<div style="margin-top:5px;">
		<?php if($url!=''){?>
		<a href="<?php echo $url;?>" target="_blank">
			<img src="images/<?php echo $image;?>" alt="<?php echo $title;?>" height="200" width="280">
			</a>
			<?php } else {?>
			<img src="images/<?php echo $image;?>" alt="<?php echo $title;?>" height="200" width="280">
			<?php }?>
		</div>
		<div style="font-weight:bold; height:25px; margin-top:10px;" class="slid_head">
		<?php if($url!=''){?>
		<a href="<?php echo $url;?>" target="_blank">
		<?php echo $title;?>			</a>
			<?php } else {?>
		<?php echo $title;?></div>
		<?php }?>
	
	<div class="slid_text"><?php echo $description;?></div>
	</div>
<?php 
}
		?>
</div>
</div>
<?php 
}
   ?>
<div class="left_block">
<h1>Dine Party</h1>
<div class="imgblock">
<img src="img/img1.png" />
</div>
</div>
<div class="browse-col-news left_block" style="">
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
<label>Country</label>
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
<input style="background: none repeat scroll 0 0 #222222; box-shadow: 0 0 10px #000000 inset; color: #FFFFFF;cursor:pointer;  float: right;  width: auto;" type="submit" name="Subscribe" value="Subscribe">

</div>

</form>

</div>

<div class="left_block">
<h1>FB Like</h1>
<div class="imgblock">
<p><iframe src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/Ticket-Masters-ME/283385145084848&width=245&colorscheme=light&connections=10&stream=false&header=true&height=160" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:150px;" allowTransparency="true"></iframe></p> 
</div>
</div>

<div class="left_block" style="display:none;"> 

    <h1>Follow us on Twitter</h1>
    <div class="imgblock">
<style>
.twitter_block_img{
	 display: block;
    float: left;
    height: 65px;
    margin-right: 2px;
}
.twitter_block_text{
	display:block;
}
.twitter_block_time{
	display: block;
    float: left;
    padding-top: 5px;
}
.twitter_block{
    display: block;
    float: left;
	width:100%;
}
.twitter_main_block{
	padding:none !important;
	overflow:scroll !important;
	height:290px;
}
.tweet_right_block{
	display: inline-block; float: right; width: 78%;
}
</style>
    <div class="box_middle twitter_main_block" style="padding:4px !important;">
<?php
$tweets = array();
//$tweet_id='TicketMastersME';
	 //$tweets=json_decode(getLatestTweet($tweet_id),true);
    
if(!isset($tweets['errors']) && !empty($tweets)){
			  foreach($tweets as $tweet){ 
            ?>
       <div class="twitter_block" >
           <span class="twitter_block_img" >
           <img src='<?php echo $tweet['user']['profile_image_url'];?>' />
           </span>
          <div class="tweet_right_block">
           <span class="twitter_block_text" >
           <?php echo $tweet['text']; ?>
           </span>
           <span class="twitter_block_time" >
          <?php
            if(date('dmY',strtotime($tweet['created_at']))!=date('dmY',time())){echo date('d-M-Y h:i A',strtotime($tweet['created_at']));
		   }else{echo 'Today '.date('h:i A',strtotime($tweet['created_at']));} 
           
           ?>
           </span></div>
           
       </div>
 
     <?php
       } }else{echo 'No recent tweets found';} 
       
      ?>

        </div>
        </div>

</div>


<div class="browse-col" style="display:none;">

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

                url		: "/admin/add_events.php?getcity="+v,

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
<input style=" background: none repeat scroll 0 0 #222222;border-radius:4px; padding:4px 10px; box-shadow: 0 0 10px #000000 inset;    color: #FFFFFF; border:none;cursor:pointer;    float: right;    width: auto;" type="submit" name="search" value="Search"/></span></form>
</div>



</div>



<div class="left-add" style="display:none;"><img src="img/left-banner.jpg" /></div>

<div class="left_block" style="display:none;">

<h1>Our Outlets</h1>
<?php
$query_outlets = "SELECT outlet FROM outlets limit 0,6";
$sideOutlets = mysql_query($query_outlets) or die(mysql_error());
while ($outletrow = mysql_fetch_assoc($sideOutlets)){ 
?>
<div class="reviews-white">
<div class="reviews-heading"><?php echo $outletrow['outlet'];?></div>
<!--<div class="reviews-text"><span>Rock and pop get</span> <a href="#">tickets</a></div>-->
</div>
<?php } ?>
</div>
<div class="left_block" style="float:left;margin: 20px 0;display:none;" >
<img src="banner_ad/aramex.png" width="280">
</div>
<div class="hotel-box" style="float:left; display:none;">
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
<!--<div class="left-add">
<div class="box_left" style="background: none repeat scroll 0 0 #B13C4F; border-radius: 10px 10px 10px 10px;  padding: 5px 10px;">
             <div class="box_middle" style="background: none repeat scroll 0 0 #FFFFFF;">

            <p><iframe src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/Ticket-Masters-ME/283385145084848&width=245&colorscheme=light&connections=10&stream=false&header=true&height=300" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:300px;" allowTransparency="true"></iframe></p> 

          </div>

          </div>
</div>-->
</div>
<?php 
function getLatestTweet($twittername) {

		require_once 'TwitterAPIExchange.php';
		//Twitter API OAUTH settings
		$settings = array(
		'oauth_access_token' => '180260346-sSraODvwjTIGTFfUtazFXmrpurJ7o5knvkVhbdDc',
		'oauth_access_token_secret' => 'nw0gFd0btMW7ExlzMIGb8NwALwEM25KCbwxMHO9tZk',
		'consumer_key' => 'mASa6qZOwmFZ8zLpfD7kag',
		'consumer_secret' => 'dQfMiBwbsKXMkxXWC3rtcvlnk5Wi07SGMN9w4J342w'
		);
	//Twitter feed JSON URL
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$requestMethod = 'GET';
		$getfield = '?screen_name='.$twittername.'&count=5';

		$twitter = new TwitterAPIExchange($settings);
		
		$json= $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
		return $json;
	}	
	?>