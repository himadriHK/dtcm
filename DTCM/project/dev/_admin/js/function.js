// JavaScript Document
function checkAllFields(ref)
{
var chkAll = document.getElementById('checkAll');
var checks = document.getElementsByName('delAnn[]');
var boxLength = checks.length;
var allChecked = false;
var totalChecked = 0;
	if ( ref == 1 )
	{
		if ( chkAll.checked == true )
		{
			for ( i=0; i < boxLength; i++ )
				if (checks[i].disabled == true){
					checks[i].checked = false;	
				}
				else {
					checks[i].checked = true;
				}
		}
		else
		{
			for ( i=0; i < boxLength; i++ )
			checks[i].checked = false;
		}
	}
	else
	{
		for ( i=0; i < boxLength; i++ )
		{
			if ( checks[i].checked == true )
			{
			allChecked = true;
			continue;
			}
			else
			{
			allChecked = false;
			break;
			}
		}
		if ( allChecked == true )
		chkAll.checked = true;
		else
		chkAll.checked = false;
	}
	for ( j=0; j < boxLength; j++ )
	{
		if ( checks[j].checked == true )
		totalChecked++;
	}
}


function getGuideSubCat(value) {
		
	var dataString = 'action=getGuideSubCat&id=' + value;
	  
	$.ajax({
	type: "POST",
	url: "guides.php",
	data: dataString,
	beforeSend: function() {
	  $("#subCatContainer").html("<img src='images/ajax-loader-bar(3).gif' alt='Please wait...'>");
	  },
	success: function(response) {
	  
	  if(response != "") {
	  	$("#subCatContainer").html(response);
	  } else {
		  $("#subCatContainer").html("Select Main Category First!");
	  }
		  
	}//success function ends
	});

}


function getcountryCity(value) {
		
	var dataString = 'action=getCountryCities&id=' + value;
	  
	$.ajax({
	type: "POST",
	url: "events.php",
	data: dataString,
	beforeSend: function() {
	  $("#countryCityContainer").html("<img src='images/ajax-loader-bar(3).gif' alt='Please wait...'>");
	  },
	success: function(response) {
	  
	  if(response != "") {
	  	$("#countryCityContainer").html(response);
	  } else {
		  $("#countryCityContainer").html("Select Country First!");
	  }
		  
	}//success function ends
	});

}