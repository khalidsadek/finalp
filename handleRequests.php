<?php

include 'phpFile.php';
include 'connect.php';
//session_start();



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


if(isset($_GET['nodeId1'])) {
  echo getNodePath($_GET["nodeId1"])  ;
}



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

if(isset($_GET['spot'])){
  session_start();
  $spot = $_GET['spot'];
  $current = $_GET['current'];
  $querySpot = $conn->prepare("SELECT `id2` FROM hotspot WHERE id1=? AND id2=?");
  $querySpot->execute([$current,$spot]);
  $resultSpot = $querySpot->fetch();
  $editSpot = $resultSpot['id2'];
echo '<div id="editspot">';
  echo '<div class="row justify-content-center">';
  echo    '<button data-pitchP="'.$editSpot.'" id="pitchP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-up"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-yawM="'.$editSpot.'" id="yawM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-left"></i></button>';
  echo    '<button data-yawP="'.$editSpot.'" id="yawP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;margin-left:30px"><i class="fas fa-arrow-right"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-pitchM="'.$editSpot.'" id="pitchM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-down"></i></button>';
  echo '</div>';
echo '</div>';

}
