<?php

include "connect.php";
try{
$Q = "UPDATE hotspot SET id2=?, pitch=?, yaw=?, weight=? WHERE id1=? AND id2=?";
$stmtQ= $conn->prepare($Q);
$stmtQ->execute([$_GET['id2'], $_GET['pitch'], $_GET['yaw'], $_GET['weight'], $_GET['id1'], $_GET['actuaNextHotSpot']]);
echo "DONE";

$Qreturn = "UPDATE hotspot SET id1=?, id2=?, weight=? WHERE id1=? AND id2=?";
$stmtQreturn= $conn->prepare($Qreturn);
$stmtQreturn->execute([$_GET['id2'], $_GET['id1'], $_GET['weight'], $_GET['actuaNextHotSpot'],$_GET['id1']]);



}catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} 
?>
