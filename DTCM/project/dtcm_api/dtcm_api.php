<?php include('httpful.phar');
require_once('/Connections/eventscon.php'); 

//$mapp=array('dtcm_access_token'=>'a','dtcm_access_token_expires'=>0);
//$GLOBALS['map']=$mapp;

//var_dump($mapp);

//print_r($database->info());

function wp_remote_post($url,$args)
{
	$headers=$args['headers'];
	$body=$args['body'];
	$response = \Httpful\Request::post($url)
    ->body($body)
	->addHeaders($headers)->useProxy('PITC-Zscaler-ASPAC-Bangalore3PR.proxy.corporate.ge.com')
    ->send();
	//var_dump($response);
	$tmp['body']='';
	if(!$response->hasErrors())
	{
	$tmp=$response->raw_body;	
	return $tmp;
	}
    else
		return false;
}

function wp_remote_get($url,$args)
{
	$headers=$args['headers'];
	$body='';
	if(isset($args['body']))
	$body=$args['body'];
	$response = \Httpful\Request::get($url)
    ->body($body)
	->addHeaders($headers)->useProxy('PITC-Zscaler-ASPAC-Bangalore3PR.proxy.corporate.ge.com')
    ->send();
	//var_dump($response);
	$tmp['body']='';
	if(!$response->hasErrors())
	{
	$tmp['body']=$response->raw_body;	
	return $tmp;
	}
    else
		return false;
}

function get_option($optn)
{
	global $database;
	$data = $database->select('dtcm_token_tmp', ['dtcm_access_token','dtcm_access_token_expires']);
	//var_dump($data);
	//var_dump($data[0][$optn]);
	if($data)
		return $data[0][$optn];
	else
		return false;
}

function update_option($optn,$val)
{
	//if(array_key_exists($optn,$GLOBALS['map']))
	//{
		global $database;
		$arr[$optn]=$val;
		$database->update('dtcm_token_tmp',$arr);
		//$GLOBALS['map'][$optn]=$val;
		//var_dump($GLOBALS['map']);
		return true;
	//}
	//else
		//false;
}
?>