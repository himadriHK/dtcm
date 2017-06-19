<?php require_once('header.php'); 

mysql_select_db($database_eventscon, $eventscon);

if(!empty($_SESSION['Customer']))header("location:index.php");

if(!empty($_POST))

{

	foreach($_POST as $key=>$val)

	{

		$_POST[$key]=mysql_real_escape_string($val);

	}

	//print_r($_POST);exit;

	$fname=$_POST['fname'];$lname=$_POST['lname'];$mobile=$_POST['mobile'];$email=$_POST['email'];$password=md5($_POST['password']);$city=$_POST['city'];

		$country=$_POST['country'];$address=$_POST['address'];$date_added=date('Y-m-d H:i:s');		$countryCode = $_POST['countryCode'];
		$gender = $_POST['gender'];		$dob = $_POST['day'].'-'.$_POST['month'].'-'.$_POST['year'];
		
		$dobforage = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
		$userAge = floor((time() - strtotime($dobforage)) / 31556926);
		
		
		$sql="SELECT * FROM `customers` where `email`='".$email."'";
		

	$query=mysql_query($sql,$eventscon);

	$result=mysql_fetch_assoc($query);

	if($_POST['password']!=$_POST['confirmPassword'])

	{

		$_SESSION['error']='Password does not match with confirm password.';

	}else if(!empty($result))

	{

		$_SESSION['error']='This email address is already registered.';

	}

	else{

		$sql="INSERT INTO `customers`(cust_id,fname,lname,dob,age,gender,countryCode,mobile,email,password,city,country,address,date_added) VALUES(NULL,'$fname','$lname','$dob',$userAge,'$gender',$countryCode,'$mobile','$email','$password','$city','$country','$address','$date_added')";

		$result=mysql_query($sql,$eventscon);

		if($result)

		$_SESSION['success']='You have successfully registered.';

		else

		$_SESSION['error']='Error occured!.';

		

	}

}

$country_sql="SELECT * FROM country ORDER BY id ASC";

$country_query = mysql_query($country_sql, $eventscon) or die(mysql_error());
?>

<div class="main-content">
  <div class="container">
    <?php //require_once('left_content.php'); ?>
    <div class="conent-right">
      <?php //require_once('banner2.php'); ?>
      <!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
      <?php //require_once('menu.php'); ?>
      <div class="shows-box">
        <script type="application/javascript">

$(document).ready(function(e) {

    $("#validate_signup").validate();

});



</script>
        <?php if($_SESSION['success']){?>
        <h2 style="color:#006666;font-size: 21px;padding: 14px 0 12px;"><?php echo $_SESSION['success'];unset($_SESSION['success']);?></h2>
        <?php }?>
        <?php if($_SESSION['error']){?>
        <h2 style="color:#FF0000;font-size: 21px;padding: 14px 0 12px;"><?php echo $_SESSION['error'];unset($_SESSION['error']);?></h2>
        <?php }?>
        <h1>Sign Up</h1>
        <div class="shows-box-frames">
          <form action="" method="post"  id="validate_signup">
            <table width="100%" border="0" cellspacing="1" cellpadding="4">
              <tbody>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue">Email:</td>
                  <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="email" class="formField email required" name="email" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite">Password:</td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="password" id="password" class="formField required" name="password" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite">Confirm Password:</td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="password" id="confirmPassword" class="formField required" name="confirmPassword" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite ">First Name: </td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="text" id="fname" class="formField required" name="fname" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue ">Last Name: </td>
                  <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="lname" class="formField required" name="lname" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite">Mobile:</td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><span style="float:left; width:45%;">
                    <select name="countryCode" id="countryCode" class="formField required" style="width:150px;">
                      <option value="" selected="selected">Area Code</option>
                      <option value="44" >UK (+44) </option>
                      <option value="1">USA (+1) </option>
                      <option value="213">Algeria (+213) </option>
                      <option value="376">Andorra (+376) </option>
                      <option value="244">Angola (+244) </option>
                      <option value="1264">Anguilla (+1264) </option>
                      <option value="1268">Antigua &amp; Barbuda (+1268) </option>
                      <option value="599">Antilles (Dutch) (+599) </option>
                      <option value="54">Argentina (+54) </option>
                      <option value="374">Armenia (+374) </option>
                      <option value="297">Aruba (+297) </option>
                      <option value="247">Ascension Island (+247) </option>
                      <option value="61">Australia (+61) </option>
                      <option value="43">Austria (+43) </option>
                      <option value="994">Azerbaijan (+994) </option>
                      <option value="1242">Bahamas (+1242) </option>
                      <option value="973">Bahrain (+973) </option>
                      <option value="880">Bangladesh (+880) </option>
                      <option value="1246">Barbados (+1246) </option>
                      <option value="375">Belarus (+375) </option>
                      <option value="32">Belgium (+32) </option>
                      <option value="501">Belize (+501) </option>
                      <option value="229">Benin (+229) </option>
                      <option value="1441">Bermuda (+1441) </option>
                      <option value="975">Bhutan (+975) </option>
                      <option value="591">Bolivia (+591) </option>
                      <option value="387">Bosnia Herzegovina (+387) </option>
                      <option value="267">Botswana (+267) </option>
                      <option value="55">Brazil (+55) </option>
                      <option value="673">Brunei (+673) </option>
                      <option value="359">Bulgaria (+359) </option>
                      <option value="226">Burkina Faso (+226) </option>
                      <option value="257">Burundi (+257) </option>
                      <option value="855">Cambodia (+855) </option>
                      <option value="237">Cameroon (+237) </option>
                      <option value="1">Canada (+1) </option>
                      <option value="238">Cape Verde Islands (+238) </option>
                      <option value="1345">Cayman Islands (+1345) </option>
                      <option value="236">Central African Republic (+236) </option>
                      <option value="56">Chile (+56) </option>
                      <option value="86">China (+86) </option>
                      <option value="57">Colombia (+57) </option>
                      <option value="269">Comoros (+269) </option>
                      <option value="242">Congo (+242) </option>
                      <option value="682">Cook Islands (+682) </option>
                      <option value="506">Costa Rica (+506) </option>
                      <option value="385">Croatia (+385) </option>
                      <option value="53">Cuba (+53) </option>
                      <option value="90392">Cyprus North (+90392) </option>
                      <option value="357">Cyprus South (+357) </option>
                      <option value="42">Czech Republic (+42) </option>
                      <option value="45">Denmark (+45) </option>
                      <option value="2463">Diego Garcia (+2463) </option>
                      <option value="253">Djibouti (+253) </option>
                      <option value="1809">Dominica (+1809) </option>
                      <option value="1809">Dominican Republic (+1809) </option>
                      <option value="593">Ecuador (+593) </option>
                      <option value="20">Egypt (+20) </option>
                      <option value="353">Eire (+353) </option>
                      <option value="503">El Salvador (+503) </option>
                      <option value="240">Equatorial Guinea (+240) </option>
                      <option value="291">Eritrea (+291) </option>
                      <option value="372">Estonia (+372) </option>
                      <option value="251">Ethiopia (+251) </option>
                      <option value="500">Falkland Islands (+500) </option>
                      <option value="298">Faroe Islands (+298) </option>
                      <option value="679">Fiji (+679) </option>
                      <option value="358">Finland (+358) </option>
                      <option value="33">France (+33) </option>
                      <option value="594">French Guiana (+594) </option>
                      <option value="689">French Polynesia (+689) </option>
                      <option value="241">Gabon (+241) </option>
                      <option value="220">Gambia (+220) </option>
                      <option value="7880">Georgia (+7880) </option>
                      <option value="49">Germany (+49) </option>
                      <option value="233">Ghana (+233) </option>
                      <option value="350">Gibraltar (+350) </option>
                      <option value="30">Greece (+30) </option>
                      <option value="299">Greenland (+299) </option>
                      <option value="1473">Grenada (+1473) </option>
                      <option value="590">Guadeloupe (+590) </option>
                      <option value="671">Guam (+671) </option>
                      <option value="502">Guatemala (+502) </option>
                      <option value="224">Guinea (+224) </option>
                      <option value="245">Guinea - Bissau (+245) </option>
                      <option value="592">Guyana (+592) </option>
                      <option value="509">Haiti (+509) </option>
                      <option value="504">Honduras (+504) </option>
                      <option value="852">Hong Kong (+852) </option>
                      <option value="36">Hungary (+36) </option>
                      <option value="354">Iceland (+354) </option>
                      <option value="91">India (+91) </option>
                      <option value="62">Indonesia (+62) </option>
                      <option value="98">Iran (+98) </option>
                      <option value="964">Iraq (+964) </option>
                      <option value="972">Israel (+972) </option>
                      <option value="39">Italy (+39) </option>
                      <option value="225">Ivory Coast (+225) </option>
                      <option value="1876">Jamaica (+1876) </option>
                      <option value="81">Japan (+81) </option>
                      <option value="962">Jordan (+962) </option>
                      <option value="7">Kazakhstan (+7) </option>
                      <option value="254">Kenya (+254) </option>
                      <option value="686">Kiribati (+686) </option>
                      <option value="850">Korea North (+850) </option>
                      <option value="82">Korea South (+82) </option>
                      <option value="965">Kuwait (+965) </option>
                      <option value="996">Kyrgyzstan (+996) </option>
                      <option value="856">Laos (+856) </option>
                      <option value="371">Latvia (+371) </option>
                      <option value="961">Lebanon (+961) </option>
                      <option value="266">Lesotho (+266) </option>
                      <option value="231">Liberia (+231) </option>
                      <option value="218">Libya (+218) </option>
                      <option value="417">Liechtenstein (+417) </option>
                      <option value="370">Lithuania (+370) </option>
                      <option value="352">Luxembourg (+352) </option>
                      <option value="853">Macao (+853) </option>
                      <option value="389">Macedonia (+389) </option>
                      <option value="261">Madagascar (+261) </option>
                      <option value="265">Malawi (+265) </option>
                      <option value="60">Malaysia (+60) </option>
                      <option value="960">Maldives (+960) </option>
                      <option value="223">Mali (+223) </option>
                      <option value="356">Malta (+356) </option>
                      <option value="692">Marshall Islands (+692) </option>
                      <option value="596">Martinique (+596) </option>
                      <option value="222">Mauritania (+222) </option>
                      <option value="269">Mayotte (+269) </option>
                      <option value="52">Mexico (+52) </option>
                      <option value="691">Micronesia (+691) </option>
                      <option value="373">Moldova (+373) </option>
                      <option value="377">Monaco (+377) </option>
                      <option value="976">Mongolia (+976) </option>
                      <option value="1664">Montserrat (+1664) </option>
                      <option value="212">Morocco (+212) </option>
                      <option value="258">Mozambique (+258) </option>
                      <option value="95">Myanmar (+95) </option>
                      <option value="264">Namibia (+264) </option>
                      <option value="674">Nauru (+674) </option>
                      <option value="977">Nepal (+977) </option>
                      <option value="31">Netherlands (+31) </option>
                      <option value="687">New Caledonia (+687) </option>
                      <option value="64">New Zealand (+64) </option>
                      <option value="505">Nicaragua (+505) </option>
                      <option value="227">Niger (+227) </option>
                      <option value="234">Nigeria (+234) </option>
                      <option value="683">Niue (+683) </option>
                      <option value="672">Norfolk Islands (+672) </option>
                      <option value="670">Northern Marianas (+670) </option>
                      <option value="47">Norway (+47) </option>
                      <option value="968">Oman (+968) </option>
                      <option value="680">Palau (+680) </option>
                      <option value="507">Panama (+507) </option>
                      <option value="675">Papua New Guinea (+675) </option>
                      <option value="595">Paraguay (+595) </option>
                      <option value="51">Peru (+51) </option>
                      <option value="63">Philippines (+63) </option>
                      <option value="48">Poland (+48) </option>
                      <option value="351">Portugal (+351) </option>
                      <option value="1787">Puerto Rico (+1787) </option>
                      <option value="974">Qatar (+974) </option>
                      <option value="262">Reunion (+262) </option>
                      <option value="40">Romania (+40) </option>
                      <option value="7">Russia (+7) </option>
                      <option value="250">Rwanda (+250) </option>
                      <option value="378">San Marino (+378) </option>
                      <option value="239">Sao Tome &amp; Principe (+239) </option>
                      <option value="966">Saudi Arabia (+966) </option>
                      <option value="221">Senegal (+221) </option>
                      <option value="381">Serbia (+381) </option>
                      <option value="248">Seychelles (+248) </option>
                      <option value="232">Sierra Leone (+232) </option>
                      <option value="65">Singapore (+65) </option>
                      <option value="421">Slovak Republic (+421) </option>
                      <option value="386">Slovenia (+386) </option>
                      <option value="677">Solomon Islands (+677) </option>
                      <option value="252">Somalia (+252) </option>
                      <option value="27">South Africa (+27) </option>
                      <option value="34">Spain (+34) </option>
                      <option value="94">Sri Lanka (+94) </option>
                      <option value="290">St. Helena (+290) </option>
                      <option value="1869">St. Kitts (+1869) </option>
                      <option value="1758">St. Lucia (+1758) </option>
                      <option value="249">Sudan (+249) </option>
                      <option value="597">Suriname (+597) </option>
                      <option value="268">Swaziland (+268) </option>
                      <option value="46">Sweden (+46) </option>
                      <option value="41">Switzerland (+41) </option>
                      <option value="963">Syria (+963) </option>
                      <option value="886">Taiwan (+886) </option>
                      <option value="7">Tajikstan (+7) </option>
                      <option value="66">Thailand (+66) </option>
                      <option value="228">Togo (+228) </option>
                      <option value="676">Tonga (+676) </option>
                      <option value="1868">Trinidad &amp; Tobago (+1868) </option>
                      <option value="216">Tunisia (+216) </option>
                      <option value="90">Turkey (+90) </option>
                      <option value="7">Turkmenistan (+7) </option>
                      <option value="993">Turkmenistan (+993) </option>
                      <option value="1649">Turks &amp; Caicos Islands (+1649) </option>
                      <option value="688">Tuvalu (+688) </option>
                      <option value="256">Uganda (+256) </option>
                      <option value="44">UK (+44) </option>
                      <option value="380">Ukraine (+380) </option>
                      <option value="971">United Arab Emirates (+971) </option>
                      <option value="598">Uruguay (+598) </option>
                      <option value="1">USA (+1) </option>
                      <option value="7">Uzbekistan (+7) </option>
                      <option value="678">Vanuatu (+678) </option>
                      <option value="379">Vatican City (+379) </option>
                      <option value="58">Venezuela (+58) </option>
                      <option value="84">Vietnam (+84) </option>
                      <option value="84">Virgin Islands - British (+1284) </option>
                      <option value="84">Virgin Islands - US (+1340) </option>
                      <option value="681">Wallis &amp; Futuna (+681) </option>
                      <option value="969">Yemen (North) (+969) </option>
                      <option value="967">Yemen (South) (+967) </option>
                      <option value="381">Yugoslavia (+381) </option>
                      <option value="243">Zaire (+243) </option>
                      <option value="260">Zambia (+260) </option>
                      <option value="263">Zimbabwe (+263)</option>
                    </select>
                    </span> <span style="float:left; width:45%;">
                    <input type="text" id="mobile" class="formField mobile required" name="mobile" style="width: 86%;  margin: 0;">
                    </span> </td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue">I am</td>
                  <td width="288" valign="top" align="left" class="eventText full_width"><select name="gender" id="gender" class="formField required" style="width:87%">
                      <option value="">Select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue">Birthday</td>
                  <td width="288" valign="top" align="left" class="eventText full_width"><select name="day" id="day" class="formField required" style="float:left; width:28%; margin:0 10px 0 0;">
                      <option value="">Day</option>
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                    </select>
                    <select name="month" id="month" class="formField required" style="float:left; width:28%; margin:0 10px 0 0;">
                      <option value="">Month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                    <select name="year" id="year" class="formField required" style="float:left; width:26%; margin:0 10px 0 0;">
                      <option value="">Year</option>
                      <?php		$firstYear = (int)date('Y') - 84;$lastYear = (int)date('Y');for($i=$firstYear;$i<=$lastYear;$i++){    echo '<option value='.$i.'>'.$i.'</option>';}				?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue">Delivery Address: </td>
                  <td width="288" valign="top" align="left" class="eventText full_width"><textarea cols="22" rows="5" name="address" class="required" style="width:84%"></textarea></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite">City:</td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="text" id="city" class="formField required" name="city" style="width:82%"></td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenueWhite">Country:</td>
                  <td width="288" valign="top" align="left" class="eventTextWhite full_width"><select class="formField required" name="country"  style="width:87%">
                      <option value="">Select Country</option>
                      <?php while($country=mysql_fetch_assoc($country_query)){                        	                        	                        	?>
                      <option value="<?php echo $country['name'];?>"><?php echo $country['name'];?></option>
                      <?php }?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="width:100%; text-align:center;"><input type="checkbox" class="formField terms required" name="terms" id="terms" value="1" style="margin:0 0 0 180px;" />
                    &nbsp;<span>I agree to TKT Rush <a href="" style="float:none; text-decoration:underline;">Terms & Conditions</a></span> </td>
                </tr>
                <tr>
                  <td width="185" valign="middle" align="left" class="eventVenue"><input type="hidden" value="124" id="eid" name="eid"></td>
                  <td width="288" valign="top" align="left" class="eventText" style="padding-top:13px;"><input type="submit" style="background: none repeat scroll 0 0 #B13C4F; border: medium none;

    border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;" value="Save" id="SubButL" name="SubButL"></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once('footer.php'); ?>
</body></html>