<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
?>
<title><?require"title.php";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256"><body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2">
      <?require("head.php");?>
    </td>
  </tr>
  <tr> 
    <td width="200" valign="top" bgcolor=<?echo"$contentbg";?>> 
      <?require("contents.php");?>    </td>
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
                <td colspan="2"><font face="Tahoma" color="#FF0000"><b><font size="2">Do 
                  you really want to delete record?</font></b></font></td>
              </tr>
              <tr> 
                <td width="10%"> 
                  <form action=viewnews.php method=post>
                    <?echo"<input type=hidden name=del value=$del>";?>
                    <input type="submit" name="yes" value="Yes">
                  </form>
                </td>
                <td width="90%"> 
                  <form action=viewnews.php method=post>
                    <input type="submit" name="no" value="No ">
                  </form>
                </td>
              </tr>
            </table>
            <?}?>
          </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
          <td align="right">&nbsp; </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
