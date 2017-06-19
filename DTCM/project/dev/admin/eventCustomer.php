<?

include("../config.php");

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



function delCustomer(cid)
{
	if(confirm("Do you want to delete this customer?"))
	{
		document.form1.action="delCustomer.php?cid="+cid;
		document.form1.submit();
	
	}
}

var loadTime=0;
<?php
@session_start();
if(isset($_SESSION['loadTime']))
{
?>
 loadTime=<?php echo $_SESSION['loadTime'];?>;
<?php
}
?>
function loadCheck()
{
	if(loadTime==1)
	{
		location.reload(true);
		<?php
		unset($_SESSION['loadTime']);
		?>
	}
	loadTime=2;
}
</script>

</head>

<body  ><!--onLoad="loadCheck();"-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><?php

  require("connection3.php");

  $sql="select * from `event_customer` ";

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

				  <form name="form1" method="post" >

                      <tr align="center">

                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td width="5" bgcolor="#C31600" colspan="2"><span class="eventHeader">CUSTOMER</span></td>
							</tr>

                      <tr>

                        <td width="96%">

						<!-- Main table User to Display Emails-->

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor='#CAD0CE'>



	<?php 

    $sql="select c.*,e.title,e.ongoing from  event_customer c LEFT OUTER JOIN events e ON c.tid=e.tid ORDER BY dateAdded desc" ;
	
	$result=mysql_query($sql);

	

	

		while($row=mysql_fetch_array($result))

	{

    $linksql="select * from  ticketma_ticketdbff_link_table where email_num=".$row['e_id']." " ;

	$linkresult=mysql_query($linksql);

	$name="";

	
if($row['ongoing']==ONGOING)
{
	$ongoingEvent="On Going";
}
else if($row['ongoing']==UPCOMING)
{
	$ongoingEvent="Up Coming";
}
if($row['ongoing']==GUEST)
{
	$ongoingEvent="Guest List";
}
echo"
<tr >

  <td width='65%' colspan='2'><em>Event  Type: ".$ongoingEvent."</em></td>

</tr>

<tr >

  <td width='65%' colspan='2'><em>Event : ".$row['title']."</em></td>

</tr>

<tr >

  <td width='65%' colspan='2'><em>Name : ".$row['fname']." ".$row['lname']."</em></td>

</tr>

<tr>

  <td colspan='2'><em>Email : ".$row['email']."</em></td>

</tr>

<tr>

	<td colspan='2'><em>Mobile : ".$row['mobile']."</em></td>
</tr>
<tr>

	<td colspan='2'><em>No of Guest : ".$row['noGuest']."</em></td>
</tr>

<tr>

  <td colspan='2'><input type='button' value='Delete' name='btnDelete' onClick='javscript:delCustomer(".$row['eventCustomerId'].");' ></td></tr> 

  <tr bgcolor='#FFFFFF' height=10>

  

  <td colspan='2'><em></em></td></tr> 

  ";}	?>				  
   </table>  						</td>
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

