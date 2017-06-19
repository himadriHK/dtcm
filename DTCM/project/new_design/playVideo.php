<?php

if(isset($_REQUEST["fileName"]))
{
$fileUrl=$_REQUEST["fileName"];
}
//echo $fileUrl;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
		body { background-color: #fff; padding: 0 20px; color:#000; font: 13px/18px Arial, sans-serif; }
		a { color: #360; }
		h3 { padding-top: 20px; }
		ol { margin:5px 0 15px 16px; padding:0; list-style-type:square; }
	</style>
<title>Video</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->
<table width="350" height="250" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center">
		<?php
		if(isset($_REQUEST['from']))
		{
			$from=$_REQUEST['from'];
			if($from == 'video' || $from == 'audio')
			{
		?>
	<script type="text/javascript" src="swfobject.js"></script>
	<script type="text/javascript">
		swfobject.registerObject("player","9.0.98","expressInstall.swf");
	</script>

	<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="350" height="250">
		<param name="movie" value="player-viral.swf" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />
		<param name="flashvars" value="file=<?php echo $fileUrl;?>&image=preview.jpg" />
		<param name='autoStart' value="true">
		<object type="application/x-shockwave-flash" data="player-viral.swf" width="375" height="275">
			<param name="movie" value="player-viral.swf" />
			<param name="allowfullscreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="flashvars" value="file=<?php echo $fileUrl;?>&image=preview.jpg" />
			<param name='autoStart' value="true">
		</object>
	</object>
	
	<?php
		}
		else
		{
		?>
			<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0','height','27','width','400','align','middle','src','http://www.google.com/reader/ui/3247397568-audio-player?audioUrl=http://www.ticketmastersme.com/<?php echo $fileUrl;?>','allowscriptaccess','never','quality','High','bgcolor','','wmode','Window','flashvars','','pluginspage','http://www.macromedia.com/go/getflashplayer','_cx','10583','_cy','714','movie','http://www.google.com/reader/ui/3247397568-audio-player?audioUrl=http://www.ticketmastersme.com/<?php echo $fileUrl;?>','play','0','loop','-1','salign','LT','menu','-1','base','','scale','NoScale','devicefont','0','embedmovie','0','swremote','','moviedata','','seamlesstabbing','1','profile','0','profileaddress','','profileport','0','allownetworking','all','allowfullscreen','false' ); //end AC code
</script><noscript><object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" height="27" width="400" align="middle" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"><param name="_cx" value="10583"><param name="_cy" value="714"><param name="FlashVars" value=""><param name="Movie" value="http://www.google.com/reader/ui/3247397568-audio-player.swf?audioUrl=http://www.ticketmastersme.com/<?php echo $fileUrl;?>"><param name="Src" value="http://www.google.com/reader/ui/3247397568-audio-player.swf?audioUrl=http://www.ticketmastersme.com/<?php echo $fileUrl;?>"><param name="WMode" value="Window"><param name="Play" value="0"><param name="Loop" value="-1"><param name="Quality" value="High"><param name="SAlign" value="LT"><param name="Menu" value="-1"><param name="Base" value=""><param name="AllowScriptAccess" value="never"><param name="Scale" value="NoScale"><param name="DeviceFont" value="0"><param name="EmbedMovie" value="0"><param name="BGColor" value=""><param name="SWRemote" value=""><param name="MovieData" value=""><param name="SeamlessTabbing" value="1"><param name="Profile" value="0"><param name="ProfileAddress" value=""><param name="ProfilePort" value="0"><param name="AllowNetworking" value="all"><param name="AllowFullScreen" value="false"><embed type="application/x-shockwave-flash" src="http://www.google.com/reader/ui/3247397568-audio-player.swf?audioUrl=http://www.ticketmastersme.com/<?php echo $fileUrl;?>" allowscriptaccess="never" quality="best" bgcolor="#ffffff" wmode="window" flashvars="playerMode=embedded" pluginspage="http://www.macromedia.com/go/getflashplayer" height="27" width="400"></object></noscript>
		<?php
		}
	}
	?>
	<!-- END OF THE PLAYER EMBEDDING -->

		</td>
	</tr>
</table>
</body>
</html>
