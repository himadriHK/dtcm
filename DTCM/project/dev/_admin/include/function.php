<?php
function sqlSafe($sql) {
	global $conn;
	if(get_magic_quotes_gpc())$sql=stripslashes(trim($sql));
	return @mysqli_real_escape_string($conn,trim($sql));
}

function upperCaseWords($str) {
	return ucwords(strtolower($str));
}
	
function hasAccess($section){
	if(isset($_SESSION['role']) && !empty($_SESSION['role']) && ($_SESSION['role'][$section] == 1))
		return true;
	else
		return false;	
}

//************  Add Function for Admin *********************
function addItem($table, $data=array()) {
		global $conn;
		
		$sql = "INSERT INTO $table SET";
		
		foreach($data as $name=>$value){
			$sql .= ($value!="")?" $name='$value',":"";
		}

		$sql = substr($sql, 0, -1);

		$db_result = mysqli_query($conn, $sql); //echo mysql_error();
	
		if($db_result) {
?>
		<div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <i class="icon-ok-sign"></i><strong>Success!</strong> Record has been Added Successfully.
        </div>
<?php					
		}//end of if
		else {
?>
	  	<div class="alert">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> Due to some error no action has been performed.
        </div>
<?php
		}
		return $return_id=mysqli_insert_id($conn);
		
}

//*********************** End of Add  Function****************************

//*********************** EDIT  Function for Admin************************
function editItem($table, $data=array(), $idVal, $idCol="id") { 	
		global $conn;
		
		$sql = "update $table SET";

		foreach($data as $name=>$value){
			$sql .= " $name='$value',";
		}
		
		$sql = substr($sql, 0, -1);
		
		$sql .= " WHERE $idCol='".sqlSafe($idVal)."'";
		
		$db_result = mysqli_query($conn, $sql);
					
		if($db_result) {
?>
	  	<div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <i class="icon-ok-sign"></i><strong>Success!</strong> Record has been Updated Successfully.
        </div>
<?php						
		}//end of if
		else {	
?>
	  	<div class="alert">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> Due to some error no action has been performed.
        </div>
<?php
		}
		
}

//*********************** End of Function*********************

//ActionSelected Function*************************************
function actionSelected($delAnn, $tableName, $idCol="id"){
	global $conn;
    if (isset($_REQUEST['select_task']) && $_REQUEST['select_task']!="0" && $_REQUEST['select_task']!=""){
		$counter = 0;
		$action_check="";
			$product_count = isset($_REQUEST['delAnn'])?count($_REQUEST['delAnn']):'0';							 
			$data_lang['product_id'] = isset($_REQUEST['delAnn'])?$_REQUEST['delAnn']:array();
			if($product_count > '0'){
		  	for($i=0;$i<$product_count;$i++){
				$product_id = $data_lang['product_id'][$i];
				if ($_REQUEST['select_task']==1){
					mysqli_query($conn, "delete from $tableName where $idCol='$product_id'");
					$counter = (mysqli_affected_rows($conn)) + $counter;
					$action_check = "Deleted";
				}
				else if ($_REQUEST['select_task']==2){
					mysqli_query($conn, "UPDATE $tableName SET status='active' where $idCol='$product_id'");
					$counter = (mysqli_affected_rows($conn)) + $counter;
					$action_check = "Activated";
				}
				else if ($_REQUEST['select_task']==3){
					mysqli_query($conn, "UPDATE $tableName SET status='inactive' where $idCol='$product_id'");
					$counter = (mysqli_affected_rows($conn)) + $counter;
					$action_check = "In-activated";
				}
				else if ($_REQUEST['select_task']==4){
					mysqli_query($conn, "UPDATE $tableName SET status='expire' where $idCol='$product_id'");
					$counter = (mysqli_affected_rows($conn)) + $counter;
					$action_check = "Expired";
				}
		  	} //end of for
		  	if ($counter==0) {
	?>
    			<div class="alert">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <i class="icon-exclamation-sign"></i><strong>Warning!</strong> Due to some error no action has been performed.
                </div>
	<?php
	      	} //end of if
		  	else {	
	?>
    			<div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <i class="icon-ok-sign"></i><strong>Success!</strong> <?php echo $counter." Record(s) has been ".$action_check." Successfully."?>
                </div>
	<?php
	      	} //end of else
	    } //end of if
		else {
	?>
        <div class="alert alert-info">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> No Record has been Selected
        </div>
		
	<?php
	  } //end of else
	} // end of if
  } //end of function

//****  End of ActionSelected Function ***********************

//*********************** Delete  Function *******************
function deleteListItem($id, $tableName, $idCol="id") {
		global $conn;
		
		$sql = mysqli_query($conn, "delete from $tableName where $idCol='$id'");
		$rows = mysqli_affected_rows($conn);
		if ($rows == 0) {
?>
		  	<div class="alert">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <i class="icon-exclamation-sign"></i><strong>Warning!</strong> Due to some error no action has been performed.
            </div>
<?php
		}
		else {	
?>
			<div class="alert alert-success">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <i class="icon-ok-sign"></i><strong>Success!</strong> <?php echo $rows." Record(s) has been Deleted Successfully."?>
            </div>
<?php
	    }
	  } /* Enf of function*/
	
//****  End of Delete Function  **************************

//FUNCTION TO COUNT TOTAL MEMBERS************************//
function countTotalLiveProducts($filter="")
	{
	global $conn;
	
	if($filter == "active")
		{
		$qry_str = " AND active = 'true' ";	
		}
	elseif($filter == "inactive")
		{
		$qry_str = " AND active = 'false' ";
		}
	elseif ($filter == "deleted")
		{
		$qry_str = " AND deleted = 'true' ";
		}
	else
		{
		$qry_str = "";
		}	
	
	$qry = "SELECT COUNT(*) FROM product_data 
			WHERE 1
			".$qry_str;
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);
	}
//******************************************************//

//FUNCTION TO COUNT TOTAL ADMIN USERS*******************//
function countAdminUsers() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM event_admin 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL PROMOTERS*********************//
function countPromoters() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM promoters 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL OUTLETS***********************//
function countOutlets() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM outlets 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL GUIDES************************//
function countGuides() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM guide 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL EVENTS************************//
function countEvents() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM events 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL NEWS**************************//
function countNews() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM tblnews 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL GALLERY PHOTOS****************//
function countGalleryPhotos() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM tblphoto 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL NEWS**************************//
function countPartners() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM tblpartners 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL NEWSLETTERS*******************//
function countNewsletter() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM ticketma_ticketdbff_messages 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL NEWSLETTER EMAILS*************//
function countNewsletterEmails() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM ticketma_ticketdbff_emails_table 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL VENUES************************//
function countVenues() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM tblvenue 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL CITIES************************//
function countCities() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM cities 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL SUBSCRIBERS*******************//
function countSubscribers() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM subscribes 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL TICKET ORDERS*****************//
function countTicketOrders() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM ticket_orders 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL COUNTRY RATES*****************//
function countCountryRates() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM shippingrates 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//FUNCTION TO COUNT TOTAL CAROUSEL IMAGES***************//
function countCarouselImages() {
	global $conn;
	
	$qry = "SELECT COUNT(*) FROM scroller 
			WHERE 1
			";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_array($res);
	$total_records = $row[0];
	return number_format($total_records);	
}
//******************************************************//

//****FUNCTION TO RESIZE USER IAMGES********************//
function resizeImg($img, $w, $h, $force="proportion") {

		// The file

		$filename = $img;

		// Set a maximum height and width

		$width = $w;

		$height = $h;

		// Get new dimensions

		list($width_orig, $height_orig) = getimagesize($filename);
		
		$size = getimagesize($filename);
		$filetype = $size['mime'];
		
		if ($width_orig > $width || $height_orig > $height)

		{

			if ($force=="fix")

			{

				$width = $w;

				$height = $h;

			}

			else if ($force=="proportion")

			{

				if ($width_orig > $height_orig){	// if width is bigger	/

					$height = ($width / $width_orig) * $height_orig;

				}else if ($width_orig < $height_orig){	// if height is bigger	/

					$width = ($height / $height_orig) * $width_orig;

				}

			}

			else if ($force=="width")

			{

				if ($width_orig > $w){	// if width is bigger	/

					$width = $w;

					$height = ($width / $width_orig) * $height_orig;

				}else{

					$width = $width_orig;

					$height = $height_orig;

				}

			}

			else if ($force=="height")

			{

				if ($height_orig > $h){	// if width is bigger	/

					$height = $h;

					$width = ($height / $height_orig) * $width_orig;

				}else{

					$width = $width_orig;

					$height = $height_orig;

				}

			}

			

			// Resample
			$image_p = imagecreatetruecolor($width, $height);
						
			if($filetype == "image/png")
				{
				$image = @imagecreatefrompng($filename); 		
				}
			elseif($filetype == "image/gif")
				{
				$image = @imagecreatefromgif($filename);		
				}	
			else{
				$image = @imagecreatefromjpeg($filename);
				
				}

			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

			imagejpeg($image_p, $img, 80);  //Saving The Image.



		}		
		//Apply Watermark
		/*if($w > 300){
			$watermark = '/home/fruzeo/public_html/images/watermark.png';
			$image = imagecreatefromjpeg($img);
			$img_width=imagesx($image);
			$img_height=imagesy($image);

			// read the watermark image
			$watermark=imagecreatefrompng($watermark);  
			$watermark_width=imagesx($watermark);  
			$watermark_height=imagesy($watermark);  
			$image2=imagecreatetruecolor($watermark_width, $watermark_height);  
			imagealphablending($image2, false);

			// place the watermark
			$dest_x=$img_width-$watermark_width-5;
			$dest_y=$img_height-$watermark_height-5;
			imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
			imagesavealpha($image, true); 				
			imagejpeg($image, $img, 80);  //Saving The Image.
		}*/

}
//******************************************************//
?>