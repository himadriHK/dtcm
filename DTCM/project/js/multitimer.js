var currentServertime;
var tot;
/*
Count down until any date script-
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free scripts here!
Modified by Robert M. Kuhnhenn, D.O. 
on 5/30/2006 to count down to a specific date AND time,
on 10/20/2007 to a new format, and 1/10/2010 to include
time zone offset.
*/

var tz=-5        //-->Offset for your timezone in hours from UTC (see http://wwp.greenwichmeantime.com/index.htm to find the timezone offset for your location)
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function aaaaa()
{
//alert(site_url);
	$.get(site_url + "getCurrentTime.php",'',function(data23){
		// alert("data23="+data23);
		currentServertime = Date.parse(data23);
	});
}

//var ti = setInterval("aaaaa()", 1000);




//    DO NOT CHANGE THE CODE BELOW!
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function countdown(yr,m,d,hr,mi,secs,id){

//	alert(currentServertime);
	theyear=yr;
	themonth=m;
	theday=d;
	thehour=hr;
	theminute=mi;
	theid=id;
	var tot_time = "";

    var today = new Date()
    var todayy = today.getYear()
    if (todayy < 1000) {todayy+=1900}
    var todaym = today.getMonth()
    var todayd = today.getDate()
    var todayh = today.getHours()
    var todaymin = today.getMinutes()
    var todaysec = today.getSeconds()
    var todaystring1 = montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec
    var todaystring = Date.parse(todaystring1)+(tz/60)
    var futurestring1 = (montharray[m-1]+" "+d+", "+yr+" "+hr+":"+mi+":"+secs);
    var futurestring = Date.parse(futurestring1)-(today.getTimezoneOffset()/60);
    var dd = futurestring-todaystring;

    var dday=Math.floor(dd/(60*60*1000*24)*1)
    var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1)
    var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1)
    var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1)

	
    if(dday<=0 && dhour<=0 && dmin<=0 && dsec<=0){
		//alert("end"+ theid);
		//document.getElementById('tot_'+theid).innerHTML = "<font color=\'#F00\'>Ended</font>";
		$('#tot_'+theid).html('<td><div align="center" >00</div></td>    <td><div align="center" >00</div></td>    <td><div align="center" >00</div></td>    <td><div align="center" >00</div></td>');
		
        return;
    }  else if(dday <= 0 && dhour==0 && dmin==0 && dsec<=59){ 

		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;
		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
	

		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    } else if(dday <= 0 && dhour > 0 && dmin > 0 && dsec > 0){ 
		
		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;

		
		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
		
		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    } 
	else if(dday <= 0 && dhour <= 0 && dmin > 0 && dsec > 0){ 

		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin;
		if(dsec < 10)
			dsec="0"+dsec;

		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';

		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      	var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
    }
	else if(dday <= 0 && dhour > 0 && dmin <= 0 && dsec > 0){ 

		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;

		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';

		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    }
	else if(dday <= 0 && dhour > 0 && dmin <= 0 && dsec <= 0){ 
		
		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;
		
		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
		
		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    } 
	
	else if(dday <= 0 && dhour > 0 && dmin > 0 && dsec <= 0){ 
		
		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;

		
		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
		
		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    } 
	
	else if(dday==0 && dhour==0 && dmin==0 && dsec<=59){ 
		
		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec;

		
		tot='<td><div align="center" >00</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
		
		//document.getElementById('tot_'+theid).innerHTML = tot;
		$('#tot_'+theid).html(tot);

      var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
		
    } else {
		
		
		if(dday < 10)
			dday="0"+dday; 
		if(dhour < 10)
			dhour="0"+dhour;
		if(dmin < 10)
			dmin="0"+dmin; 
		if(dsec < 10)
			dsec="0"+dsec; 
		tot='<td><div align="center" >'+dday+'</div></td>    <td><div align="center" >'+dhour+'</div></td>    <td><div align="center" >'+dmin+'</div></td>    <td><div align="center" >'+dsec+'</div></td>';
		
		
		$('#tot_'+theid).html(tot);
		var timeOutTime = setTimeout("countdown('"+theyear+"','"+themonth+"','"+theday+"','"+thehour+"','"+theminute+"','"+secs+"','"+theid+"')",1000);
    }
}


function callMeFirst(yr,m,d,hr,mins,secs,id)
{
	countdown(yr,m,d,hr,mins,secs,id);	
}