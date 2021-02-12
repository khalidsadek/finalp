<?php
include "connect.php";
$node = $_GET['node'];

$getNode = $conn->prepare("SELECT * FROM node WHERE id=$node");
$getNode->execute();
$photoPath = $getNode->fetchColumn(2);
$path = $_SERVER['DOCUMENT_ROOT']."/finalp/".$photoPath;



try {

    unlink($path);
    $sql = "DELETE FROM node WHERE id=$node";
    $conn->exec($sql);
    $sql2 = "DELETE FROM hotspot WHERE id1=$node OR id2=$node";
    $conn->exec($sql2);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    echo $sql2 . "<br>" . $e->getMessage();
}
?>
