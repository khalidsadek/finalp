<?php
include "connect.php";
$currentnode = $_GET['currentnode'];
$nextnode = $_GET['nextnode'];
try {
    $sql = "DELETE FROM hotspot WHERE id1=$currentnode AND id2=$nextnode";
    $conn->exec($sql);
    $sql2 = "DELETE FROM hotspot WHERE id1=$nextnode AND id2=$currentnode";
    $conn->exec($sql2);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    echo $sql2 . "<br>" . $e->getMessage();
  }
?>
