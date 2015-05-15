<?php
/*
 * Raspberry Remote
 * http://xkonni.github.com/raspberry-remote/
 *
 * configuration for the webinterface
 *
 */

/*
 * define ip address and port here
 */
$source = $_SERVER['SERVER_ADDR'];
$target = shell_exec("hostname -I | awk '{print $1}'");
//$target = '192.168.1.41';
$port = 11337;

/*
 * specify configuration of sockets to use
 *	array("group", "plug", "description");
 * use empty string to create empty box
 *   ""
 *
 */
$config=array(
	array("01001", "01", "Wohnzimmer Mitte"),
	array("01001", "02", "Wohnzimmer Ecke"),
	array("01010", "01", "Flur"),
	array("01100", "01", "Bibliothek Ecke"),
	array("01100", "02", "Bibliothek Schreibtisch"),
	array("01011", "01", "Schlafzimmer (West)"),
	array("01011", "02", "Schlafzimmer (Ost)"),
)
?>
