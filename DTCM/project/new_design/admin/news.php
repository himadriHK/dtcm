<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);


if($save)
{
	if($title=="")
	{
		echo"<b><font color=red>Please Enter Title</font></b>";
	}
else
	{
					
	$result1 = mysql_query( "SELECT * FROM tblnews where title='$title' and date='$date'");
	$num_row = mysql_num_rows ($result1);	
		
	if($num_row == 0)
		{
		
		if (@copy ($userfile,"../images/".$userfile_name))
		{
		//echo"Image Copied";
		}		
		$query = "insert into tblnews(title,date,month,year,image,description)values('$title','$date','$month','$year','$userfile_name','$description')";
		mysql_query($query);		
		echo"<font color=red size=4 face=verdana>News Added.</font>";	
		}
	else
		{
		echo"<font color=red size=4 face=verdana>News with this title is already exist.</font>";
		}
	
	} 
}

?>
<html>
<head>
<title><?require"title.php";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?require("head.php");?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr> 
    <td width="200" valign="top"><?require("contents.php");?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> 
      <form enctype=multipart/form-data method="post" action="<?echo"$PHP_SELF";?>">
        <br>
        <table width="70%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F5F5F5">
          <tr align="center" bgcolor="#EAEAEA"> 
            <td colspan="4" valign="top" height="25"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#FF9900">NEWS</font></b></font></td>
          </tr>
          <tr> 
            <td width="31%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">News 
              Title<font color="#FF0000"> *</font></font></td>
            <td width="69%" colspan="3"> 
              <input type="text" name="title" size="30">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">News 
              Date</font></td>
            <td width="12%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Date 
              </font></td>
            <td width="12%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Month</font></td>
            <td width="58%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Year</font></td>
          </tr>
          <tr> 
            <td width="12%"> 
              <select name="date">
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
              </select>            </td>
            <td width="12%"> 
              <select name="month">
                <option value="January">January</option>
                <option value="Feburary">Feburary</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>            </td>
            <td width="58%"> 
              <select name="year">
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
              </select>            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">News 
              Pic </font></td>
            <td width="69%" colspan="3"> 
              <input type="file" name="userfile">            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">News</font></td>
            <td width="69%" colspan="3"> 
              <textarea name="description" cols="50" rows="25"></textarea>            </td>
          </tr>
          <tr align="center"> 
            <td colspan="4" valign="top"> 
              <input type="submit" name="save" value="Save">
              <input type="reset" name="Submit2" value="Clear">            </td>
          </tr>
          <tr align="center" valign="bottom"> 
            <td colspan="4" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="viewnews.php"><font color="#999999">View 
              News </font></a></font></td>
          </tr>
        </table>
      </form>    </td>
  </tr>
</table>
</body>
</html>
