<?php require_once('Connections/eventscon.php'); ?>

<?php

$colname_guideRs = "-1";

if (isset($_GET['guideid'])) {

  $colname_guideRs = (get_magic_quotes_gpc()) ? $_GET['guideid'] : addslashes($_GET['guideid']);

$query_guideRs = sprintf("SELECT * FROM guide WHERE gid = %s", $colname_guideRs);



//echo $query_guideRs;

mysql_select_db($database_eventscon, $eventscon);

$guideRs = mysql_query($query_guideRs, $eventscon) or die(mysql_error());

$row_guideRs = mysql_fetch_assoc($guideRs);

$totalRows_guideRs = mysql_num_rows($guideRs);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>TicketMastersMe</title>

</head>



<body>

<div align="center">

  <table width="100%" border="0" cellspacing="1" cellpadding="1">

    <?

for($i=1;$i<11;$i++){

if($row_guideRs['pic'.$i]!=""){

?>

    <tr>

      <td><div align="center"><img src="data/<?php echo $row_guideRs['pic'.$i]; ?>" /></div></td>

    </tr>

    <? }} ?>

  </table>

  <? } ?>

</div>
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

