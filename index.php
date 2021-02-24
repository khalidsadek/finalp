<?php
require('phpFile.php');
require('Dijkstra.php');
session_start();
$pageTitle = 'Main';


include "navbar.php";
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="css/web_Style.css"/>
<style>
  body{
    height: 300%;
    overflow-y: scroll;
  }
</style> 
<!-- <div class="container" style="margin-top:100px">

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
</div> -->


<div class="container">
  <div class="row z-index: 2">
    <div class="col-md-8 mx-auto bg-light rounded p-4">
      <h5 class="text-center font-weight-bold">Haifa Cemetery</h5>
      <hr class="my-1">
      <h6 class="text-center text-secondary">search grave by name in the search box</h6>
      <!-- <form action="getPath.php" method="post" class="p-3"> -->
        <form   class="p-3" >
          <div class="input-group">
            <input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>
            <div class="input-group-append">
              <input type="button" id="search-submit" name="submit"  value="Search" class="btn btn-info btn-lg rounded-0;" onclick="return getNodeByName()">
            </div>
          </div>
        </form>
        <div style="z-index: 2 !important;height:200px">
      <div class="list-group d-none" style="overflow-y:scroll;height: 200px;" id="show-list">
        <!-- Here autocomplete list will be display -->
      </div>
    </div>
    </div>
    
  </div>

</div>

<div class="row" style="height:700px;z-index: 1;margin-top:100px;margin-bottom:100px">
    <div class="col-2" style="">
        <div class="card d-none" style="width: 18rem;" id="pin-card">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
<!--                <a href="#" class="card-link">Card link</a>-->
<!--                <a href="#" class="card-link">Another link</a>-->
            </div>
        </div>
    </div>

    <div class="col-8" >
        <div id="panorama" class="img-responsive"></div>
    </div>
    <div class="col-2">

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!--<input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>-->
<script>
    $("#search-submit").click(function(){
        var data = $("#search").val();
        //console.log(data);
        $.ajax({
            url:"handleRequests.php",
            type:'GET',
            data: {PinInfo:data},
            success: function(response){
                //$("pin-card").removeClass('d-none')
                $("#pin-card").replaceWith(response)
                console.log(response);
                $("#show-list").addClass('d-none');
            }

        })
    })
  $("#search").keyup(function () {
    
    var searchText = $(this).val();
    if (searchText != "") {
      console.log(searchText);
      $.ajax({
        url: 'handleRequests.php',
        type: 'POST',
        data: {query: searchText},
        async: false,
        error: function(xhr, status, error) {
          console.log(xhr)
          console.log(status)
          console.log(error)
        },
        success: function (response) {
          var myElement = document.getElementById("show-list");
          $(myElement).removeClass('d-none');
          $("#show-list").html(response);

        },
      });
    } else {
      $("#show-list").html("");
          var myElement = document.getElementById("show-list");
          $(myElement).addClass('d-none');
    }
  });
  // Set searched text in input field on click of search button
  $(document).on("click", "a", function () {
    $("#search").val($(this).text());
    $("#show-list").html("");
  });
</script>
<script src="js/script.js"></script>

<!-- <script src="js/search.js"></script> -->
<!--<input type="button"   value="Search" class="btn btn-info btn-lg rounded-0" onclick="getNodeByName()">-->
</body>
</html>
