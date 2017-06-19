<?php
//error_reporting(E_ALL);
//$resdata=$_POST;

//file_put_contents("sucess.json",json_encode($resdata));
require_once('Connections/eventscon.php'); 
 include("functions.php");
require_once('dtcm_api.php');
 include("config.php");
require_once('model_function.php');


//file_put_contents("test4.txt",$tickets_data);
include_once "dompdf/dompdf_config.inc.php";
$files = glob("./pdf/include/*.php");
foreach($files as $file) include_once($file);
$html = "";

$html += "<div class='main-content'>
<div class='container'>


<div class='conent-right'>



<div class='shows-box'>";

$html+="<h1>Promotor Details'</h1>
<div class='shows-box-frames'>
 <table width='100%' border='0' cellspacing='0' cellpadding='0' >
   <tr>
    <td align='left'>";
                    
 $html+="This is space for sales INfo daTA";      
                    
                    
$html+="</td>
          </tr>
          <tr>
           <td>&nbsp;</td>
          </tr>
 </table>
</div>
</div>

</div>

</div>
</div>";

    $dompdf = new DOMPDF() ;
    $dompdf->load_html($html);
    $dompdf->render();
    //if ($stream) {
       //$dompdf->stream(dirname(__FILE__)."/eventticket.pdf");
    /*} else {
        return $dompdf->output();
    }
	 * $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('Brochure.pdf', $output);
	 * 
	 * */
    $pdf=$dompdf->output();
       $file_location = dirname(__FILE__)."/reports/sales_report_".date('dmYhis').".pdf";
	   file_put_contents($file_location, $dompdf->output()); 
//print the pdf file to the screen for saving
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="sales_report.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file_location));
header('Accept-Ranges: bytes');
readfile($file_location);
       //file_put_contents($file_location,$pdf);

?>