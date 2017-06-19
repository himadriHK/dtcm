<script language="JavaScript" type="text/javascript" src="wyzz.js"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php require("../title.php");?></title>
<link href="events.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function isblank(s) {

    for(var i = 0; i < s.length; i++) {

        var c = s.charAt(i);

        if ((c != ' ') && (c != '\n') && (c != '	')) return false;

    }
    return true ;
    }
	function checkform()
{  if (isblank(document.form1.mtitle.value)) {
   alert("Please Enter message title");
    document.form1.mtitle.focus();
     return false;
       }
        return true;
   }
</script>
</head>
<body>
<form id="form1" name="form1" method="post" action="newsletter.php" onSubmit="return checkform()">
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td height="150" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
	<?php
	require("head.php");
	 $edit=$HTTP_GET_VARS['edit'];
	$message_id=$HTTP_GET_VARS['message_id'];
	if ( isset($edit) && isset($message_id))
	{
	require("connection3.php");

	$sql="select * from  ticketma_ticketdbff_messages where message_id=".$message_id."" ;
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
		}
	?>
              &nbsp;</td>
          </tr>
        </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="160" valign="top"><div align="center"></div>
                      <?php  require("contents.php"); ?></td>
                  <td width="1" valign="top" background="images/up-dot.gif"><img src="images/up-dot.gif" width="1" height="3" /></td>
                  <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="5" bgcolor="#C31600">&nbsp;</td>
                              <td height="30" bgcolor="#C31600"><span class="eventHeader">NEWSLETTER</span></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td > Message</td>
                        <td >&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="41" colspan="2" align="left">Title     
                          <label><input name="mtitle" type="text" id="mtitle" <?php if($edit==1) echo "value='".$row['message_title']."'"?>/>
                          </label></td>
                      </tr>
                      <tr>
                        <td width="14%" height="19" valign="top">Message</td>
                        <td width="86%" valign="top">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="263" colspan="2" align="center" valign="top"> <label>
                          <textarea name="message" id="message" rows="15" cols="50" ><?php if($edit==1) echo "".$row['message_content'].""?>
						  </textarea>
                          <script language="javascript1.2">
                            make_wyzz('message');
                            </script>
						<input type='hidden' <?php if($edit==1) echo "value='".$message_id."' "; else echo "value='0' ";  ?> name='edit_id' />              
				        </label></td>
                      </tr>
                      <tr>
                        <td height="45" colspan="2" valign="bottom"><input name="submit" type="submit" id="send" value="send" />
                        <input name="submit" type="submit" id="save" value="save" /></td>
                      </tr>
                      <tr>
                        <td height="14" colspan="2">                       </td>
                      </tr>
                  </table></td>
                </tr>
              </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>