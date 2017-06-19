<?php
date_default_timezone_set('Asia/Dubai');
function getpdate($mdate){

$data_array = explode("-",$mdate);

$dd = $data_array[0];

$mm = $data_array[1];

$yy = $data_array[2];

$mdate = $yy."-".$mm."-".$dd;

return $mdate;

}



function getddate($mdate){

$data_array = explode("-",$mdate);

$yy = $data_array[0];

$mm = $data_array[1];

$dd = $data_array[2];

$mdate = $dd."-".$mm."-".$yy;

return $mdate;

}



function eventFirstDate($mdate){

$data_array = explode("-",$mdate);

$yy = $data_array[0];

$mm = $data_array[1];

$dd = $data_array[2];

$mdate = mktime(0,0,0,$mm,$dd,$yy);

$mdate = date('jS',$mdate);

return $mdate;

}



function eventSecondDate($mdate){

$data_array = explode("-",$mdate);

$yy = $data_array[0];

$mm = $data_array[1];

$dd = $data_array[2];

$mdate = mktime(0,0,0,$mm,$dd,$yy);

$mdate = date('F Y',$mdate);

return $mdate;

}



function eventMiddleDate($mdate){

$data_array = explode("-",$mdate);

$yy = $data_array[0];

$mm = $data_array[1];

$dd = $data_array[2];

$mdate = mktime(0,0,0,$mm,$dd,$yy);

$mdate = date('jS F',$mdate);

return $mdate;

}


function getRandomCode(){
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $su = strlen($an) - 1;
    return substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
}


//------------------------------------------------------------

?>