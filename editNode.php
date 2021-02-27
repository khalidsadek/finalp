<?php
$pageTitle = 'nodes';
include "connect.php";
$node = $_GET['node'];
session_start();
###################################################################
#############################PINS##################################
###################################################################
////////////////////////GET PIN////////////////////////////////////
try {
    $stmtPin = $conn->prepare("SELECT * FROM pin WHERE nodeID=$node ORDER BY id ASC");
    $stmtPin->execute();
    $resulPin = $stmtPin->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
////////////////////////INSERT PIN//////////////////////////
try{
if(isset($_POST['submit2'])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $lineNum = $_POST['lineNum'];
  $pitch = $_POST['pitch'];
  $yaw = $_POST['yaw'];
  $info = $_POST['info'];
  $nodeID = $node;//$_POST['nodeID'];
  $isExist = 0;
    foreach($resulPin as $pin){
        if($pin['id'] == $id && $pin['lineNum'] == $lineNum && $pin['name']==$name )
            $isExist = 1;
    }
    if($isExist == 0){
        if(is_numeric($id) && is_numeric($lineNum) && $id != null && $lineNum != null){
        $insertPin = "INSERT INTO pin (id, name, lineNum, pitch, yaw, info, nodeID) VALUES (?,?,?,?,?,?,?)";
        $conn->prepare($insertPin)->execute([$id, $name, $lineNum, $pitch, $yaw, $info, $nodeID]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        }else{
            echo "<script>alert('ID and Line Number should be numeric')</script>";
        }
    } else{
        echo "<script>alert('Pin ID,Line Number or Name ALREADY EXIST')</script>";
    }
}
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

###################################################################


###################################################################
###########################NODE####################################
###################################################################
/////////////////////GET CURRENT NODE DATA////////////////////////
$query = $conn->prepare("SELECT * FROM node where id=$node");
$query->execute();
$no = $query->fetch(PDO::FETCH_ASSOC);
///////////////////////GET NODES FOR ADD NEXT NODE TO HOTSPOT ADDITION FORM/////////////////////////////////////
try {

    $stmt2 = $conn->prepare("SELECT * FROM node");
    $stmt2->execute();
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
###################################################################



###################################################################
#########################HOTSPOTS#################################
###################################################################
///////////////////////////GET HOTSPOTS RELATED TO CURRENT NODE////////////////////////////
try {
  $stmt = $conn->prepare("SELECT * FROM hotspot WHERE id1=$node");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

///////////////////////////ADD HOTSPOT////////////////////////////
try {
    if(isset($_POST['submit'])){
      //$node_id1 = $_POST['node_id1'];
      $id2 = $_POST['id2'];
      echo $id2;
      $pitch = $_POST['pitch'];
      $yaw = $_POST['yaw'];
      $weight = $_POST['weight'];
      $isSpotExist = 0;
      foreach($result as $spot){
        if($spot['id2'] == $id2) {
            $isSpotExist = 1;
        }
      }
      if($isSpotExist == 0){
      $sql = "INSERT INTO hotspot (id1, id2, pitch, yaw, weight)
      VALUES ('$node', '$id2', '$pitch', '$yaw', '$weight')";
      $conn->exec($sql);
      $sql99 = "INSERT INTO hotspot (id1, id2, pitch, yaw, weight)
      VALUES ('$id2', '$node', '$pitch', '$yaw', '$weight')";
      $conn->exec($sql99);
      /////////////////////////////
      $sql2 = "UPDATE node SET hasHotspots='1' WHERE id=$node";
      $stmt3 = $conn->prepare($sql2);
      $stmt3->execute();
      header("Location: /finalp/editNode.php?node=$node");
      } else{
          echo "<script>alert('HotSpot ALREADY EXIST')</script>";
      }
    }
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
###################################################################
###################################################################

include "navbar.php";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<link rel="stylesheet" href="/finalp/css/web_Style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">


<div class="container">
  <input hidden id="current" value="<?php echo $node;?>" >
<div class="row">
  <div class="col-8">
    <div id="panorama2" class="img-responsive"></div>
  </div>

  <div class="col-4 " style="margin-top:50px">

    <div class="row justify-content-center" style="margin-bottom: 45px;">
      <div class="row justify-content-center">
      <h5>Choose Object to move</h5>
        <select class="livesearch SelectToMove" style="width:90%;">      
          <option value="0">...</option>
          <?php foreach ($result as $h){ ?>
                <option value="<?php echo $h['id2']; ?>"><?php echo $h['id2']; ?></option>
              <?php } ?>
          <?php foreach ($resulPin as $p) { ?>
                <option value="<?php echo $p['name']; ?>"><?php echo $p['name']; ?></option>
              <?php } ?>

        </select>
      </div>
    </div>
    <div id="editspot">
    <div class="row justify-content-center">
      <button disabled id="pitchP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-up"></i></button>
    </div>
    <div class="row justify-content-center">
      <button disabled id="yawM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-left"></i></button>
      <button disabled id="yawP" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;margin-left:30px"><i class="fas fa-arrow-right"></i></button>
    </div>
    <div class="row justify-content-center">
      <button disabled id="pitchM" type="button" class="btn btn-danger btn-lg" style="color:red;background-color:transparent;"><i class="fas fa-arrow-down"></i></button>
    </div>
  </div>
  </div>
</div>
</div>

<div class="container">

<table class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">Current Node</th>
      <th scope="col">Next Node</th>
      <th scope="col">Pitch</th>
      <th scope="col">Yaw</th>
      <th scope="col">Weight</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody id="hotspots_tbody">
  <?php foreach($result as $item) { ?>
    <tr>
      <th scope="row"><?php echo $item['id1']; ?></th>
      <td><?php echo $item['id2']; ?></td>
      <td><?php echo $item['pitch']; ?></td>
      <td><?php echo $item['yaw']; ?></td>
      <td><?php echo $item['weight']; ?></td>
      <td>
          <button data-nextNodeID="<?php echo $item['id2']; ?>" type="button" class="btn btn-info editHotspot"><i class='far fa-edit'></i></button>
          <button data-currentnode="<?php echo $item['id1'];?>" data-nextnode="<?php echo $item['id2'];?>" type="button" class="btn btn-danger deleteHotspot"><i class="fas fa-trash-alt"></i></button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add-hotspot-modal">Add Hotspot</button>

<br>
<br>
<br>
<hr>
</div>
<div class="container" style="margin-top:100px;margin-bottom:100px">
  <table class="table table-hover text-center">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Line Number</th>
        <th scope="col">Name</th>
        <th scope="col">Pitch</th>
        <th scope="col">Yaw</th>
        <th scope="col">Info</th>
        <th scope="col">Control</th>
      </tr>
    </thead>
    <tbody id="pins-tbody">
    <?php foreach($resulPin as $item) { ?>
      <tr>
        <td scope="row"><?php echo $item['id']; ?></td>
        <td><?php echo $item['lineNum']; ?></td>
        <td><?php echo $item['name']; ?></td>
        <td><?php echo $item['pitch']; ?></td>
        <td><?php echo $item['yaw']; ?></td>
        <td><?php echo $item['info']; ?></td>
        <td>
            <button type="button"  class="btn btn-info editPinss"><i class='far fa-edit'></i></button>
            <button  type="button" data-id="<?php echo $item['id'];?>" class="btn btn-danger deletePin"><i class="fas fa-trash-alt"></i></button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createPin">
    Add Grave
  </button>
</div>

<?php
include "footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- <script src="/finalp/js/script.js"></script> -->

<!-- Modal -->
<div class="modal fade" id="add-hotspot-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="form">
                <form action="" method="POST">
                    <div class="form-group row">
                        <label class="col-form-label">Current Node</label>
                        <input disabled type="text" class="form-control" value="<?php echo $node ?>" name="id1">
                    </div>
                    <div class="form-group row">
                    <label>Next Node</label>
                    <select class="form-control" name="id2">
                    <?php foreach($result2 as $item) {
                        if($item['id'] != $node) {?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['id']; ?></option>

                        <?php }
                            } ?>
                    </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Pitch</label>
                        <input type="text" class="form-control" name="pitch">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Yaw</label>
                        <input type="text" class="form-control" name="yaw">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Weight</label>
                        <input type="text" class="form-control" name="weight">
                    </div>

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="sumbit" class="btn btn-primary" name="submit">Add Hotspot</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<script>

var hotSpotsIds=new Array();

removeHotspots();
viewer = pannellum.viewer('panorama2', {
"type": "equirectangular",
// "autoRotate": -10,
"panorama": "/finalp/<?php echo $no['info']?>",
"hotSpots": gethotspots(<?php echo $no['id']?>) ,
"autoLoad": true,
"stopAutoRotate":false,
"hfov":100});
/////////////////////////////////////////////////////////
//////////////////////MovePins////////////////////////////
///////////////////////////////////////////
$(document).on('click','#PpitchM',function (e) {
    e.preventDefault();
    var PinID = $("#PpitchM").data("id");
    var lineNum = $("#PpitchM").data("linenum");
    var curND = '<?php echo $node ?>';
    var PpitchM = "PpitchM";
    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {PinID: PinID,
                  lineNum:lineNum,
                  curND:curND,
                  PpitchM:PpitchM},
            //async: false,
            success: function(response){
              // console.log(response);
              $("#pins-tbody").replaceWith(response);
              removeHotspots();
              loadViewr();
            },
            });
});

$(document).on('click','#PpitchP',function (e) {
    e.preventDefault();
    var PinID = $("#PpitchP").data("id");
    var lineNum = $("#PpitchP").data("linenum");
    var PpitchP = "PpitchP";
    var curND = '<?php echo $node ?>';

    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {PinID: PinID,
                  lineNum:lineNum,
                  curND:curND,
                  PpitchP:PpitchP},
            //async: false,
            success: function(response){
              // console.log(response);
              $("#pins-tbody").replaceWith(response);
              removeHotspots();
              loadViewr();
            },
            });
});

$(document).on('click','#PyawM',function (e) {
    e.preventDefault();
    var PinID = $("#PyawM").data("id");
    var lineNum = $("#PyawM").data("linenum");
    var curND = '<?php echo $node ?>';
    var PyawM = "PyawM";
    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {PinID: PinID,
                  lineNum:lineNum,
                  curND:curND,
                  PyawM:PyawM},
            //async: false,
            success: function(response){
              // console.log(response);
              $("#pins-tbody").replaceWith(response);
              removeHotspots();
              loadViewr();
            },
            });
});

$(document).on('click','#PyawP',function (e) {
    e.preventDefault();
    var PinID = $("#PyawP").data("id");
    var lineNum = $("#PyawP").data("linenum");
    var curND = '<?php echo $node ?>';
    var PyawP = "PyawP";
    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {PinID: PinID,
                  lineNum:lineNum,
                  curND:curND,
                  PyawP:PyawP},
            //async: false,
            success: function(response){
              // console.log(response);
              $("#pins-tbody").replaceWith(response);
              removeHotspots();
              loadViewr();
            },
            });
});


/////////////////////////////////////////////////////////
//////////////////////MoveHotspots////////////////////////////
///////////////////////////////////////////
$(document).on('click','#pitchP',function (e) {
    e.preventDefault();
    var pitchP = $("#pitchP").data("pitchp");
    var cur = '<?php echo $node ?>';
      // var url = 'index.php';
    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {pitchP: pitchP,
                   cur:cur},
            async: false,
            success: function(response){
              //console.log(response);
              $("#hotspots_tbody").replaceWith(response);
             
            removeHotspots();
            loadViewr();
             
              // $('#div1-wrapper').load(url + ' #panorama2');
             
             
    
              
            },
            });





});


$(document).on('click','#pitchM',function (e) {
    e.preventDefault();
    var pitchM = $("#pitchM").data("pitchm");
    var cur = '<?php echo $node ?>';

    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {pitchM: pitchM,
                   cur:cur},
            async: false,
            success: function(response){
              //console.log(response);
              $("#hotspots_tbody").replaceWith(response);
              removeHotspots();
            loadViewr();
            },
            });
});



$(document).on('click','#yawP',function (e) {
    e.preventDefault();
    var yawP = $("#yawP").data("yawp");
    var cur = '<?php echo $node ?>';

    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {yawP: yawP,
                   cur:cur},
            async: false,
            success: function(response){
              //console.log(response);
              $("#hotspots_tbody").replaceWith(response);
              removeHotspots();
            loadViewr();
            },
            });
});

$(document).on('click','#yawM',function (e) {
    e.preventDefault();
    var yawM = $("#yawM").data("yawm");
    var cur = '<?php echo $node ?>';

    $.ajax({
            url: 'handleRequests.php',
            type: 'GET',
            data: {yawM: yawM,
                   cur:cur},
            async: false,
            success: function(response){
              //console.log(response);
              $("#hotspots_tbody").replaceWith(response);
              removeHotspots();
            loadViewr();
            },
            });
});


$(document).on('change','.SelectToMove',function(){
  var target = $(this).val();
  var current = $("#current").val();
  function isNumeric(target) {
     return !isNaN(target) && !isNaN(parseFloat(target));
  }
  if(target==0){
    $("#editSpot").addClass("d-none");
  }
  if(isNumeric(target)){
      $.ajax({
        url:'/finalp/handleRequests.php',
        type: 'GET',
        data: {spot:target,
              current:current
              },
        success: function(response){
          $("#editspot").replaceWith(response);
          removeHotspots();
              loadViewr();
        }
      })
    
  } else{
    $.ajax({
      type: "GET",
      url: "/finalp/handleRequests.php",
      data: {pin:target,
            current:current},
      //dataType: "dataType",
      success: function (response) {
        $("#editspot").replaceWith(response);
      }
    });
  }
})
$(document).on('click','.deleteHotspot',function(){
  var id1 = $('.deleteHotspot').data('currentnode');
  var id2 = $('.deleteHotspot').data('nextnode');
  console.log(id1);
  console.log(id2);
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-hotspot.php?currentnode='+id1+'&nextnode='+id2;
    //console.log("/finalp/delete-node.php?node="+id);
  }
})
//console.log(<php echo $no['info']?>);



function loadViewr()
{

  

  viewer = pannellum.viewer('panorama2', {
              "type": "equirectangular",
              // "autoRotate": -10,
              "panorama": "/finalp/<?php echo $no['info']?>",
              "hotSpots": gethotspots(<?php echo $no['id']?>) ,
              "autoLoad": true,
              "stopAutoRotate":false,
              "hfov":100 });
}





function gethotspots(p1)
{


hotspots=new Array();
var newUs ="createTooltipFunc" ;
var newValue= hotspot;
var newUs1 ="createTooltipArgs" ;
var newValue1= "";
var newUs2 ="clickHandlerFunc" ;
var newValue2= "";
var newUs3 ="cssClass";
var newValue3="park-hot-spot hs-park-overview";
var newValue32="custom-hotspot";
var newValue33="custom-hotspot-here";
var newValue34="custom-hotspot-green-grave";
var newUs4="text";
var newValue4="come here";
var newvalue41="back";


    var strings=new Array();
    $.ajax({
            url: 'handleRequests.php',
            type: 'POST',
            data: {node1: <?php echo $no['id']?>},
            async: false,
            success: function(response){
              hotspots=response;

            },
            }
        );

        console.log(hotspots);
        var jsons=hotspots.split('*');
        jsons=jsons.filter(function (el) {
  return el != "";
});

        for(var i=0;i<jsons.length;i++)
        {
          var obj = JSON.parse(jsons[i]);
          obj[newUs]=newValue;

          if(obj['name']==null){

          obj[newUs1]=obj['id'];
          obj[newUs3]=newValue3;


          obj[newUs4]=newValue4;

        }
          else {

              obj[newUs1]=obj['name'];
              if(obj[newUs1]==name)
              {
                obj[newUs3]=newValue34;
              }
              else {
                obj[newUs3]=newValue32;
              }


          }


          strings.push(obj);
          hotSpotsIds.push(obj['id']);

        }

        return strings;
}

function removeHotspots()
{
  for(var i=0;i<hotSpotsIds.length;i++)
  {
    viewer.removeHotSpot(hotSpotsIds[i]);
  }
  hotSpotsIds=new Array();
}
function arrayRemove(arr, value) {
  var index = arr.indexOf(value);
if (index !== -1) arr.splice(index, 1);

}

function hotspot(hotSpotDiv, args) {

      // console.log(hotSpotDiv);
      // console.log("||||||||");
      // console.log(args);
         hotSpotDiv.classList.add('custom-tooltip');
         var span = document.createElement('span');
         span.innerHTML = args;
         hotSpotDiv.appendChild(span);
         span.style.width = span.scrollWidth - 20 + 'px';
         span.style.marginLeft = -(span.scrollWidth - hotSpotDiv.offsetWidth) / 2 + 'px';
         span.style.marginTop = -span.scrollHeight - 12 + 'px';
          }


</script>
<!-- Modal -->
<div class="modal fade" id="createPin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="" method="post">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Line Number</label>
                <input type="text" class="form-control" name="lineNum">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Name</label>
                <input type="text" class="form-control" name="name">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Pin ID</label>
                <input type="text" class="form-control" name="id">
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Pitch</label>
                <input type="text" class="form-control" name="pitch">
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Yaw</label>
                <input type="text" class="form-control" name="yaw">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Node</label>
                <input type="text" class="form-control" name="nodeID" value="<?php echo $node;?>" disabled>
                <!-- <select class="form-control" name="nodeID">
                  <php
                  foreach ($result2 as $nodes) { ?>
                    <option value="<php echo $nodes['id']; ?>"><php echo $nodes['id']; ?></option>
                <php  }?>

                </select> -->
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Info</label>
                <input type="text" class="form-control" name="info">
              </div>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="submit2" class="btn btn-primary">Add Grave</button>
          </form>
        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
<script>


$(document).on('click','.deletePin',function(){
  var id = $(this).data('id');
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-pin.php?pin='+id;

  }
})
</script>


<script>
///////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////EDITHOTSPOTS//////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click','.editHotspot',function(){
  $("#edit-hotspot-modal").show('show');
  $tr = $(this).closest('tr');
  
  var data = $tr.children("td").map(function(){
    return $(this).text();
  }).get();
  console.log(data)

  $("#id2").val(data[0]);
  $("#pitch").val(data[1]);
  $("#yaw").val(data[2]);
  $("#weight").val(data[3]);
  $("#actual-NextHotSpot").val(data[0])
})
$("#update-hotspot").click(function(){
  //
  
})

function edit_htspt(){
  var data = $("#update-hotspot-form").serialize();
  //console.log()
   $.ajax({
    type: "GET",
    url: "edit-hotspot.php",
    data: data,
    //dataType: "dataType",
    success: function (response) {
      console.log(response)
      location.reload()
    }
  });
}
</script>

<div class="modal" id="edit-hotspot-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" onclick="$('#edit-hotspot-modal').hide()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container">
    <div class="form">
        <form id="update-hotspot-form">
                    <div class="form-group row">
                        <label class="col-form-label">Current Node</label>
                        <input disabled type="text" class="form-control" value="<?php echo $node ?>">
                        <input hidden type="text" class="form-control" value="<?php echo $node ?>" name="id1">
                    </div>
                    <div class="form-group row">
                        <label>Next Node</label>
                        <select class="form-control" name="id2" id="id2">
                          <?php foreach($result2 as $item){?>  
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['id']; ?></option>
                            <?php } ?>
                        </select>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Pitch</label>
                        <input type="text" class="form-control" name="pitch" value="" id="pitch">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Yaw</label>
                        <input type="text" class="form-control" name="yaw" value="" id="yaw">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Weight</label>
                        <input type="text" class="form-control" name="weight" value="" id="weight">
                    </div>
                    <input hidden id="actual-NextHotSpot" name="actuaNextHotSpot" value="">       
        </form>
    </div>
</div>
      </div>
      <div class="modal-footer">
      <button type="button" onclick="edit_htspt()" id="update-hotspot" class="btn btn-primary">Update Hotspot</button>
            <button type="button" onclick="$('#edit-hotspot-modal').hide()" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





<script>
///////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////EDITpins//////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click','.editPinss',function(){
  $("#edit-pin-modal").show('show');
  $tr = $(this).closest('tr');
  
  var data = $tr.children("td").map(function(){
    return $(this).text();
  }).get();
  console.log(data)

  $("#pinID").val(data[0]);
  $("#LineNumber").val(data[1]);
  $("#pinName").val(data[2]);
  $("#pitchPin").val(data[3]);
  $("#yawPin").val(data[4]);
  $("#info").val(data[5]);

  var x = document.getElementById("actual-pinID").value = data[0];
  $("#actual-LineNumber").val(data[1]); 
  
})


function edit_pin(){
  var data = $("#update-pin-form").serialize();
   console.log(data)
    $.ajax({
    type: "GET",
    url: "edit-pin.php",
    data: data,
    success: function (response) {
        if(response == 10){
            alert("ID or Line number should be numeric")
            console.log(response)
        }else{
            location.reload()
            console.log(response+"A7A")
        }

    }
  });
}
</script>
<div class="modal" id="edit-pin-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" onclick="$('#edit-pin-modal').hide()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container">
          <form action="" id="update-pin-form">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Line Number</label>
                <input type="text" class="form-control" value="" id="LineNumber" name="lineNum">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Name</label>
                <input type="text" class="form-control" value="" id="pinName" name="name">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Pin ID</label>
                <input type="text" class="form-control" value="" id="pinID" name="pinID">
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Pitch</label>
                <input type="text" class="form-control" name="pitchPin" value="" id="pitchPin">
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Yaw</label>
                <input type="text" class="form-control" name="yawPin" value="" id="yawPin">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Node</label>
                <select class="form-control" name="nodeid" id="nodeid">
                          <?php foreach($result2 as $item){?>  
                            <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $node){echo 'selected';} ?>><?php echo $item['id']; ?></option>
                            <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Info</label>
                <input type="text" class="form-control" name="info" value="" id="info">
              </div>
            </div>
            <input hidden id="actual-pinID" name="acutalPinID" value="">
            <input hidden id="actual-LineNumber" name="actualLineNum" value="">
          </form>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" onclick="$('#edit-pin-modal').hide()" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="edit_pin()" id="update-pin" class="btn btn-primary">Update Grave</button>           
      </div>
    </div>
  </div>
</div>

