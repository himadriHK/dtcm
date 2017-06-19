<?

if($action == "delete")

{

deletePartner($partnerid);

 ?>

<script language="javascript">

location.replace("viewpartner.php");

</script>

<?
}
if($action == "set")
{  
$filename = $HTTP_POST_FILES['image']['name']; 
$uploadpath = '../siteimages/'; 
$path ="siteimages/";
$source = $HTTP_POST_FILES['image']['tmp_name']; 
$dest = ''; 
    if ( ($source != 'none') && ($source != '' )) { 
$loc = rand(1,99);
$dest = $uploadpath.$loc.$filename;
$path .= $loc.$filename;
if ( $dest != '' ) {  if ( move_uploaded_file( $source, $dest ) ) { 
@chmod ($dest , 0755);   //echo 'File successfully stored.<BR>'; 

} else { 
$path='';
// echo 'File could not be stored.<BR>'; 

} 
}  
} else { 
$path='';  
//echo 'File not supplied, or file too big.<BR>'; 
} 

setPartner($partnerid,$name,$path,$url);

 ?>

<script language="javascript">

location.replace("viewpartner.php");

</script>

<?

}
$Submit=1;
if($Submit)
{
if($Submit=="Submit" || $Submit == 2) $s = 0;
// rows to return
$limit=5; 
// Build SQL Query  
$query = "SELECT * FROM `tblpartners` "; 
 // EDIT HERE and specify your table and field names for the SQL query
 $query.= " Where 1 ";
 $query.= " ORDER BY partnerid DESC";
 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);

}

?>

<?
// next determine if s has been passed to script, if not use 0

  if (empty($s)) {

  $s=0;

  }



 if($Submit){// get results

  $query .= " limit $s,$limit";

  $result = mysql_query($query) or die("Couldn't execute query");

  $count = 1 + $s ;

  }

?>

<?

	  

if($Submit) {

$currPage = (($s/$limit) + 1);







  // next we need to do the links to other results

 

// calculate number of pages needing links

  $pages=intval($numrows/$limit);



// $pages now contains int of pages needed unless there is a remainder from division



  if ($numrows%$limit) {

  // has remainder so add one page

  $pages++;

  }

  }

  

viewpartner.php

 ?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style2 {color: #000000}
-->
</style>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td>

<?

if($action == "edit"){

$row1 = getPartner($partnerid);

?>
<form action="viewpartner.php?s=<?=$s?>&Submit=2&categoryid=<?=$categoryid?>&action=set&partnerid=<?=$partnerid?>" method="post" enctype="multipart/form-data" name="form2">
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" >

          <tr bgcolor="#990066">

            <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="0" background="images/common/title_bg_1.gif">

              <tr>

                <td height="25" bgcolor="#C31600" class="pmLabel">&nbsp;&nbsp; <font size="2"  face="Arial" color="#ffffff"><strong>Edit Partner details </strong></font>                  <!--<a href="comments.htm">Comments</a> |--></td>
                </tr>

            </table>            </td>
          </tr>


          <tr>

            <td width="200" bgcolor="#CCCCCC"><div align="right" class="style1">Company Name : </div></td>
            <td bgcolor="#EEEEEE">&nbsp;&nbsp;

                <input name="name" type="text" id="name" value="<?=$row1->name?>" size="60"></td>
          </tr>

          <tr>

            <td valign="top" bgcolor="#CCCCCC"><div align="right"><span class="style1">Logo</span><strong>:</strong></div></td>
            <td bgcolor="#EEEEEE">&nbsp;&nbsp;

                <input type="file" name="image" >

            <? if($row1->image){?><img src="<?="../".$row1->image?>" width="80" height="80"><? } ?></td>
          </tr>

          <tr>

            <td bgcolor="#CCCCCC">

              <div align="right" class="style1"> Website URL: </div></td>

            <td bgcolor="#EEEEEE">&nbsp;&nbsp;

                <input name="url" type="text" id="url" value="<?=$row1->url?>" size="60"></td>
          </tr>

          <tr>

            <td height="34" colspan="2">

              <div align="center">

                <input name="Set" type="submit" class="pmBtn" id="Set" value="Save">

&nbsp;&nbsp;&nbsp;

                <input name="Reset" type="reset" class="pmBtn" value="Reset">
            </div></td>
          </tr>
        </table>

    </form>

	<script language="JavaScript" type="text/javascript">

//You should create the validator only after the definition of the HTML form

  var frmvalidator  = new Validator("form2");

  frmvalidator.addValidation("name","req","Please Enter Nmae of the COmpany");

  frmvalidator.addValidation("url","req","URL Field is Empty");
</script>
<?
}
else {
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td bgcolor="#FFFFFF"><form action="index.php" method="post"  name="form1">

			<input name="page" type="hidden" value="viewnews">

<table width="99%"     border="0" align="center" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFCCCC">
<td colspan="2" bgcolor="#990066">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" background="images/common/title_bg_1.gif">
<tr>
<td height="25" bgcolor="#C31600" class="pmLabel">&nbsp;&nbsp; <font size="2"  face="Arial" color="#ffffff"><strong> Partners</strong></font><!--<a href="comments.htm">Comments</a> |--></td>
</tr>
</table></td>
</tr>

<?
if ($numrows == 0)
  {
?>
<tr>
<td colspan=2>
<p align="center"><font color="#FF0000"><strong>No Partners Found</strong></font></p></td>
</tr>
<?
  }

  else

  {

?>
<tr><td colspan="2">&nbsp;</td></tr>
<?

// now you can display the results returned

  $i=0;

  while ($row= mysql_fetch_object($result)) {

  ?>

            <tr  bgcolor=<? if($i%2) echo "#ffffff"; else echo "#ffffff";?>>

              <td> 

                <table width="100%"  border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td width="77%"><font color=#FF3300 size=2 face=tahoma><strong>

                      <?=$row->name?>

                    </strong></font></td>

                    <td width="100" rowspan="3"><? if($row->image){ ?><a href="<?=$row->url;?>" target="blank">

                        <img src="../<?=$row->image?>" width="100" height="100" border="0"></a>

                        <? } ?></td>
                  </tr>

                  <tr class="pmHpetion">

        <td><a href="<?=$row->url;?>" target="blank"><? echo $row->url;?></a></td>
                  </tr>

                  <tr class="pmHfavour">

                    <td>&nbsp;</td>
                  </tr>
                </table></td>

              <td width="100">  <a href="viewpartner.php?s=<?=$s?>&Submit=1&action=delete&partnerid=<?= $row->partnerid?>" onClick="return confirmSubmit()"><FONT COLOR=#FF3300 SIZE=2 FACE=tahoma>Delete</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="viewpartner.php?s=<?=$s?>&Submit=1&categoryid=<?=$categoryid?>&action=edit&partnerid=<?= $row->partnerid?>"><FONT COLOR=#FF3300 SIZE=2 FACE=tahoma>Edit</font></a></td>
            </tr>

<tr><td colspan="2"><hr></td></tr>

            <?

  }

 

?>
<tr bgcolor="#003333">
<td height="25" colspan="2" align="center" bgcolor="#FFFFFF">
<font face="Arial" size="1"><span class="style2">
<?			   if ($numrows != 0)
{
 if ($s>=1) { // bypass PREV link if s is 0
$prevs=($s-$limit); print "&nbsp;<a href=\"$PHP_SELF?$QUERY_STRING&s=$prevs&Submit=1\">"."<font face=\"Arial\" color=\"#000000\" size=\"1\"> Prev "." ".$limit."</font></a>";
			  }

			  }
?>
</span></font><span class="style2"> &nbsp;&nbsp;
<?

$a = $s + ($limit) ;

  if ($a > $numrows) { $a = $numrows ; }

  $b = $s + 1 ;

  echo "Showing results $b to $a of $numrows";

  }
?>
&nbsp;&nbsp; <font face="Arial" size="1">
<? // check to see if last page
if ($numrows != 0)

  {

  if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {
  // not last page so give NEXT link

$news=$s+$limit;
echo "&nbsp;<a href=\"$PHP_SELF?$QUERY_STRING&s=$news&Submit=1\">"."<font face=\"Arial\" color=\"#ffffff\" size=\"1\"> Next "." ".$limit."</font></a>";
  }

  }

?>
 </font> </span></td>
 </tr>
 </table>
</form>
<script language="JavaScript" type="text/javascript">

//You should create the validator only after the definition of the HTML form
var frmvalidator  = new Validator("form1");
</script></td>
</tr>
</table>
<?
}
?>
</td>

</tr>

</table>

