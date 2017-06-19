<title><?require"title.php";?></title>
<link href="events.css" rel="stylesheet" type="text/css" />
<body bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td width="850" valign="top"> 
      <div align="center"></div>
      <table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">
        <tr> 
          <td valign="top"> 
            <?
		  if($del)
		  {
		  ?>
            <table width="50%" border="0" cellspacing="0" cellpadding="1">
              <tr> 
                <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000"><b><font size="2">Do 
                  you really want to delete record?</font></b></font></td>
              </tr>
              <tr> 
                <td width="10%"> 
                  <form action=viewphoto.php method=post>
                    <?echo"<input type=hidden name=del value=$del>";
echo"<input type=hidden name=more value=$more>";?>
                    <input type="submit" name="yes" value="Yes">
                  </form>                </td>
                <td width="90%"> 
                  <form action=viewphoto.php method=post>
                    <?echo"<input type=hidden name=more value=$more>";?>
                    <input type="submit" name="no" value="No ">
                  </form>                </td>
              </tr>
            </table>
            <?}?>          </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
          <td align="right">&nbsp; </td>
        </tr>
      </table>    </td>
  </tr>
</table>
