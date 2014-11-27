<?php
/**
 * This file with return the right prefix for using absolut path
 */

//Define the directory depth
//i.e. /home/fhahner/public_html/index.php > use value 3
// if you use /home/fhahner/m3/index.php > use value 4 and so on
$n = 3;

// do not change here anything
$i = 1;
$path = "";
$infoArray = explode("/", $_SERVER['SCRIPT_FILENAME']);
while ( $i != $n+1) {
    $path .= '/' . $infoArray[$i];
    $i++;
}  
?>
