<?
flush();
set_time_limit(0);
$piccount=0;

/*
// if (!(extension_loaded("gd")))
// {echo "GD library not compiled or loaded into this server!<br>
// This script can not work without GD library!";
// die;
// }


// if (!(is_dir($_SERVER['DOCUMENT_ROOT']."/administer/data/")))
// {echo "Directory \"data\" not found!<br>
// Please create directory with name \"data\" and set 0777 permissions
//  (uploaded files goes here)";
// die;
// }
*/
//############################### MAIN function ####################################
function uploadimg($xpic, $thumb_image, $resize_image, $imgw, $imgh, $timgw, $timgh)
{
//echo "in the function";
//echo $_FILES[$xpic]['name'];

 //############### execute code only for selected/browsed files ################
// $xpic="thumb";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>""))
  {
//echo "  in the If   ";
  //########################## file type check #################################
/*
  $cert1 = "image/pjpeg"; //jpg
  $cert2 = "image/jpeg"; //jpg (for MAC)
  $xtype =$_FILES[$xpic]['type'];
//echo $xtype;
  if (($xtype <> $cert1) AND ($xtype <> $cert2))
  {$log.= "<b>#$i Not allowed file type ! ($xtype)</b><br>";}
  else
  {
*/
  //##################### copy jpg pic to server ###############################
  $dest="../data/".$_FILES[$xpic]['name'];
  //echo $dest;
  
  if (move_uploaded_file($_FILES[$xpic]["tmp_name"], $dest)){
  //echo "   file uploaded   ";
  $log.=""; $piccount+=1;}
  else
  { echo "   error in file upload   "; $log.="$dest upload error!($$xpic)<br>";}


  //######## make thumbnail from uploaded pic using GD2 lib functions ##########
  $scale_ratio=0.25;         //### Thumbnail scale ratio
  $quality=90;              //### Thumbnail quality

list($big_w, $big_h, $type, $attr) = getimagesize($dest);

	$x = $big_w;
	$y = $big_h;

  $dest_w=$x*$scale_ratio;
  $dest_h=$y*$scale_ratio;
  $src_w=$big_w;
  $src_h=$big_h;

//echo $big_w." : ".$big_h;

  $dest_jpgx="../data/".$_FILES[$xpic]['name'];
  
if ($resize_image == "Y"){

//*** set big image sizes ***//
if($x>$imgw){
	$xsize=($imgw*100)/$x;
	$ysize = ($xsize * $y)/100;
	$x = $imgw;
	$y = intval($ysize);
}

if($y>$imgh){
	$ysize=($imgh*100)/$y;
	$xsize = ($ysize * $x)/100;
	$y = $imgh;
	$x = intval($xsize);
}
//*** End set big image sizes ***//

  $in_jpg = imagecreatefromjpeg($dest_jpgx);
  $out_jpg = imagecreatetruecolor($x,$y);
  imagecopyresampled($out_jpg,$in_jpg,0,0,0,0,$x,$y,$src_w,$src_h);
  imagejpeg($out_jpg,$dest_jpgx,$quality); //### save this thumb to hard/server
  imagedestroy($in_jpg);
  imagedestroy($out_jpg);  
  }
  
  if($thumb_image == "Y"){
  
  $dest_jpgx="../data/".$_FILES[$xpic]['name'];
  
  list($big_w, $big_h, $type, $attr) = getimagesize($dest_jpgx);
	$x = $big_w;
	$y = $big_h;

//*** set thumb image sizes ***//
if($x>$timgw){
	$xsize=($timgw*100)/$x;
	$ysize = ($xsize * $y)/100;
	$x = $timgw;
	$y = intval($ysize);
}

if($y>$timgh){
	$ysize=($timgh*100)/$y;
	$xsize = ($ysize * $x)/100;
	$y = $timgh;
	$x = intval($xsize);
}
//*** End set Thumb image sizes ***//

//  $dest_w=$x*$scale_ratio;
//  $dest_h=$y*$scale_ratio;
  
  $dest_t="../data/t_".$_FILES[$xpic]['name'];
  $in_jpg = imagecreatefromjpeg($dest_jpgx);
  $out_jpg = imagecreatetruecolor($x,$y);
  imagecopyresampled($out_jpg,$in_jpg,0,0,0,0,$x,$y,$big_w,$big_h);
  imagejpeg($out_jpg,$dest_t,$quality); //### save this thumb to hard/server
  imagedestroy($in_jpg);
  imagedestroy($out_jpg);
  }
 // unlink($dest_jpgx);
  //################### end make thumb from uploaded pic #######################

//   } //### end type check
  } //### end selected/browsed files
} //### end MAIN function

?>