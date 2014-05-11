<?php
error_reporting(0);
session_start();
if($_SESSION['username'] != ""){
$what = 1;
} else {
$what = 0;
}

include("config.php");

if (isset($_GET['group'])) $nGroup=$_GET['group'];
else $nGroup="";
if (isset($_GET['switch'])) $nSwitch=$_GET['switch'];
else $nSwitch="";
if (isset($_GET['action'])) $nAction=$_GET['action'];
else $nAction="";
if (isset($_GET['delay'])) $nDelay=$_GET['delay'];
else $nDelay=0;

$output = $nGroup.$nSwitch.$nAction.$nDelay;
if (strlen($output) >= 8) {
  $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
  socket_bind($socket, $source) or die("Could not bind to socket\n");
  socket_connect($socket, $target, $port) or die("Could not connect to socket\n");
  socket_write($socket, $output, strlen ($output)) or die("Could not write output\n");
  socket_close($socket);
  header("Location: index.php");
}

?>
<html>
  <head>
    <title>SmartControl</title>
    <link rel="stylesheet" href="style.css">
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="ie.css" />
<![endif]-->
	<link rel="icon"
          type="image/png"
          href="favicon.ico">
	<meta charset="UTF-8">
    <meta name="viewport"
          content="
              height = device-height,
              width = device-width,
              initial-scale = 1.0,
              user-scalable = no ,
              target-densitydpi = device-dpi
              " />
  </head>
<body>

<a href="remote.php?destroy=true"><div id="xbutton">
</div></a>
<div id="header">
SmartControl
</div>

<?php
if($what == 1 && $_GET['destroy'] != "true") {
?>
<?php echo '<div id="main"><div id="cont"><center><h1 style="color: black; font-family: trench;">Hallo, ' . $_SESSION['username'] . '</h1>
<span class="logout">
<a href="remote.php?destroy=true">LOGOUT</a>
</span>
</center></div></div>'; ?>

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
    }
    if ($state == 1) {
      $ia = 0;
      $direction="off";
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
	
	<?php
} elseif($what == 0) {
echo '<div id="main"><div id="cont">Du musst dich zuerst anmelden. Du wirst nun weitergeleitet!</div></div>';
echo '<meta http-equiv="refresh" content="2; URL=index.php" />';

}

if($_GET['destroy'] == "true") {
echo '<div id="main"><div id="cont">Du wurdest erfolgreich abgemeldet. Schönen Tag noch!</div></div>';
echo '<meta http-equiv="refresh" content="2; URL=index.php" />';
session_destroy();
}
?>
</body>
</html>