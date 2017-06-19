<?php require_once('Connections/eventscon.php'); ?>

<?php include("functions.php"); ?>

<?php include("config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<?php

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}



$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}



/*

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

}

*/



$colname_eventRS = "-1";

if (isset($_GET['eid'])) {

  $colname_eventRS = (get_magic_quotes_gpc()) ? $_GET['eid'] : addslashes($_GET['eid']);

}

mysql_select_db($database_eventscon, $eventscon);

$query_eventRS = sprintf("SELECT tid, title, thumb, date_start, date_end, venue, age_limit, country, ongoing FROM events WHERE tid = %s", $colname_eventRS);

$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$totalRows_eventRs = mysql_num_rows($eventRs);



mysql_select_db($database_eventscon, $eventscon);

$query_shiplist = "SELECT * FROM shippingrates ORDER BY name ASC";

$shiplist = mysql_query($query_shiplist, $eventscon) or die(mysql_error());

$row_shiplist = mysql_fetch_assoc($shiplist);

$totalRows_shiplist = mysql_num_rows($shiplist);



$buy_date = "<select name='sessiondate' class='formField'>

";

if($row_eventRs['ongoing']==ONGOING) {

	$buy_date .= "<option value='".ONGOING."'>Ongoing</option>";

//	echo "option1";

}
#added on dec 24
else if($row_eventRs['ongoing']==GUEST)
{
	#guest events
	$buy_date .= "<option value='".GUEST."'>Guest</option>";
}
 elseif (($row_eventRs['date_start']!="0000-00-00")&&($row_eventRs['date_end']!="0000-00-00")){

		list($year, $month, $day, $hour, $minute, $second) = split('[-: ]', $row_eventRs['date_end']);

		$edate = mktime($hour, $minute, $second, $month, $day, $year);

		list($year, $month, $day, $hour, $minute, $second) = split('[-: ]', $row_eventRs['date_start']);

		$sdate = mktime($hour, $minute, $second, $month, $day, $year);

		$date_diff = floor(($edate-$sdate)/86400);

	for($i=0;$i<$date_diff+1;$i++){

		$buy_date .= "<option value='".date("Y-m-d", mktime($hour, $minute, $second, $month, $day, $year))."'>".date("d M Y", mktime($hour, $minute, $second, $month, $day, $year))."</option>";

	$day++;

	}

//	echo "option2"." - ".$row_eventRs['date_start']." - ".$row_eventRs['date_end'];

} else {

		list($year, $month, $day, $hour, $minute, $second) = split('[-: ]', $row_eventRs['date_start']);

		$sdate = mktime($hour, $minute, $second, $month, $day, $year);

		$buy_date .= "<option value='".date("Y-m-d", mktime($hour, $minute, $second, $month, $day, $year))."'>".date("d M Y", mktime($hour, $minute, $second, $month, $day, $year))."</option>";

//	echo "option3";

}

$buy_date .= "

</select>";



function gettickets($eventid){

$ticketid_ticketsRs = $eventid;

//echo $ticketid_ticketsRs;

$query_ticketsRs = sprintf("SELECT event_prices.* FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price asc", $ticketid_ticketsRs);

//echo $query_ticketsRs;

$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());

$row_ticketsRs = mysql_fetch_assoc($ticketsRs);

//$totalRows_ticketsRs = mysql_num_rows($ticketsRs);

$soption = "";

$i=0;

echo "<script language='javascript'>\n";

echo "var pid=new Array();\n";

echo "var stand=new Array();\n";

echo "var currency=new Array();\n";

echo "var price=new Array();\n";

echo "var cprice=new Array();\n";

echo "var ticket=new Array();\n";

echo "var cticket=new Array();\n";

do { 

$query_oticketsRs = sprintf("select sum(tickets) adult, sum(ctickets) child from ticket_orders where tid = %s and ticket_price = '%s'", $ticketid_ticketsRs,$row_ticketsRs['stand']);

//echo $query_oticketsRs;

$oticketsRs = mysql_query($query_oticketsRs) or die(mysql_error());

$row_oticketsRs = mysql_fetch_assoc($oticketsRs);



echo "pid[".$i."]='".$row_ticketsRs['pid']."';\n";

echo "stand[".$i."]='".$row_ticketsRs['stand']."';\n";

echo "currency[".$i."]='".$row_ticketsRs['currency']."';\n";

echo "price[".$row_ticketsRs['pid']."]='".$row_ticketsRs['price']."';\n";

echo "cprice[".$row_ticketsRs['pid']."]='".$row_ticketsRs['cprice']."';\n";



if ($row_oticketsRs['adult'] < $row_ticketsRs['ticket']){

echo "ticket[".$i."]='".$row_ticketsRs['ticket']."';\n";

} else {

echo "ticket[".$i."]=0;\n";

}



if ($row_oticketsRs['child'] < $row_ticketsRs['cticket']){

echo "cticket[".$i."]='".$row_ticketsRs['cticket']."';\n";

} else {

echo "cticket[".$i."]=0;\n";

}



$soption.="<option value='".$row_ticketsRs['pid']."'>".$row_ticketsRs['stand']."</option>";

$i++;

} while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs)); 

echo "</script>";

echo "<select name=prices  class='formField' onchange='getTotal()'>";

echo $soption;

echo "</select>";

mysql_free_result($ticketsRs);

}
$query_guidecatRs = "SELECT * FROM `banners`";

$guidecatRs = mysql_query($query_guidecatRs, $eventscon) or die(mysql_error());
$images = mysql_fetch_array($guidecatRs);
?>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $row_eventRs['title']; ?></title>

<link href="css/TM_style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript">

<!--

function getTotal(){

var k = document.form1.prices.value;

document.form1.price.value = price[k];

document.form1.cprice.value = cprice[k];



if (price[k]==0){ document.form1.tickets.readOnly = true; }

if (cprice[k]==0){ document.form1.ctickets.readOnly = true; }



var tottickets;

tottickets = 0;

if(document.form1.tickets.value!=0){

tottickets = Number(price[k] * document.form1.tickets.value);

}



if(document.form1.ctickets.value!=0){

tottickets = Number(tottickets + Number(cprice[k] * document.form1.ctickets.value));

}



//if(document.form1.paytype[0].checked){

tottickets = Number(tottickets + Number(document.form1.regions.value));

document.form1.charges.value = document.form1.regions.value;

//document.form1.action ="vpc_php_serverhost_do.php";

//alert("CC");

//} else {

//alert("spot");

//document.form1.action ="events_confirm.php";

//}



document.form1.totalticket.value = tottickets;

document.form1.vpc_Amount.value = tottickets*100;

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function YY_checkform() { //v4.66

//copyright (c)1998,2002 Yaromat.com

  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;

  for (var i=1; i<args.length;i=i+4){

    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}

    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));

    myV=myObj.value;

    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){

      if (myReq&&myObj.value.length==0){addErr=true}

      if ((myV.length>0)&&(args[i+2]==1)){ //fromto

        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}

      } else if ((myV.length>0)&&(args[i+2]==2)){

          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;

      } else if ((myV.length>0)&&(args[i+2]==3)){ // date

        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);

        if(myAt){

          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];

          var myDate=new Date(myY,myM,myD);

          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};

        }else{addErr=true}

      } else if ((myV.length>0)&&(args[i+2]==4)){ // time

        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}

      } else if (myV.length>0&&args[i+2]==5){ // check this 2

            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));

            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];

            if(!myObj1.checked){addErr=true}

      } else if (myV.length>0&&args[i+2]==6){ // the same

            var myObj1 = MM_findObj(args[i+1]);

            if(myV!=myObj1.value){addErr=true}

      }

    } else

    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){

          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);

          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;

      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}

      if (args[i+2]==2){

        var myDot=false;

        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}

        if(!myDot){myErr+='* ' +args[i+3]+'\n'}

      }

    } else if (myObj.type=='checkbox'){

      if(args[i+2]==1&&myObj.checked==false){addErr=true}

      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}

    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){

      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}

    }else if (myObj.type=='textarea'){

      if(myV.length<args[i+1]){addErr=true}

    }

    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}

  }

  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}

  document.MM_returnValue = (myErr=='');

}

//-->

</script>

<style type="text/css">

.form_bg {
    background: none repeat scroll 0 0 rgba(255, 255, 255, 0.93);
    border: 1px solid rgba(255, 255, 255, 0.59);
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 0 10px #888888;
    font-family: arial;
    font-size: 13px;
    margin-top: 40px !important;
    padding: 20px;
}

.form_bg input{

}

.full_width{

}

.full_width input{
width:76%;
padding:5px;
margin-right:5px;
background:#ffffff;
border:1px solid #ccc;
}

.full_width textarea{
width:76%;
padding:5px;
margin-right:5px;
background:#ffffff;
border:1px solid #ccc;
}

.full_width select{
width:80%;
padding:5px;
margin-right:5px;
background:#ffffff;
border:1px solid #ccc;
}

.full_width_small input{
width:80px;
padding:5px;
margin-right:5px;
background:#ffffff;
border:1px solid #ccc;
}


</style>

</head>

<body onload="getTotal()" style="margin:0; padding:0;">




<div style="background:url(<?php echo $images['p_image']; ?>)  no-repeat scroll center -252px #08090D; position:fixed; width:100%; height:100%; z-index:-1; top:0; left:0;"></div>


<div style="width: 500px; margin: 40px auto 40px;" class="form_bg">



<table>

              <tr>

                <td align="center" valign="top"><form action="vpc_php_serverhost_do.php" method="POST" name="form1" id="form1" onsubmit="YY_checkform('form1','checkbox','#q','1','Please select declaration.','paytype[1]','#q','2','Please select payment type.','tickets','#1_100','1','Please enter no. of tickets.','fname','#q','0','Please enter your first name.','lname','#q','0','Please enter your last name.','mobile','#q','0','Please enter your mobile.','email','S','2','Please enter your email.','city','#q','0','Please enter your city of residence.','country','#q','1','Please select your country.');return document.MM_returnValue">

                    <table width="100%" border="0" cellpadding="4" cellspacing="1">

                      <tr align="left" valign="middle">
                        <td colspan="2"><b><?php echo $row_eventRs['title']; ?></b></td>


                      </tr>
                      <tr align="left" valign="middle">

                        <td colspan="2"><?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} else if($row_eventRs['ongoing']==GUEST){}
 else { ?><?php echo eventFirstDate($row_eventRs['date_start']); ?><?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo " to ".eventFirstDate($row_eventRs['date_end']);} ?><?php echo " ".eventSecondDate($row_eventRs['date_start']); ?><?php }?></td>
                      </tr>

                      <tr align="left" valign="middle" class="eventVenue">

                        <td colspan="2" class="eventVenueWhite"><?php echo $row_eventRs['venue']; ?></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue">Session: </td>

                        <td width="288" align="left" valign="top" class="eventText full_width"><?php echo $buy_date; ?></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite">Stand: </td>

                        <td width="288" align="left" valign="top" class="eventTextWhite full_width"><?php gettickets($row_eventRs['tid']); ?></td>
                      </tr>

                      <tr>

                        <td align="left" valign="middle" class="eventVenueWhite ">Tickets: </td>

                        <td align="left" valign="top" class="eventTextWhite"><table width="270" border="0" cellspacing="0" cellpadding="0">

                          <tr>

                            <td width="140">Adult</td>

                            <td width="130">Child</td>
                          </tr>

                          <tr>

                            <td width="140" class="full_width_small"><input name="price" type="text" class="formField" id="price" readonly="readonly" /></td>

                            <td width="130" class="full_width_small"><input name="cprice" type="text" class="formField" id="cprice" readonly="readonly" /></td>
                          </tr>

                        </table></td>
                      </tr>

                      <tr>

        <td width="185" align="left" valign="middle" class="eventVenue">No. of Tickets: </td>

        <td width="288" align="left" valign="top" class="eventText"><table width="270" border="0" cellspacing="0" cellpadding="0">

                          <tr>

        <td width="140" class="full_width_small"><input name="tickets" type="text" class="formField" id="tickets" onchange="getTotal()" value="0" size="2" /></td>

        <td width="130" class="full_width_small"><input name="ctickets" type="text" class="formField" id="ctickets" onchange="getTotal()" value="0" size="2" /></td>
                          </tr>

                        </table>                        </td>
                      </tr>

                      <tr>

                        <td align="left" valign="middle"  class="eventVenueWhite">Delivery Region: </td>

                        <td align="left" valign="top" class="eventTextWhite full_width">

						<select name="regions" id="regions" onchange="getTotal()">

						  <?php

do {  
							if($row_shiplist['name']=="No Delivery / Will Call")
							{
								$selected="selected";
							}
							else
							{
								$selected="";
							}

?>

						  <option value="<?php echo $row_shiplist['rate']?>" <?php echo $selected;?>><?php echo $row_shiplist['name']?></option>

						  <?php

} while ($row_shiplist = mysql_fetch_assoc($shiplist));

  $rows = mysql_num_rows($shiplist);

  if($rows > 0) {

      mysql_data_seek($shiplist, 0);

	  $row_shiplist = mysql_fetch_assoc($shiplist);

  }

?>
                        </select> 

<!--                          <option value="10">Middle East</option>

                          <option value="50">Africa</option>

                          <option value="100">America</option>

                          <option value="30">Asia</option>


                          <option value="100">Australia</option>

                          <option value="100">Europe</option>

 -->                          </br>Delivery Charges(Dhs.):                          

                          <input name="charges" type="text" class="formField" id="charges" size="2" onchange="getTotal()" /></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite">Total:</td>

                        <td width="288" align="left" valign="top" class="eventTextWhite full_width"><input name="totalticket" type="text" class="formField" id="totalticket" readonly />

                        <input name="vpc_Amount" type="hidden" id="vpc_Amount" /></td>
                      </tr>

                      <tr align="left" valign="middle">

                        <td colspan="2" class="eventHeader">&nbsp;</td>
                      </tr>

                      <tr align="left" valign="middle">

                        <td colspan="2" class="eventHeader"><b>Your Details</b></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite ">First Name: </td>

                        <td width="288" align="left" valign="top"  class="eventTextWhite full_width"><input name="fname" type="text" class="formField" id="fname" /></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue ">Last Name: </td>

                        <td width="288" align="left" valign="top" class="eventText full_width"><input name="lname" type="text" class="formField" id="lname" /></td>
                      </tr>
					  
					  <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue">Address: </td>

                        <td width="288" align="left" valign="top" class="eventText full_width"><textarea name="address" rows="5" cols="22"></textarea></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite">Mobile:</td>

                        <td width="288" align="left" valign="top"  class="eventTextWhite full_width"><input name="mobile" type="text" class="formField" id="mobile" /></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue">Email:</td>

                        <td width="288" align="left" valign="top" class="eventText full_width"><input name="email" type="text" class="formField" id="email" /></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite">City:</td>

                        <td width="288" align="left" valign="top"  class="eventTextWhite full_width"><input name="city" type="text" class="formField" id="city" /></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle"  class="eventVenueWhite">Country:</td>

                        <td width="288" align="left" valign="top"  class="eventTextWhite full_width">

						<select name="country" class="formField" >

                            <option>Select Country</option>

                            <option value="AFGHANISTAN">AFGHANISTAN</option>

                            <option value="ALGERIA">ALGERIA</option>

                            <option value="ANGOLA">ANGOLA</option>

                            <option value="ANGUILLA">ANGUILLA</option>

                            <option value="ANTARCTICA">ANTARCTICA</option>

                            <option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>

                            <option value="ARGENTINA">ARGENTINA</option>

                            <option value="ARMENIA">ARMENIA</option>

                            <option value="ARUBA">ARUBA</option>

                            <option value="AUSTRALIA">AUSTRALIA</option>

                            <option value="AUSTRIA">AUSTRIA</option>

                            <option value="AZERBAIJAN">AZERBAIJAN</option>

                            <option value="BAHAMAS">BAHAMAS</option>

                            <option value="BAHRAIN">BAHRAIN</option>

                            <option value="BANGLADESH">BANGLADESH</option>

                            <option value="BARBADOS">BARBADOS</option>

                            <option value="BELARUS">BELARUS</option>

                            <option value="BELGIUM">BELGIUM</option>

                            <option value="BELIZE">BELIZE</option>

                            <option value="BENIN">BENIN</option>

                            <option value="BERMUDA">BERMUDA</option>

                            <option value="BHUTAN">BHUTAN</option>

                            <option value="BOLIVIA">BOLIVIA</option>

                            <option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>

                            <option value="BOTSWANA">BOTSWANA</option>

                            <option value="BOUVET ISLAND">BOUVET ISLAND</option>

                            <option value="BRAZIL">BRAZIL</option>

                            <option value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>

                            <option value="BULGARIA">BULGARIA</option>

                            <option value="BURKINA FASO">BURKINA FASO</option>

                            <option value="BURUNDI">BURUNDI</option>

                            <option value="CAMBODIA">CAMBODIA</option>

                            <option value="CAMEROON">CAMEROON</option>

                            <option value="CANADA">CANADA</option>

                            <option value="CAPE VERDE">CAPE VERDE</option>

                            <option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>

                            <option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>

                            <option value="CHAD">CHAD</option>

                            <option value="CHILE">CHILE</option>

                            <option value="CHINA">CHINA</option>

                            <option value="COLOMBIA">COLOMBIA</option>

                            <option value="COMOROS">COMOROS</option>

                            <option value="CONGO">CONGO</option>

                            <option value="COOK ISLANDS">COOK ISLANDS</option>

                            <option value="COSTA RICA">COSTA RICA</option>

                            <option value="COTE D'IVOIRE">COTE D'IVOIRE</option>

                            <option value="CROATIA">CROATIA</option>

                            <option value="CUBA">CUBA</option>

                            <option value="CYPRUS">CYPRUS</option>

                            <option value="CZECH REPUBLIC">CZECH REPUBLIC</option>

                            <option value="DENMARK">DENMARK</option>

                            <option value="DJIBOUTI">DJIBOUTI</option>

                            <option value="DOMINICA">DOMINICA</option>

                            <option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>

                            <option value="ECUADOR">ECUADOR</option>

                            <option value="EGYPT">EGYPT</option>

                            <option value="EL SALVADOR">EL SALVADOR</option>

                            <option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>

                            <option value="ERITREA">ERITREA</option>

                            <option value="ESTONIA">ESTONIA</option>

                            <option value="ETHIOPIA">ETHIOPIA</option>

                            <option value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)</option>

                            <option value="FAROE ISLANDS">FAROE ISLANDS</option>

                            <option value="FIJI">FIJI</option>

                            <option value="FINLAND">FINLAND</option>

                            <option value="FRANCE">FRANCE</option>

                            <option value="FRENCH GUIANA">FRENCH GUIANA</option>

                            <option value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>

                            <option value="FRENCH SOUTHERN TERRITORIES">FRENCH SOUTHERN TERRITORIES</option>

                            <option value="GABON">GABON</option>

                            <option value="GAMBIA">GAMBIA</option>

                            <option value="GEORGIA">GEORGIA</option>

                            <option value="GERMANY">GERMANY</option>

                            <option value="GHANA">GHANA</option>

                            <option value="GIBRALTAR">GIBRALTAR</option>

                            <option value="GREECE">GREECE</option>

                            <option value="GREENLAND">GREENLAND</option>

                            <option value="GRENADA">GRENADA</option>

                            <option value="GUADELOUPE">GUADELOUPE</option>

                            <option value="GUAM">GUAM</option>

                            <option value="GUATEMALA">GUATEMALA</option>

                            <option value="GUINEA">GUINEA</option>

                            <option value="GUINEA-BISSAU">GUINEA-BISSAU</option>

                            <option value="GUYANA">GUYANA</option>

                            <option value="HAITI">HAITI</option>

                            <option value="HEARD ISLAND AND MCDONALD ISLANDS">HEARD ISLAND AND MCDONALD ISLANDS</option>

                            <option value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)</option>

                            <option value="HONDURAS">HONDURAS</option>

                            <option value="HONG KONG">HONG KONG</option>

                            <option value="HUNGARY">HUNGARY</option>

                            <option value="ICELAND">ICELAND</option>

                            <option value="INDIA">INDIA</option>

                            <option value="INDONESIA">INDONESIA</option>

                            <option value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>

                            <option value="IRAQ">IRAQ</option>

                            <option value="IRELAND">IRELAND</option>

                            <option value="ISRAEL">ISRAEL</option>

                            <option value="ITALY">ITALY</option>

                            <option value="JAMAICA">JAMAICA</option>

                            <option value="JAPAN">JAPAN</option>

                            <option value="JORDAN">JORDAN</option>

                            <option value="KAZAKHSTAN">KAZAKHSTAN</option>

                            <option value="KENYA">KENYA</option>

                            <option value="KIRIBATI">KIRIBATI</option>

                            <option value="North KOREA">North KOREA</option>

                            <option value="South KOREA">South KOREA</option>

                            <option value="KUWAIT">KUWAIT</option>

                            <option value="KYRGYZSTAN">KYRGYZSTAN</option>

                            <option value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>

                            <option value="LATVIA">LATVIA</option>

                            <option value="LEBANON">LEBANON</option>

                            <option value="LESOTHO">LESOTHO</option>

                            <option value="LIBERIA">LIBERIA</option>

                            <option value="LIBYAN ARAB JAMAHIRIYA">LIBYAN ARAB JAMAHIRIYA</option>

                            <option value="LIECHTENSTEIN">LIECHTENSTEIN</option>

                            <option value="LITHUANIA">LITHUANIA</option>

                            <option value="LUXEMBOURG">LUXEMBOURG</option>

                            <option value="MACAO">MACAO</option>

                            <option value="MACEDONIA">MACEDONIA</option>

                            <option value="MADAGASCAR">MADAGASCAR</option>

                            <option value="MALAWI">MALAWI</option>

                            <option value="MALAYSIA">MALAYSIA</option>

                            <option value="MALDIVES">MALDIVES</option>

                            <option value="MALI">MALI</option>

                            <option value="MALTA">MALTA</option>

                            <option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>

                            <option value="MARTINIQUE">MARTINIQUE</option>

                            <option value="MAURITANIA">MAURITANIA</option>

                            <option value="MAURITIUS">MAURITIUS</option>

                            <option value="MAYOTTE">MAYOTTE</option>

                            <option value="MEXICO">MEXICO</option>

                            <option value="MICRONESIA">MICRONESIA</option>

                            <option value="MOLDOVA">MOLDOVA</option>

                            <option value="MONACO">MONACO</option>

                            <option value="MONGOLIA">MONGOLIA</option>

                            <option value="MONTSERRAT">MONTSERRAT</option>

                            <option value="MOROCCO">MOROCCO</option>

                            <option value="MOZAMBIQUE">MOZAMBIQUE</option>

                            <option value="MYANMAR">MYANMAR</option>

                            <option value="NAMIBIA">NAMIBIA</option>

                            <option value="NAURU">NAURU</option>

                            <option value="NEPAL">NEPAL</option>

                            <option value="NETHERLANDS">NETHERLANDS</option>

                            <option value="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>

                            <option value="NEW CALEDONIA">NEW CALEDONIA</option>

                            <option value="NEW ZEALAND">NEW ZEALAND</option>

                            <option value="NICARAGUA">NICARAGUA</option>

                            <option value="NIGER">NIGER</option>

                            <option value="NIGERIA">NIGERIA</option>

                            <option value="NIUE">NIUE</option>

                            <option value="NORWAY">NORWAY</option>

                            <option value="OMAN">OMAN</option>

                            <option value="PAKISTAN">PAKISTAN</option>

                            <option value="PALAU">PALAU</option>

                            <option value="PALESTINE">PALESTINE</option>

                            <option value="PANAMA">PANAMA</option>

                            <option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>

                            <option value="PARAGUAY">PARAGUAY</option>

                            <option value="PERU">PERU</option>

                            <option value="PHILIPPINES">PHILIPPINES</option>

                            <option value="PITCAIRN">PITCAIRN</option>

                            <option value="POLAND">POLAND</option>

                            <option value="PORTUGAL">PORTUGAL</option>

                            <option value="PUERTO RICO">PUERTO RICO</option>

                            <option value="QATAR">QATAR</option>

                            <option value="ROMANIA">ROMANIA</option>

                            <option value="RUSSIA">RUSSIA</option>

                            <option value="RWANDA">RWANDA</option>

                            <option value="SAMOA">SAMOA</option>

                            <option value="SAN MARINO">SAN MARINO</option>

                            <option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>

                            <option value="SAUDI ARABIA">SAUDI ARABIA</option>

                            <option value="SENEGAL">SENEGAL</option>

                            <option value="SERBIA AND MONTENEGRO">SERBIA AND MONTENEGRO</option>

                            <option value="SEYCHELLES">SEYCHELLES</option>

                            <option value="SIERRA LEONE">SIERRA LEONE</option>

                            <option value="SINGAPORE">SINGAPORE</option>

                            <option value="SLOVAKIA">SLOVAKIA</option>

                            <option value="SLOVENIA">SLOVENIA</option>

                            <option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>

                            <option value="SOMALIA">SOMALIA</option>

                            <option value="SOUTH AFRICA">SOUTH AFRICA</option>

                            <option value="SOUTH GEORGIA">SOUTH GEORGIA</option>

                            <option value="SPAIN">SPAIN</option>

                            <option value="SRI LANKA">SRI LANKA</option>

                            <option value="SUDAN">SUDAN</option>

                            <option value="SWAZILAND">SWAZILAND</option>

                            <option value="SWEDEN">SWEDEN</option>

                            <option value="SWITZERLAND">SWITZERLAND</option>

                            <option value="SYRIA">SYRIA</option>

                            <option value="TAJIKISTAN">TAJIKISTAN</option>

                            <option value="TANZANIA">TANZANIA</option>

                            <option value="THAILAND">THAILAND</option>

                            <option value="TOGO">TOGO</option>

                            <option value="TONGA">TONGA</option>

                            <option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>

                            <option value="TUNISIA">TUNISIA</option>

                            <option value="TURKEY">TURKEY</option>

                            <option value="TURKMENISTAN">TURKMENISTAN</option>

                            <option value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>

                            <option value="TUVALU">TUVALU</option>

                            <option value="UGANDA">UGANDA</option>

                            <option value="UKRAINE">UKRAINE</option>

                            <option value="UNITED ARAB EMIRATES" selected="selected">UNITED ARAB EMIRATES</option>

                            <option value="UNITED KINGDOM">UNITED KINGDOM</option>

                            <option value="UNITED STATES">UNITED STATES</option>

                            <option value="URUGUAY">URUGUAY</option>

                            <option value="UZBEKISTAN">UZBEKISTAN</option>

                            <option value="VANUATU">VANUATU</option>

                            <option value="VENEZUELA">VENEZUELA</option>

                            <option value="VIETNAM">VIETNAM</option>

                            <option value="YEMEN">YEMEN</option>

                            <option value="ZAMBIA">ZAMBIA</option>

                            <option value="ZIMBABWE">ZIMBABWE</option>
                          </select>                        </td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue">Payment Option: </td>

                        <td width="288" align="left" valign="top" class="eventText"><p>

                            <label>

                            Credit Card</label>

                            (Soon will be activated)<br />

                            <label>

                            <input name="paytype" type="radio" checked='checked' class="formField" value="spot" onclick="getTotal()" />

                            Payment on delivery </label>

                          </p></td>
                      </tr>

                      <tr>

                        <td align="left" valign="middle" class="eventVenueWhite">&nbsp;</td>

                        <td align="left" valign="top" class="eventTextWhite"><label>

                          <input name="checkbox" type="checkbox" class="eventText" value="termsagree" />

                          I declare having read and agreed on all the terms and conditions of Ticket Master </label></td>
                      </tr>

                      <tr>

                        <td width="185" align="left" valign="middle" class="eventVenue"><input name="eid" type="hidden" id="eid" value="<?php echo $colname_eventRS; ?>" /></td>

                        <td width="288" align="left" valign="top" class="eventText">
<input name="SubButL" type="submit" id="SubButL" value="Pay Now!" style="background: none repeat scroll 0 0 #B13C4F; border: medium none;
    border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;" /></td>
                      </tr>
                    </table>

                    <input type="hidden" name="MM_insert" value="form1">

                </form></td>
              </tr>

            </table>

</div>


<?php

mysql_free_result($eventRs);

?>
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

<?php

mysql_free_result($shiplist);

?>


