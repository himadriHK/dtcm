<?php
require_once('Connections/eventscon.php');
mysql_select_db($database_eventscon, $eventscon);
// include ImageManipulator class
require_once('ImageManipulator.php');
if($_GET['type']=='catadd')
{ 
	if ($_FILES['fileToUpload']['error'] > 0) {
		header('location:admin/add_event_category.php');
	} else {
		// array of valid extensions
		$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
		// get extension of the uploaded file
		$fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
		// check if file Extension is on the list of allowed ones
		if (in_array($fileExtension, $validExtensions)) {
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
			// resizing to 200x200
			$newImage = $manipulator->resample(30, 30);
			// saving file to uploads folder
			$image_name=$newNamePrefix . $_FILES['fileToUpload']['name'];
			$manipulator->save('upload/category/' . $image_name);
			##Category add start from here
			if(!empty($_POST))
			{
				$name=$_POST['name'];
				$ename=$_POST['ename'];
				$desc=$_POST['desc'];
				$sql="INSERT INTO category (`name`,`ename`,`desc`,`image`) VALUES ('$name','$ename','$desc','$image_name')";
				mysql_query($sql,$eventscon);
			}
			##Category end here
		}
	}
}
if($_GET['type']=='catedit')
{ $id=$_GET['id'];
  if($_FILES)
  {
	if ($_FILES['fileToUpload']['error'] > 0) {
		header('location:admin/add_event_category.php');
	} else {
		// array of valid extensions
		$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
		// get extension of the uploaded file
		$fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
		// check if file Extension is on the list of allowed ones
		if (in_array($fileExtension, $validExtensions)) {
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
			// resizing to 200x200
			$newImage = $manipulator->resample(30, 30);
			// saving file to uploads folder
			$image_name=$newNamePrefix . $_FILES['fileToUpload']['name'];
			$manipulator->save('upload/category/' . $image_name);
		}
	}
  }
	if(!empty($_POST))
	{
		$name=$_POST['name'];
		$ename=$_POST['ename'];
		$desc=$_POST['desc'];
		if($image_name)
		$image=",`image`='$image_name'";
		$sql="UPDATE category  set `name`='$name',`ename`='$ename',`desc`='$desc' $image where id='$id'";
		mysql_query($sql,$eventscon);
	}
}
header('location:admin/view_event_category.php');