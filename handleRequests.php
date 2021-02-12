<?php

include 'phpFile.php';
include 'connect.php';
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

if(isset($_GET['line'])){
  $line = $_GET['line'];
  $q = $conn->prepare("SELECT * FROM node WHERE line_name=$line");
  $q->execute();
  $lines = $q->fetchAll(PDO::FETCH_ASSOC);
  echo "<tbody id='nodes-table'>";
        foreach($lines as $item) {

  echo  "<tr>";
  echo    "<th scope='row'>". $item['id'] . "</th>";
  echo    "<td>" . $item['line_name'] . "</td>";
  echo    "<td>" . $item['info'] . "</td>";
  echo    "<td>";
  echo        "<a href='/finalp/editNode.php?node=".$item['id']."' type='button' class='btn btn-info'>Edit Node</a> ";
  echo          "<button  type='button' data-id='".$item['id']."' class='btn btn-danger deleteNode'>Delete Node</button>";
  echo "</td>";
  echo  "</tr>";
      }
  echo "</tbody>";
}
