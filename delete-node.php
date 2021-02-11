<?php
include "connect.php";
$node = $_GET['node'];
try {
    $sql = "DELETE FROM node WHERE id=$node";
    $conn->exec($sql);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>