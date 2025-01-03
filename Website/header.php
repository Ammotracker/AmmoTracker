<?php

include 'config.php';
$conn = mysqli_connect($host, $username, $password , $database);
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);



 function getRandomBrightColor() {
	 // Ensure the RGB components are not too low to avoid dark colors
	 $red = mt_rand(128, 255);   // Red component (128-255 for brightness)
	 $green = mt_rand(128, 255); // Green component (128-255 for brightness)
	 $blue = mt_rand(128, 255);  // Blue component (128-255 for brightness)
	 
	 return sprintf('#%02X%02X%02X', $red, $green, $blue);
 }
?>