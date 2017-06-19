var validCode=false;
function validateDTCMcode(code)
{

//console.log(nano.ajax.post('../dtcm_api/api_test.php', {dtcm_command: 'perfprice',dtcm_arg:code}, 
//function() { 
////console.log(this.response.text.trim()=='' ||this.response.text==null);
//if (this.response.text.trim()=='' ||this.response.text==null)
//validCode=false;
//else
//validCode=true;	
//}));

var req = new nano.ajax.request('../dtcm_api/api_test.php', 'post', false,{dtcm_command: 'perfprice',dtcm_arg:code});
 var rsp = new nano.ajax.response(
      req,
      function() {
		  //console.log(this.response.text.trim());
		  //nano('result').set(this.response.text);
      }
  );
  //console.log(req);
  //console.log(rsp.request.responseText.trim());
 if (rsp.request.responseText.trim()=='')
	 return false;
 else
	 return true;
//return validCode;
}
