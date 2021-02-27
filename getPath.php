<?php
session_start();

  require('handleRequests.php');
  require('Dijkstra.php');
// //
$from=$_POST['From'];
$des= $_POST['Destination'];

$edges=getJsonFormat();
$g = new Graph();

foreach($edges as $ed) {
   $g->addedge($ed['id1'],$ed['id2'],$ed['weight']);
}

$myfile = fopen("graph.txt", "w") or die("Unable to open file!");
fwrite($myfile,serialize($g));
fclose($myfile);
//////////////////////////////////////////////////////////
list($distances, $prev) = $g->paths_from($from);
// //
$path = $g->paths_to($prev, $des);




print_r($path);

