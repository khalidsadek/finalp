<?php
require('phpFile.php');
require('Dijkstra.php');
session_start();
$pageTitle = 'Main';

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
include "navbar.php";
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="css/web_Style.css"/>

<div class="container" style="margin-top:100px">

        <form style="margin-bottom:100px">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>
                </div>
                <div class="form-group col-md-4">
                    <button style="height:100%;" type="button" class="btn btn-info btn-block rounded-0" onclick="getNodeByName()">Search</button>
                </div>
            </div>
        </form>
    <div id="panorama" class="img-responsive"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!--<input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>-->
<script>
// $.ajax({
//   url: 'handleRequests.php',
//   type: 'POST',
//   data: {name: name},
//   async: false,
//   success: function (response) {
//     // console.log(response);
//
// // removeHotspots();
//     newSearch=1;
//     getPath(response);
//
//
//   },
// });
</script>
<script src="js/script.js"></script>

<script src="js/search.js"></script>
<!--<input type="button"   value="Search" class="btn btn-info btn-lg rounded-0" onclick="getNodeByName()">-->
</body>
</html>
