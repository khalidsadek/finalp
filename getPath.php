<?php

   // $a1=  $_GET['']
 require('phpFile.php');
 require('Dijkstra.php');

$from=$_POST['From'];
$des= $_POST['Destination'];

// print $from;

// $Destination = $_POST['Destination'];
// print $Destination;

  $edges=getJsonFormat();
  $g = new Graph();
  // echo "\n";
  // echo "\n";
  foreach($edges as $ed) {
    $g->addedge($ed['id1'],$ed['id2'],$ed['weight']);
   }

 // $jsons=explode("*",$result);

// $jsons=$jsons.filter(function (el) {
// return el != "";
// });

list($distances, $prev) = $g->paths_from($from);

$path = $g->paths_to($prev, $des);
// $path = $g->paths_to($prev, "3");
print_r($path);
