<?php require_once('Connections/eventscon.php');

ob_start();





$strClass	= 'map';



$define_style = 'height:260px';



$zoom =  9;



$location_address=$_GET['location'];

$venue=$_GET['venue'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



	<title>Google Map</title>



	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>



	<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js" type="text/javascript"></script>



	



</head>







<body><div id="map" class="<?php echo $strClass; ?>" style="border:0px;<?php echo $define_style; ?>"></div>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js"></script>



  <script type="text/javascript">



  var marker, i;



  //Function creates a marker for given address and places it on the map



  function placeAddressOnMap(address, i,message) {



	  gc.geocode({'address': address}, function (res, status) {



	  if (status == google.maps.GeocoderStatus.OK) {



		map.setCenter(res[0].geometry.location);



		marker = new google.maps.Marker({



		  position: res[0].geometry.location,



		  map: map



		});



	  marker.setTitle(message);



	  attachAddressMessage(marker, i, message);







<?php if($define_style) { ?>



		// Add a Circle overlay to the map.



        var circle = new google.maps.Circle({



          	map: map,



          	radius: 3000, // 30 km



			strokeColor: "#FF0000",



			strokeOpacity: 0.2,



			strokeWeight: 2,



			fillColor: "#FF0000",



			fillOpacity: 0.2	  



        });



        circle.bindTo('center', marker, 'position');





<?php } ?>







	  }



	  });



}



  



  



    function placeLocationOnMap(address,lat,lng, i,id) {



		map.setCenter(new google.maps.LatLng(lat, lng));



		marker = new google.maps.Marker({



		  draggable: false,



		  raiseOnDrag: false,



		  icon: image,



		  shadow: shadow,



		  shape: shape,



		  position: new google.maps.LatLng(lat, lng),



		  map: map



		});



	  marker.setTitle(address);



	  attachAddressMessage(marker, i, address,id);







<?php if($define_style) { ?>



		// Add a Circle overlay to the map.



        var circle = new google.maps.Circle({



          	map: map,



          	radius: 3000, // 30 km



			strokeColor: "#FF0000",



			strokeOpacity: 0.2,



			strokeWeight: 2,



			fillColor: "#FF0000",



			fillOpacity: 0.2		  



        });



        circle.bindTo('center', marker, 'position');





<?php } ?>



	}



  function attachAddressMessage(marker, number, message, id) {



		message =  '<b>'+message+',<?php echo $location_address; ?></b>';



		var boxText = document.createElement("div");



			boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: black; padding: 5px;color:#fff;font-family:arial;font-size:12px;";



			boxText.innerHTML = message;







			var myOptions = {



				 content: boxText



				,disableAutoPan: false



				,maxWidth: 0



				,pixelOffset: new google.maps.Size(-90, 0)



				,zIndex: null



				,boxStyle: { 



				  //background: "url('tipbox.gif') no-repeat",



				  opacity: 0.85



				  ,width: "180px"



				 }



				,closeBoxMargin: "10px 2px 2px 2px"



				,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"



				,infoBoxClearance: new google.maps.Size(1, 1)



				,isHidden: false



				,pane: "floatPane"



				,enableEventPropagation: false



			};







			google.maps.event.addListener(marker, "click", function (e) {



				<?php if($_GET['infobox']!=='html') { ?> ib.open(map, this);                        



				<?php } else { ?>



									$.fancybox.showActivity();



									



                                    $.fancybox({



										href: "/widget.php?id="+id,



										'width'				: 660,



										'height'			: 290,



										'autoScale'     	: true,



										'transitionIn'		: 'fade',



										'transitionOut'		: 'fade',



										'type'				: 'iframe',



										'scrolling' 		: 'no'



										// other options



									});



									$.fancybox.hideActivity();



				<?php } ?>



			});



			var ib = new InfoBox(myOptions);



			<?php if(!$define_style) { ?>ib.open(map, marker);		<?php } ?>	



	}





  var gc = new google.maps.Geocoder();



  



  var infowindow = new google.maps.InfoWindow();







  var map = new google.maps.Map(document.getElementById('map'), {



	zoom: <?php echo $zoom; ?>,//,



	scrollwheel: false,



	center: new google.maps.LatLng(24.9500,55.3333),



	mapTypeId: google.maps.MapTypeId.ROADMAP



  });



  



  var image = new google.maps.MarkerImage(



  'images/map_pointer.png',



  new google.maps.Size(32,32),



  new google.maps.Point(0,0),



  new google.maps.Point(16,32)



	);



	



	var shadow = new google.maps.MarkerImage(



	  'images/shadow.png',



	  new google.maps.Size(52,32),



	  new google.maps.Point(0,0),



	  new google.maps.Point(16,32)



	);



	



	var shape = {



	  coord: [20,0,22,1,23,2,24,3,25,4,25,5,26,6,26,7,26,8,26,9,26,10,26,11,26,12,26,13,26,14,25,15,25,16,25,17,24,18,24,19,23,20,23,21,22,22,22,23,21,24,21,25,20,26,20,27,19,28,18,29,18,30,17,31,15,31,14,30,13,29,13,28,12,27,11,26,11,25,10,24,10,23,9,22,9,21,8,20,8,19,7,18,7,17,7,16,6,15,6,14,5,13,5,12,5,11,5,10,5,9,5,8,5,7,6,6,6,5,7,4,8,3,9,2,10,1,12,0,20,0],



	  type: 'poly'



	};



	var PlotLocation = new Array();

placeAddressOnMap("<?php echo $location_address;?>",0,"<?php echo $venue;?>");



 <?php



/*$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($location_address).'&sensor=false');

$output= json_decode($geocode);	



$latitude=$output->results[0]->geometry->location->lat;			

$langitude=$output->results[0]->geometry->location->lng;							

*/	?>

<?php if($latitude !='' && $langitude!=''){?>

//placeLocationOnMap("(<?php echo $promoter_name;?>)",<?php echo $latitude;?>,<?php echo $langitude;?>,1,3);

<?php }else{?>

	//placeLocationOnMap("(<?php echo $promoter_name;?>)",'25.2','55.3',1,3);

<?php }?>

  </script>





</body>



</html>



