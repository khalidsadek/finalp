

<!--

  require("Dijkstra.php"); -->
<!--
<script>
console.log("sxxxxxxxxxx");
</script>

 -->






<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Custom hot spots</title>


    <!-- jQuery library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <!-- Popper JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->

    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdn.pannellum.org/2.3/pannellum.css"/> -->
    <!-- <script type="text/javascript" src="https://cdn.pannellum.org/2.3/pannellum.js"></script> -->
    <!-- <script type="text/javascript" src="js/libpannellum.js"></script>
    <script type="text/javascript" src="js/Pannellum.js"></script> -->
      <!-- <script type="text/javascript" src="/js/Pannellum.js"></script> -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->



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
          <form  class="p-3"  >
          <div class="col-md-8 mx-auto bg-light rounded p-4">
            <input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info" placeholder="Search..." autocomplete="off" required>
            <div class="col-md-8 mx-auto bg-light rounded p-4">
              <!-- <input type="submit" name="submit"  value="Search" class="btn btn-info btn-lg rounded-0" onclick="return getNodeByName()"> -->
                <input type="submit" id="SearchBtn" name="submit"  value="Search" class="searchBtn btn btn-info btn-lg rounded-0">
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

  </div>


  <!-- <script src="script.js"></script> -->


  <div class="container">
     <!-- <table id="userTable" border="1" >
        <thead>
          <tr>
            <th width="5%">S.no</th>
            <th width="20%">id1</th>
            <th width="20%">id2</th>
            <th width="20%">weight</th>
          </tr>
        </thead>
        <tbody></tbody>
     </table> -->
<!--
     <form>
       <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
      </div>
       <div class="form-row">
         <div class="form-group col-md-6">
           <label for="inputCity">City</label>
           <input type="text" class="form-control" id="inputCity">
         </div>
         <div class="form-group col-md-4">
           <label for="inputState">State</label>
           <select id="inputState" class="form-control">
             <option selected>Choose...</option>
             <option>...</option>
           </select>
         </div>
         <div class="form-group col-md-2">
           <label for="inputZip">Zip</label>
           <input type="text" class="form-control" id="inputZip">
         </div>
       </div>
       <div class="form-group">
         <div class="form-check">
           <input class="form-check-input" type="checkbox" id="gridCheck">
           <label class="form-check-label" for="gridCheck">
             Check me out
           </label>
         </div>
       </div>

       <button type="submit" class="btn btn-primary">Sign in</button>
     </form> -->




  </div>



<script src="js/script.js"></script>

  <script src="js/search.js"></script>







</body>
</html>
