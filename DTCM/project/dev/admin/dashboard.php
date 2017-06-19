<?php 
require("access.php"); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.headeradmin {color: #C31600}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" valign="top" style="padding-left:0;"><?php require("contents.php"); ?></td>
        <td width="1" valign="top" background="../images/up-dot.gif" style="padding:0;"><img src="../images/up-dot.gif" width="1" height="3"></td>
        <td valign="top" style="padding:0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600" style="vertical-align:middle;"><span class="eventHeader"><span class="headeradmin">-</span>VIEW DASHBOARD </span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif" style="padding:0;"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><?php require("salesinfoadmin.php"); ?></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>