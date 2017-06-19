<?
require("connection1.php");
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);



?>
<html>
<head>
<title><?require"title.php";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
$result = mysql_query( "SELECT * FROM tblnews where newsid=$newsid");
$num_fields = mysql_num_rows ($result);		
while($row = mysql_fetch_array($result)) 
		{   
		 
      $newsid=$row[newsid];
   $title=$row[title];
   $image=$row[image];
   $date=$row[date];
   $month=$row[month];
   $year=$row[year];
   $description=$row[description];	

   }
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3"><?require("head.php");?></td>
  </tr>
  <tr> 
    <td width="200" valign="top"><?require("contents.php");?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> 
      <form enctype=multipart/form-data method="post" action="viewnews.php">
        <br>
        <table width="70%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F5F5F5">
          <tr align="center" bgcolor="#CCCCCC"> 
            <td colspan="4" valign="top" height="20"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#666666">EDIT 
              NEWS</font></b></font></td>
          </tr>
          <tr> 
            <td width="13%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Title 
              <?echo"<input type=hidden name=newsid value=$newsid>";?>
              </font></td>
            <td colspan="3"> 
              <textarea name="title"><?echo"$title";?></textarea>            </td>
          </tr>
          <tr> 
            <td width="13%" valign="top" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Date</font></td>
            <td width="9%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Date 
              </font></td>
            <td width="16%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Month</font></td>
            <td width="62%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Year</font></td>
          </tr>
          <tr> 
            <td width="9%"> 
              <select name="date">
                <?
			echo"<option value=$date selected>$date</option>";
			?>
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
            <td width="16%"> 
              <select name="month">
                <?
			echo"<option value=$month selected>$month</option>";
			?>
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
            <td width="62%"> 
              <select name="year">
                <?
			echo"<option value=$year selected>$year</option>";
			?>
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
            <td width="13%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Image</font></td>
            <td colspan="3"> 
              <textarea name="image"><?echo"$image";?></textarea>
              <input type="file" name="userfile">            </td>
          </tr>
          <tr> 
            <td width="13%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Description</font></td>
            <td colspan="3"> 
              <textarea name="description" cols="50" rows="15"><?echo"$description";?></textarea>            </td>
          </tr>
          <tr align="center"> 
            <td colspan="4" valign="top"> 
              <input type="submit" name="update" value="Update">            </td>
          </tr>
        </table>
      </form>    </td>
  </tr>
</table>
</body>
</html>
