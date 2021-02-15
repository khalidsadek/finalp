<?php
session_start();
//var_dump(unserialize($_SESSION['graph_arr']));
//
//    // $a1=  $_GET['']
  require('phpFile.php');
  require('Dijkstra.php');
// //
$from=$_POST['From'];
$des= $_POST['Destination'];
//
// // print $from;
//
// // $Destination = $_POST['Destination'];
// // print $Destination;
//
   $edges=getJsonFormat();
   $g = new Graph();
//   // echo "\n";
//   // echo "\n";
   foreach($edges as $ed) {
     $g->addedge($ed['id1'],$ed['id2'],$ed['weight']);
    }

 // $jsons=explode("*",$result);

// $jsons=$jsons.filter(function (el) {
// return el != "";
// });
///==============$graph = unserialize($_SESSION['graph_arr']);

$graph=$g;


// print_r(getpath($from,$_SESSION['graph_arr']));
list($distances, $prev) = $graph->paths_from($from);
// //
$path = $graph->paths_to($prev, $des);
// // $path = $g->paths_to($prev, "3");
// var_dump($_SESSION['graph_arr']);



print_r($path);
// print_r($graph);
