<?php

$uselogin = "false"; // Auf True stellen, wenn es verwendet werden soll.

$source = $_SERVER['SERVER_ADDR'];
$target = '192.168.43.222'; // IP-Adresse des Pi's
$port = 11337;

/*
 * Hier kannst du deine Schalter definieren.
 * array("Hauscode", "Nummer", "beschreibung"  
 * Nummer: A = 01; B = 02; C = 03;
 * Hauscode: Oben = 1; Unten: 0; z.B. 01010  
 *
 */
$config=array(
  array("00010", "02", "Gerät1"),
  array("00010", "01", "Gerät2"),
  array("00010", "03", "Gerät3"),
)
?>
