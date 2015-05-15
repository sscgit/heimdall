<?php
include("config.php");

if (isset($_GET['group'])) {
	$nGroup=$_GET['group'];
} else { 
	$nGroup=""; 
}

if (isset($_GET['switch'])) {
	$nSwitch=$_GET['switch'];
} else {
	$nSwitch="";
}

if (isset($_GET['action'])) {
	$nAction=$_GET['action'];
} else {
	$nAction="";
}

if (isset($_GET['delay'])) {
	$nDelay=$_GET['delay'];
} else {
	$nDelay=0;
}

$output = $nGroup.$nSwitch.$nAction.$nDelay;
if (strlen($output) >= 8) {
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
	socket_bind($socket, $source) or die("Could not bind to socket\n");
	socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
	socket_write($socket, $output, strlen ($output)) or die("Could not write output\n");
	socket_close($socket);
	header("Location: remote.php");
	//header("Location: index.php");
}
?>
<html>
	<head>
		<title>Heimdall</title>
		<link rel="stylesheet" href="resources/style.css">
		<!--[if IE]>
			<link rel="stylesheet" type="text/css" href="ie.css" />
		<![endif]-->
		<link rel="icon" type="image/png" href="resources/favicon.ico">
		<meta charset="UTF-8">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content=" height = device-height, width = device-width, initial-scale = 1.0, user-scalable = no, target-densitydpi = device-dpi" />
	</head>
<body>
	<div id="header">
		Heimdall
	</div>
	<div id="navigation">
		<ul>
			<li><a href="remote.php">Devices</a></li>
			<li><a href="">Thermo</a></li>
			<li><a href="">Access</a></li>
			<li><a href="">Settings</a></li>
		</ul>
	</div>
	<div style="clear:both;"></div>
<?php
$index=0;

foreach($config as $current) {
	if ($current != "") {
		$ig = $current[0];
		$is = $current[1];
		$id = $current[2];
      
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
		socket_bind($socket, $source) or die("Could not bind to socket\n");
		socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
		
		$output = $ig.$is."2";
		socket_write($socket, $output, strlen ($output)) or die("Could not write output\n");
		$state = socket_read($socket, 2048);

		if ($state == 0) {
			$ia = 1;
			$direction="on";
			error_log("on");
		}
		if ($state == 1) {
			$ia = 0;
			$direction="off";
			error_log("off");
		}
		echo "<a href=\"?group=".$ig;
		echo "&switch=".$is;
		echo "&action=".$ia."\">";
		echo "<div class=\"entry state" . $state . "\">";
		echo "<div class=\"switch\"></div>";
		echo "<span class=\"info\">".$id."</span>";
		echo "<span class=\"channel\">Kanal ".$ig.":".$is."</span>";
		echo "</div>\n";
		echo "</a>\n";

	}
	$index++;
}
?>
	</body>
</html>
