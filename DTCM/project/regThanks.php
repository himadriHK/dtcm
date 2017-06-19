<?php require_once('Connections/eventscon.php'); ?>

<?php include("functions.php"); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $row_eventRs['title']; ?></title>

<link href="css/TM_style.css" rel="stylesheet" type="text/css" />
<script>
function funDedirect()
{
    window.location.replace('index.php');	
}
</script>

</head>

<body onload="setTimeout (funDedirect() , 60000 );" >

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">


  <tr>

    <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">


        <tr>

          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="center" valign="top"><form action="register1.php" method="POST" name="frmRegister" >

                    <table width="100%" border="0" cellpadding="4" cellspacing="1">

                     
                  

                      

                      <tr>

                        <td align="left" valign="middle" class="eventVenue">Thank You for registering. We will inform you when the ticket are available.</td>
                      </tr>


                    </table>

                    

                </form></td>
              </tr>

            </table></td>
        </tr>

        <!--<tr>

          <td><img src="images/g-dot.jpg" width="7" height="7" /></td>
        </tr>-->

      </table></td>
  </tr>
</table>

<?php

//mysql_free_result($eventRs);

?>
<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-11947961-2");

pageTracker._trackPageview();

} catch(err) {}</script>
</body>

</html>

<?php

//mysql_free_result($shiplist);

?>

