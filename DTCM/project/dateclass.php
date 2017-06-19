<?php

/* page:dateclass.php, version:1.0, last modified:16/09/2004, author:jayaraj */
/* the CDate encapsulates all the date function like adding dates getting the current date date diference etc..*/
class CDate
{

	 var $dd;
	 var $mm;
	 var $yy;
     var $result;
	 var $dbobj;
	 var $db_host = '';
	 var $db_user = '';
	 var $db_pass = '';
	 var $db_name = '';
	 var $num_rows = 0;
	 var $row = 0;
	 var $conobj;

	/*function CDate($dbhost, $dbuser, $dbpass, $dbname) //constructor function 
	{
		$this->dbobj = new db();

		$this->db_host = $dbhost;
		$this->db_user = $dbuser;
		$this->db_pass = $dbpass;
		$this->db_name = $dbname;

		 $dd=0;
		 $mm=0;
		 $yy=0;
	}*/
	
	function getDBConnection()
	{
	   $this->database = new Database();
	}	

   function getdateformat($year,$month,$day)
   {
	   $this->dd=$day;
   	   $this->mm=$month;
   	   $this->yy=$year;

	   if(checkdate($this->mm,$this->dd,$this->yy))
	   {
		  $formatdate = $this->yy."-".$this->mm."-".$this->dd;   //yyyy-mm-dd format
		  return $formatdate;
	   }
	   else
	   {
		  return FALSE;
	   }
	  
  }

  /* the function getdate_yyyy_mm_dd returns the current date in the year-month-day format*/
	function getdate_yyyy_mm_dd()
	{
		$currentdate =date("Y-m-d");
		return $currentdate;
	
	}
	
	/* the function getdate_yyyy_mm_dd returns the current date in the month-day-year format*/
	function getdate_mm_dd_yyyy()
	{
		$currentdate =date("m-d-Y");
		return $currentdate;
	}
	
	//function to get the date in the format mm/dd/yyyy when returning from database.
	function getdate_m_d_y($date)
	{
		list($year,$mon,$day)=split('[/.-]',$date);
		$formatteddate="$mon/$day/$year";
		return $formatteddate;
	}
	
	//function to get the date in the format mm-dd-yyyy when split by "-"
	function getdate_mo_da_year($date)
	{ 
		list($year,$mon,$day)=split('[/.-]',$date);
		$formatteddate="$mon/$day/$year";
		return $formatteddate;
	}
	//function to get the date in the format mm-dd-yyyy when split by "-"
	function getdate_da_mo_year($date)
	{ 
		list($year,$mon,$day)=split('[/.-]',$date);
		$formatteddate="$day/$mon/$year";
		return $formatteddate;
	}
	//function to get the date in the format $format when inserting into database.
	function getdbdate_y_m_d($date)
	{
		list($mon,$day,$year)=split('[/.-]',$date);
		$formatteddate="$year-$mon-$day";
		return $formatteddate;
	}
	function getunixtime()
	{
	   return time();
	}

	 function getcurrent_D()
	{
		$today = getdate(); 
		$currentm = $today['mday'];
		return $currentm;

	}
	//the function getcurrent_M get the current month in figure
    function getcurrent_M()
	{
		$today = getdate(); 
		$currentm = $today['mon'];
		return $currentm;

	}
	//the function getcurrent_Y get the current year
	function getcurrent_Y()
	{
		$today = getdate(); 
		$currenty = $today['year'];
		return $currenty;

	}

	//the function getcurrent_MON get the current month in words
	 function getcurrent_MON()
	{
		$today = getdate(); 
		$currentm = $today['month'];
		return $currentm;

	}
	
	//the function is used to return the date in the format Jan 01, 2005
	function newsdate($date)
	{
		list($year,$mon,$day)=split('[/.-]',$date);
		switch ($mon)
		{
			case 01:
				$month="Jan";
				break;
			case 1:
				$month="Jan";
				break;
			case 02:
				$month="Feb";
				break;
			case 2:
				$month="Feb";
				break;				
			case 03:
				$month="Mar";
				break;
			case 3:
				$month="Mar";
				break;
			case 04:
				$month="Apr";
				break;
			case 4:
				$month="Apr";
				break;				
			case 05:
				$month="May";
				break;
			case 5:
				$month="May";
				break;				
			case 06:
				$month="Jun";
				break;
			case 6:
				$month="Jun";
				break;				
			case 07:
				$month="Jul";
				break;
			case 7:
				$month="Jul";
				break;				
			case 08:
				$month="Aug";
				break;
			case 8:
				$month="Aug";
				break;
			case 09:
				$month="Sep";
				break;
			case 9:
				$month="Sep";
				break;				
			case 10:
				$month="Oct";
				break;
			case 11:
				$month="Nov";
				break;
			case 12:
				$month="Dec";
				break;		
		}
		$returndate=$month." ".$day.", ".$year;
		return $returndate;
	}


	function newsdate1($date)
	{
		list($year,$mon,$day)=split('[/.-]',$date);
		switch ($mon)
		{
			case 01:
				$month="Jan";
				break;
			case 1:
				$month="Jan";
				break;
			case 02:
				$month="Feb";
				break;
			case 2:
				$month="Feb";
				break;				
			case 03:
				$month="Mar";
				break;
			case 3:
				$month="Mar";
				break;
			case 04:
				$month="Apr";
				break;
			case 4:
				$month="Apr";
				break;				
			case 05:
				$month="May";
				break;
			case 5:
				$month="May";
				break;				
			case 06:
				$month="Jun";
				break;
			case 6:
				$month="Jun";
				break;				
			case 07:
				$month="Jul";
				break;
			case 7:
				$month="Jul";
				break;				
			case 08:
				$month="Aug";
				break;
			case 8:
				$month="Aug";
				break;
			case 09:
				$month="Sep";
				break;
			case 9:
				$month="Sep";
				break;				
			case 10:
				$month="Oct";
				break;
			case 11:
				$month="Nov";
				break;
			case 12:
				$month="Dec";
				break;		
		}
		if($day<=9)
			$day = $day[1];
			

		
		$returndate=$month." ".$day.", ".$year;
		return $returndate;
	}
	

function newsdate2($num)
	{
		
		switch ($num)
		{
			case 01:
				$month="January";
				break;
			case 1:
				$month="January";
				break;
			case 02:
				$month="February";
				break;
			case 2:
				$month="February";
				break;				
			case 03:
				$month="March";
				break;
			case 3:
				$month="March";
				break;
			case 04:
				$month="April";
				break;
			case 4:
				$month="April";
				break;
			case 05:
				$month="May";
				break;
			case 5:
				$month="May";
				break;				
			case 06:
				$month="June";
				break;
			case 6:
				$month="June";
				break;				
			case 07:
				$month="July";
				break;
			case 7:
				$month="July";
				break;				
			case 08:
				$month="August";
				break;
			case 8:
				$month="August";
				break;
			case 09:
				$month="September";
				break;
			case 9:
				$month="September";
				break;				
			case 10:
				$month="October";
				break;
			case 11:
				$month="November";
				break;
			case 12:
				$month="December";
				break;		
		}
		
		
		
		return $month;
	}



	/* the function uses sql date function date_add  _
	//to add a value to a date and return the result _
	//the imp available formats are DAY, WEEKS, MONTHS, QUARTERS,YEAR*/
	function date_add($startdate,$value,$format)
	{
		
		$this->getDBConnection();
		 $dd=0;
		 $mm=0;
		 $yy=0;
		$sql="SELECT DATE_ADD('".$startdate."',INTERVAL ".$value." ".$format.")";
		
//		echo "sql	:	".$sql."<br>"; 
		
		$this->result=$this->database->query($sql);
		if(mysql_num_rows($this->result)>0)
		{
			$this->row = mysql_fetch_object($this->result);
			$finaldate=$this->row[0];
			$this->dbobj->db_close();
			return $finaldate;
		 } 
		 else
		 {
			 $this->dbobj->db_close();
			 return FALSE;
		 }
	}
	
	function date_sub($startdate,$value,$format)
	{
		$this->getDBConnection();
		$date=$this->getdate_yyyy_mm_dd();
		$this->dbobj->db_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$sql="SELECT DATE_SUB('".$startdate."',INTERVAL ".$value." ".$format.")";
		$this->result=$this->database->query($sql);
		if($this->dbobj->db_countRows($this->result)>0)
		{
			$this->row = $this->dbobj->db_fetchrows($this->result);
			$finaldate=$this->row[0];
			$this->dbobj->db_close();
			return $finaldate;
		 } 
		 else
		 {
			 $this->dbobj->db_close();
			 return FALSE;
		 }
	}
	
	// find the date difference in days
	function date_diff($date1,$date2)
	{
		$this->getDBConnection();
		$date=$this->getdate_yyyy_mm_dd();
		
		$sql="SELECT DATEDIFF('".$date1."','".$date2."') AS dateDif";
	//	echo $sql."<br>"; 
		$result =  $this->database->query($sql);
		$result = $this->database->result;
		
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_object($result);
			$finaldate=$row->dateDif;
			//$this->dbobj->db_close();
			return $finaldate;
		 } 
		 else
		 {
			 //$this->dbobj->db_close();
			 return FALSE;
		 }
	}
	
	function noOfDaysInAMonth($month,$year)
	{
		$num = cal_days_in_month(CAL_GREGORIAN, $month,$year); // 31
		return $num;
		/*
		if (eregi("z", $string)) {
			echo "'$string' contains a 'z' or 'Z'!";
		}*/
	}
	function dateDiffC($dformat, $endDate, $beginDate)
	{ //echo $endDate.'&nbsp;'.$beginDate;
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
	return $end_date - $start_date;
	}


	
		function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
	  /*
		$interval can be:
		yyyy - Number of full years
		q - Number of full quarters
		m - Number of full months
		y - Difference between day numbers
		  (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
		d - Number of full days
		w - Number of full weekdays
		ww - Number of full weeks
		h - Number of full hours
		n - Number of full minutes
		s - Number of full seconds (default)
	  */
	  
	  if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	  }
	  $difference = $dateto - $datefrom; // Difference in seconds
	//  echo $dateto .'-'. $datefrom;
	  switch($interval) {
	  
		case 'yyyy': // Number of full years
	
		  $years_difference = floor($difference / 31536000);
		  if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
			$years_difference--;
		  }
		  if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
			$years_difference++;
		  }
		  $datediff = $years_difference;
		  break;
	
		case "q": // Number of full quarters
	
		  $quarters_difference = floor($difference / 8035200);
		  while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			$months_difference++;
		  }
		  $quarters_difference--;
		  $datediff = $quarters_difference;
		  break;
	
		case "m": // Number of full months
	
		  $months_difference = floor($difference / 2678400);
		  
		  while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			$months_difference++;
		  }
		  $months_difference--;
		  $datediff = $months_difference;
		  break;
	
		case 'y': // Difference between day numbers
	
		  $datediff = date("z", $dateto) - date("z", $datefrom);
		  break;
	
		case "d": // Number of full days
	
		  $datediff = floor($difference / 86400);
		  break;
	
		case "w": // Number of full weekdays
	
		  $days_difference = floor($difference / 86400);
		  $weeks_difference = floor($days_difference / 7); // Complete weeks
		  $first_day = date("w", $datefrom);
		  $days_remainder = floor($days_difference % 7);
		  $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
		  if ($odd_days > 7) { // Sunday
			$days_remainder--;
		  }
		  if ($odd_days > 6) { // Saturday
			$days_remainder--;
		  }
		  $datediff = ($weeks_difference * 5) + $days_remainder;
		  break;
	
		case "ww": // Number of full weeks
	
		  $datediff = floor($difference / 604800);
		  break;
	
		case "h": // Number of full hours
	
		  $datediff = floor($difference / 3600);
		  break;
	
		case "n": // Number of full minutes
	
		  $datediff = floor($difference / 60);
		  break;
	
		default: // Number of full seconds (default)
	
		  $datediff = $difference;
		  break;
	  }    
	
	  return $datediff;
	
	}

}
?>