<?php
include "connect.php";
$hotspot = $_GET['hotspot'];
try {
    $sql = "DELETE FROM hotspot WHERE id=$hotspot";
    $conn->exec($sql);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
?>
