<?php

include 'phpFile.php';
// error_reporting(E_ERROR | E_PARSE);



if (isset($_POST["node1"])){
  // $number=$_POST['node1'];
  // echo getHotSpots($number);
echo getHotSpots($_POST["node1"]);

}


if (isset($_POST["query"])) {

echo searchName($_POST["query"]);

}


if (isset($_POST["name"])) {

echo getNode($_POST["name"]);

}


// if(isset($_GET['type'])) {
//   echo "[1,2]";
// }
if (isset($_GET['$getJ'])) {

echo getJsonFormat();

}
