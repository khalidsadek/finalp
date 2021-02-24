<?php

include 'phpFile.php';
include 'connect.php';
//session_start();


function printPins($curND){

  $conn=connect();
  $sqlToGetPin = "SELECT * FROM pin WHERE nodeID=$curND";
  $GETPINS = $conn->query($sqlToGetPin);
  //print_r($GETPINS);
  echo '<tbody id="pins-tbody">';
    foreach($GETPINS as $item) {
  echo    '<tr>';
  echo      '<th scope="row">'.$item['id'].'</th>';
  echo      '<td>'.$item['lineNum'].'</td>';
  echo      '<td>'.$item['name'].'</td>';
  echo      '<td>'.$item['pitch'].'</td>';
  echo      '<td>'.$item['yaw'].'</td>';
  echo      '<td>'.$item['info'].'</td>';
  echo      '<td>';
  echo          '<button type="button"  class="btn btn-info editPinss"><i class="far fa-edit"></i></button> ';
  echo          '<button  type="button" data-id="'.$item['id'].'" class="btn btn-danger deletePin"><i class="fas fa-trash-alt"></button>';
  echo      '</td>';
  echo    '</tr>';
       }
  echo  '</tbody>';
}

function printHotspots($node){//FOR
  $conn=connect();
  $sqlToGetHotspot = "SELECT * FROM hotspot WHERE id1=$node";
  $hotspotsToEditNode = $conn->query($sqlToGetHotspot);
  //try {
    
    echo '<tbody id="hotspots_tbody">';
    foreach($hotspotsToEditNode as $item) { 
    echo '<tr>';
    echo    '<th scope="row">'.$item['id1'].'</th>';
    echo    '<td>'.$item['id2'].'</td>';

    echo    '<td>'.$item['pitch'].'</td>';
    echo    '<td>'.$item['yaw'].'</td>';
    echo    '<td>'.$item['weight'].'</td>';
    echo    '<td>';
    echo      '<a type="button" href="/finalp/edit-hotspot.php?currentnode='.$item['id1'].'&nextnode='.$item['id2'].'" class="btn btn-info edit"><i class="far fa-edit"></i></a> ';
    echo      '<button data-currentnode="'.$item['id1'].'" data-nextnode="'.$item['id2'].'" type="button" class="btn btn-danger deleteHotspot"><i class="fas fa-trash-alt"></i></button>';
    echo    '</td>';
    echo '</tr>';
     } 
  echo '</tbody>';
  /* } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  } */
  $conn->close();
}


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
  echo        "<a href='/finalp/editNode.php?node=".$item['id']."' type='button' class='btn btn-info'><i class='far fa-edit'></i></a> ";
  echo          "<button  type='button' data-id='".$item['id']."' class='btn btn-danger deleteNode'><i class='fas fa-trash-alt'></i></button>";
  echo "</td>";
  echo  "</tr>";
      }
  echo "</tbody>";
}

if(isset($_GET['pin']) && $_GET['current']){
  $pin = $_GET['pin'];
  $current = $_GET['current'];

  $queryPin = $conn->prepare("SELECT `id`,`lineNum` FROM pin WHERE nodeID=? AND name=?");
  $queryPin->execute([$current,$pin]);
  $resultPin = $queryPin->fetch();
  $PinID = $resultPin['id'];
  $line = $resultPin['lineNum'];
echo '<div id="editspot">';
  echo '<div class="row justify-content-center">';
  echo    '<button data-linenum="'.$line.'" data-id="'.$PinID.'" id="PpitchP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-up"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-linenum="'.$line.'" data-id="'.$PinID.'" id="PyawM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-left"></i></button>';
  echo    '<button data-linenum="'.$line.'" data-id="'.$PinID.'" id="PyawP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;margin-left:30px"><i class="fas fa-arrow-right"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-linenum="'.$line.'" data-id="'.$PinID.'" id="PpitchM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-down"></i></button>';
  echo '</div>';
echo '</div>';

}

if(isset($_GET['spot'])){
  $spot = $_GET['spot'];
  // $current = $_GET['current'];
  // $querySpot = $conn->prepare("SELECT `id2` FROM hotspot WHERE id1=? AND id2=?");
  // $querySpot->execute([$current,$spot]);
  // $resultSpot = $querySpot->fetch();
  // $editSpot = $resultSpot['id2'];
// echo '<div id="editspot">';
//   echo '<div class="row justify-content-center">';
//   echo    '<button data-pitchP="'.$editSpot.'" id="pitchP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-up"></i></button>';
//   echo '</div>';
//   echo '<div class="row justify-content-center">';
//   echo    '<button data-yawM="'.$editSpot.'" id="yawM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-left"></i></button>';
//   echo    '<button data-yawP="'.$editSpot.'" id="yawP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;margin-left:30px"><i class="fas fa-arrow-right"></i></button>';
//   echo '</div>';
//   echo '<div class="row justify-content-center">';
//   echo    '<button data-pitchM="'.$editSpot.'" id="pitchM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-down"></i></button>';
//   echo '</div>';
// echo '</div>';

echo '<div id="editspot">';
  echo '<div class="row justify-content-center">';
  echo    '<button data-pitchP="'.$spot.'" id="pitchP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-up"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-yawM="'.$spot.'" id="yawM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-left"></i></button>';
  echo    '<button data-yawP="'.$spot.'" id="yawP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;margin-left:30px"><i class="fas fa-arrow-right"></i></button>';
  echo '</div>';
  echo '<div class="row justify-content-center">';
  echo    '<button data-pitchM="'.$spot.'" id="pitchM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-down"></i></button>';
  echo '</div>';
echo '</div>';

}
//////////////////////////////////////////////////////////////////
/////////////////////////MOVEhOTsPOTS///////////////////////////
/////////////////////////////////////////////////////////////
if(isset($_GET['pitchP'])){
  

   try{
  $id1 = $_GET['cur'];
  $id2 = $_GET['pitchP'];
  $selectPitchSql = $conn->prepare("SELECT pitch FROM hotspot WHERE id1=? AND id2=?");
  $selectPitchSql->execute([$id1,$id2]);
  $resultPitchSql = $selectPitchSql->fetch();
  $pitch = $resultPitchSql['pitch'];

  $queryPitchP = "UPDATE hotspot SET pitch=? WHERE id1=? AND id2=?";
  $stmtPitchP = $conn->prepare($queryPitchP);
  $stmtPitchP->execute([$pitch+5, $id1, $id2]);
  echo "DONE";
  printHotspots($id1);
  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  } 

}

if(isset($_GET['pitchM'])){

  // echo "Hello";
   try{
  $id1 = $_GET['cur'];
  $id2 = $_GET['pitchM'];

  $selectPitchSql = $conn->prepare("SELECT pitch FROM hotspot WHERE id1=? AND id2=?");
  $selectPitchSql->execute([$id1,$id2]);
  $resultPitchSql = $selectPitchSql->fetch();
  $pitch = $resultPitchSql['pitch'];

  $queryPitchM = "UPDATE hotspot SET pitch=? WHERE id1=? AND id2=?";
  $stmtPitchM = $conn->prepare($queryPitchM);
  $stmtPitchM->execute([$pitch-5, $id1, $id2]);
  echo "DONE";
  printHotspots($id1);
  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  } 

}

if(isset($_GET['yawP'])){

  // echo "Hello";
   try{
  $id1 = $_GET['cur'];
  $id2 = $_GET['yawP'];

  $selectPitchSql = $conn->prepare("SELECT yaw FROM hotspot WHERE id1=? AND id2=?");
  $selectPitchSql->execute([$id1,$id2]);
  $resultPitchSql = $selectPitchSql->fetch();
  $yaw = $resultPitchSql['yaw'];

  
  $queryYawP = "UPDATE hotspot SET yaw=? WHERE id1=? AND id2=?";
  $stmtYawP = $conn->prepare($queryYawP);
  $stmtYawP->execute([$yaw+5, $id1, $id2]);
  printHotspots($id1);
  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  } 

}

if(isset($_GET['yawM'])){

  // echo "Hello";
   try{
  $id1 = $_GET['cur'];
  $id2 = $_GET['yawM'];

  $selectPitchSql = $conn->prepare("SELECT yaw FROM hotspot WHERE id1=? AND id2=?");
  $selectPitchSql->execute([$id1,$id2]);
  $resultPitchSql = $selectPitchSql->fetch();
  $yaw = $resultPitchSql['yaw'];

  $queryYawM = "UPDATE hotspot SET yaw=? WHERE id1=? AND id2=?";
  $stmtYawM = $conn->prepare($queryYawM);
  $stmtYawM->execute([$yaw-5, $id1, $id2]);
  echo "DONE";
  printHotspots($id1);
  } catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  } 

}

//////////////////////////////////////////////////////////////////
/////////////////////////MOVEPINSSSSSSS///////////////////////////
/////////////////////////////////////////////////////////////


if(isset($_GET['PpitchM'])){
  $PinID = $_GET['PinID'];
  $lineNum = $_GET['lineNum'];
  $curND = $_GET['curND'];
  $selectPpitchMSql = $conn->prepare("SELECT pitch FROM pin WHERE id=? AND lineNum=?");
  $selectPpitchMSql->execute([$PinID,$lineNum]);
  $resultPpitchMSql = $selectPpitchMSql->fetch();
  $PpitchM = $resultPpitchMSql['pitch'];

  $queryPpitchM = "UPDATE pin SET pitch=? WHERE id=? AND lineNum=?";
  $stmtPpitchM = $conn->prepare($queryPpitchM);
  $stmtPpitchM->execute([$PpitchM-5, $PinID, $lineNum]);
  //echo $PinID . " " . $lineNum;
  printPins($curND);

}

if(isset($_GET['PpitchP'])){
  $PinID = $_GET['PinID'];
  $lineNum = $_GET['lineNum'];
  $curND = $_GET['curND'];
  $selectPpitchPSql = $conn->prepare("SELECT pitch FROM pin WHERE id=? AND lineNum=?");
  $selectPpitchPSql->execute([$PinID,$lineNum]);
  $resultPpitchPSql = $selectPpitchPSql->fetch();
  $PpitchP = $resultPpitchPSql['pitch'];

  $queryPpitchP = "UPDATE pin SET pitch=? WHERE id=? AND lineNum=?";
  $stmtPpitchP = $conn->prepare($queryPpitchP);
  $stmtPpitchP->execute([$PpitchP+5, $PinID, $lineNum]);
  //echo $PinID . " " . $lineNum;
  printPins($curND);

}

if(isset($_GET['PyawM'])){
  $PinID = $_GET['PinID'];
  $lineNum = $_GET['lineNum'];
  $curND = $_GET['curND'];
  $selectPyawMSql = $conn->prepare("SELECT yaw FROM pin WHERE id=? AND lineNum=?");
  $selectPyawMSql->execute([$PinID,$lineNum]);
  $resultPyawMSql = $selectPyawMSql->fetch();
  $PyawM = $resultPyawMSql['yaw'];

  $queryPyawM = "UPDATE pin SET yaw=? WHERE id=? AND lineNum=?";
  $stmtPyawM = $conn->prepare($queryPyawM);
  $stmtPyawM->execute([$PyawM-5, $PinID, $lineNum]);
  //echo $PinID . " " . $lineNum;
  printPins($curND);

}

if(isset($_GET['PyawP'])){
  $PinID = $_GET['PinID'];
  $lineNum = $_GET['lineNum'];
  $curND = $_GET['curND'];
  $selectPyawPSql = $conn->prepare("SELECT yaw FROM pin WHERE id=? AND lineNum=?");
  $selectPyawPSql->execute([$PinID,$lineNum]);
  $resultPyawPSql = $selectPyawPSql->fetch();
  $PyawP = $resultPyawPSql['yaw'];

  $queryPyawP = "UPDATE pin SET yaw=? WHERE id=? AND lineNum=?";
  $stmtPyawP = $conn->prepare($queryPyawP);
  $stmtPyawP->execute([$PyawP+5, $PinID, $lineNum]);
  //echo $PinID . " " . $lineNum;
  printPins($curND);

}

if(isset($_GET['PinInfo'])){
    $conne = connect();
    $PinInfo = $_GET['PinInfo'];
    $Query = "SELECT * FROM pin WHERE name='$PinInfo'";
    $resultInfo = $conne->query($Query) or die($conne->error);
    $row = $resultInfo->fetch_assoc();
    //print_r($row);
    echo '<div class="card" style="width: 18rem;" id="pin-card">';
    echo        '<div class="card-body">';
    echo            '<h5 class="card-title">'.$row['name'].'</h5>';
    echo            '<h6 class="card-subtitle mb-2 text-muted">Node Number: '.$row['nodeID'].'<br>Line Number: '.$row['lineNum'].'</h6>';
    echo            '<p class="card-text" style="">Year Of Death: '.$row['info'].'</p>';
    echo        '</div>';
    echo '</div>';
}
