<?php
include "connect.php";
try{

$pinID = $_GET['pinID'];
$lineNum = $_GET['lineNum'];
$pinName = $_GET['name'];
$pitchPin = $_GET['pitchPin'];
$yawPin = $_GET['yawPin'];
$nodeid = $_GET['nodeid'];
$info = $_GET['info'];
echo $lineNum;
 $Q = "UPDATE pin SET id=?, lineNum=?, name=?, pitch=?, yaw=?, info=?, nodeID=? WHERE lineNum=$lineNum AND id=$pinID";
$stmtQ= $conn->prepare($Q);
$stmtQ->execute([$pinID, $lineNum, $pinName, $pitchPin, $yawPin, $info, $nodeid]);
echo "DONE";
}catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>
