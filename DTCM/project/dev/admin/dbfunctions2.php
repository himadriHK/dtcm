<?

include_once("messages.php");

$admin_email ="nasser@ticketmastersme.com";

$site_address = "http://www.ticketmastersme.com";


function addPartner($name,$image,$url)	{

		

		$sql="INSERT INTO tblpartners(name,image, url) VALUES ('$name','$image','$url')";

		$rs = mysql_query($sql) or die ("error in add PArtner query");

	}

	

function getPartner($partnerid)

{

$sql = "select * from tblpartners where partnerid = ".$partnerid;

$rs = mysql_query($sql) or die("Error in Partner selection");

if(!$rs)

return 0;

else

{

return(mysql_fetch_object($rs));

}

}

function setPartner($partnerid,$name,$image,$url)

{       $row = getPartner($partnerid);

		$sql = "UPDATE tblpartners SET name ='$name', url ='$url' where partnerid = '$partnerid'";

	

		mysql_query($sql) or die("Error in update query");

		if($image){

       		@unlink("../".$row->image);

			$sql = "UPDATE tblpartners SET  image ='$image' where partnerid = '$partnerid'";

			mysql_query($sql) or die("Error in update query");

		}

	    

	?>

 <Script language="JavaScript">

   alert("Partners Updated Successfully");

  </Script>

<? 

	

}

function deletePartner($partnerid)

{

       $row = getPartner($partnerid);

	    if($row->image)

			@unlink("../".$row->image);

		

		$sql = "delete from tblpartners where partnerid = ".$partnerid;

		mysql_query($sql) or die("Error in delete query");

		?>

		<Script language="JavaScript">

		   alert("Partner Deleted Successfully");

		  </Script>

		<? 

}

 

?>