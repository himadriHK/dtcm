<?
require_once("connection.php");
require_once("dbfunctions2.php");
?>

<html>

<head>

<title><?require"title.php";?></title>
<link href="events.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--
.headeradmin {color: #C31600}
-->
</style>
</head>



<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" valign="top"><?php require("contents.php"); ?></td>
        <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>PARTNERS MANAGER </span></td>
              </tr>
              <tr>
                <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?require_once("partnermain.php");?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>

</html>

