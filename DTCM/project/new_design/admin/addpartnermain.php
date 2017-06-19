

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<title>Untitled Document</title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">

<style type="text/css">

<!--

.style5 {

	color: #FFFFFF;

	font-weight: bold;

	font-size: 16px;

}

.style1 {font-size: 14px}

-->

</style>

</head>



<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="88%">

      <? if($Submit)

	{

	 $filename = $HTTP_POST_FILES['image']['name']; 

	$uploadpath = '../siteimages/'; 

    $path ="siteimages/";

    $source = $HTTP_POST_FILES['image']['tmp_name']; 

    $dest = ''; 

	



      if ( ($source != 'none') && ($source != '' )) { 



	    $loc = rand(1,99);

		$dest = $uploadpath.$loc.$filename;

		$path .= $loc.$filename;

                

                

        if ( $dest != '' ) {  if ( move_uploaded_file( $source, $dest ) ) { 

             @chmod ($dest , 0755);  

                //echo 'File successfully stored.<BR>'; 



            } else { 

              $path='';

              // echo 'File could not be stored.<BR>'; 



            } 



        }  



    } else { 

       $path='';  

       //echo 'File not supplied, or file too big.<BR>'; 



    } 

	



	

	 addPartner($name,$path,$url);

	  ?>

      <Script language="JavaScript">

		   alert("Partner Added Successfully");

          location.replace("addpartner.php");

		   </Script>

      <?

	

	}

	

	?>

      <style type="text/css">

<!--

.style1 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 14px;

	font-weight: bold;

}

-->

      </style>
      <br>

      <form action="" method="post" enctype="multipart/form-data" name="form1">
        <table width="100%" border="0" align="center"  cellspacing="1" cellpadding="0">


          <tr>

            <td width="200">              <div align="right">Company Name : </div></td>

            <td>&nbsp;&nbsp;

                <input name="name" type="text" id="name" size="60"></td>
          </tr>

          <tr>

            <td>              <div align="right">logo:</div></td>

            <td>&nbsp;&nbsp;

                <input type="file" name="image" ></td>
          </tr>

          <tr>

            <td valign="top">             <div align="right">Website URL: </div></td>

            <td>&nbsp;&nbsp; <input name="url" type="text" id="url" size="60"></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td><input type="submit" class="pmBtn" name="Submit" value="Save">
            <input name="Reset" type="reset" class="pmBtn" value="Reset"></td>
          </tr>

          <tr>

            <td colspan="2">

              <div align="center">&nbsp;&nbsp;&nbsp;</div></td>
          </tr>
        </table>

    </form>

	<script language="JavaScript" type="text/javascript">

//You should create the validator only after the definition of the HTML form

  var frmvalidator  = new Validator("form1");

  frmvalidator.addValidation("name","req","Please Enter Name of the Company");

  frmvalidator.addValidation("url","req","URL Field is Empty");

  

     </script></td>

  </tr>

</table>

</body>

</html>

