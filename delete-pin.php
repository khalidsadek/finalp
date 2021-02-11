<?php
include "connect.php";
$pin = $_GET['pin'];

$sql = "DELETE FROM pin WHERE id=$pin";
$conn->exec($sql);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
