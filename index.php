<?php
require('phpFile.php');
require('Dijkstra.php');
session_start();

//$myfile = fopen("graph.txt", "w");
 $edges=getJsonFormat();
 $g = new Graph();
 foreach($edges as $ed) {
   $g->addedge($ed['id1'],$ed['id2'],$ed['weight']);
}

$serialize =serialize($g);
$_SESSION['graph_arr'] = $serialize;
//echo $serialized;


//print_r(unserialize($serialize));

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Custom hot spots</title>




<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">


  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- Latest compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="css/web_Style.css"/>

</head>
<body>


  <div class="container">
    <div class="row mt-4">
      <div class="col-md-8 mx-auto bg-light rounded p-4">
        <h5 class="text-center font-weight-bold">Haifa Cemetery</h5>
        <hr class="my-1">
        <h6 class="text-center text-secondary">search grave by name in the search box</h6>
        <!-- <form action="getPath.php" method="post" class="p-3"> -->
          <form  class="p-3" >
          <div class="col-md-8 mx-auto bg-light rounded p-4">
            <!-- <input type="hidden" name="ArrayData" value="<?php $serialize ?>"/> -->
            <input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>
            <div class="col-md-8 mx-auto bg-light rounded p-4">
              <input type="button"   value="Search" class="btn btn-info btn-lg rounded-0" onclick="getNodeByName()">
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-5" style="position: relative;margin-top: -38px;margin-left: 215px;">
        <div class="list-group" id="show-list">
          <!-- Here autocomplete list will be display -->
        </div>
      </div>


    </div>

    <div id="panorama" ></div>
    <!-- <div id="panoramaTemp" ></div> -->



  </div>




<script src="js/script.js"></script>

  <script src="js/search.js"></script>







</body>
</html>
