<?php require_once('header.php'); ?>
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#content"
 });
</script>
<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>
<!--
ADDED BY KRANTHI ON 10-05-2015
POST VaLuES  And sEnd EMAIL	
-->
<?php
$mailsuccessMsg = '';
$mailfailMsg = '';
$emailErrMsg = '';
$subjectErrMsg = '';
$messageErrMsg = '';

        
if(!empty($_POST['submit']))
{
	
	if(!empty($_POST['requester'])){ $requester = $_POST['requester']; } else { $requester = ''; }
	if(!empty($_POST['subject'])){ $subject = $_POST['subject']; } else { $subject = ''; }
	if(!empty($_POST['content'])){ $content = $_POST['content']; } else { $content = ''; }
	
	
	$email_to = "info@tktrush.com";
    $email_subject = $subject;
	$email_message = '';
	function clean_string($string) 
	{
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Requester: ".clean_string($requester)."<br>";
 
    $email_message .= "Message: ".clean_string($content)."\n";
	
	// create email headers
 
    $headers = 'From: '.$requester."\r\n".
    'MIME-Version: 1.0' . "\n".
    'Content-type: text/html; charset=iso-8859-1' . "\n".
 
    'Reply-To: '.$email_from."\r\n" .
 
    'X-Mailer: PHP/' . phpversion();
 
    if(@mail($email_to, $email_subject, $email_message, $headers))
	{
		$mailsuccessMsg = 'Thank you for contacting us. We will be in touch with you very soon.';

	}
	else
	{
		$mailfailMsg = 'Mail send Failed';
	}
	
	//exit;
}

?>

<!--KRANTHI ENDS-->
<div class="conent-right">
<?php //require_once('banner2.php'); ?>
<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php //require_once('menu.php'); ?>
<div class="shows-box">
<div class="leftcont">
<h1>Contact Us</h1>

<div class="shows-box-frames">

 <table width="100%" border="0" cellspacing="0" cellpadding="0">
               
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><b>Ticket Rush</b></td>
                            </tr>
                            
                            <tr>
                              <td height="20">P.O.Box:119721, Dubai, UAE</td>
                            </tr>
                            
                            <tr>
                              <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="60" height="20"><span style="width:49px;">Tel:</span></td>
                                  <td><span style="width:400px;">+971 4 442 1155</span></td>
                                </tr>
                                <tr>
                                  <td height="20"><span style="width:49px;">Fax:</span></td>
                                  <td><span style="width:400px;">+971 4 442 1166</span></td>
                                </tr>
                                <tr>
                                  <td height="20"><span style="width:49px;">Email: </span></td>
                                  <td><span style="width:400px;"><a href="mailto:info@tktrush.com" class="emailcontact">info@tktrush.com</a></span></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td height="20" class="dot_line">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20"><b>General Manager:</b> Mr. Nasser Tabbah</td>
                            </tr>
                            <tr>
                              <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="60" height="20"><span style="width:49px;">Bobile:</span></td>
                                  <td><span style="width:400px;"> 00971 50 456 27 78 <br />
                                  </span></td>
                                </tr>
                                
                                <tr>
                                  <td height="20"><span style="width:49px;">Email: </span></td>
                                  <td><span style="width:400px;"><a href="mailto:nasser@tktrush.com" class="emailcontact">nasser@tktrush.com</a></span></td>
                                </tr>
                              </table>
                              <br /></td>
                            </tr>

                          </table></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                    </table>
  </div></div>
  <!--Added by KRANTHI 10-05-2015
FORM AREA STARTS	
-->
<div style="color:green;font-weight: bold;"><?php echo $mailsuccessMsg; ?></div>
<div style="color:red;font-weight: bold;"><?php echo  $mailfailMsg; ?></div>
<div class="rightcont">
	<div style="margin:0 0 15px;"><strong>Help & Support</strong></div>
	
	<form name="form1" id="form1" action="#" method="POST" onsubmit="return validate();" enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td><input type="text" name="requester" id="requester" value=""  placeholder="Requester" class="reqst"></td>
		</tr>
		<tr>
			<td><input type="text" name="subject" id="subject" value=""  placeholder="Subject" class="subj"></td>
		</tr>
		<tr>
			<td><textarea name="content" cols="50" rows="20" id="content"></textarea></td>
		</tr>
		<tr>
			<td align="right"><input type="submit" name="submit" id="submit" value="Submit" /></td>
		</tr>
	</table>
    </form>
	
</div>



<!--Added by KRANTHI 10-05-2015
FORM AREA ENDS	
-->
</div>

</div>

</div>
</div>

<script type="text/javascript">
	function validate()
	{
		//var email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(document.getElementById('requester').value=='')
		{
			alert('Requester should not be empty.');
			//document.getElementById('requester').value='';
			//document.getElementById('requester').focus;
			document.form1.requester.focus() ;
			return false;
		}
		if(document.getElementById('subject').value=='')
		{
			alert('Subject should not be empty.');
			//document.getElementById('subject').value='';
			//document.getElementById('subject').focus;
			document.form1.subject.focus() ;
			return false;
		}
		/*if(document.getElementById('content').value=='')
		{
			alert('Content should not be empty.');
			//document.getElementById('content').value='';
			//document.getElementById('content').focus;
			document.form1.content.focus() ;
			return false;
		}*/
		return true;
	}
	
</script>
<?php require_once('footer.php'); ?>

</body>
</html>
