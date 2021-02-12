<?php
$pageTitle = 'nodes';
include "connect.php";
$node = $_GET['node'];
###################################################################
#############################PINS##################################
###################################################################
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

  $insertPin = "INSERT INTO pin (id, name, lineNum, pitch, yaw, info, nodeID) VALUES (?,?,?,?,?,?,?)";
  $conn->prepare($insertPin)->execute([$id, $name, $lineNum, $pitch, $yaw, $info, $nodeID]);
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
////////////////////////GET PIN////////////////////////////////////
try {
  $stmtPin = $conn->prepare("SELECT * FROM pin WHERE nodeID=$node ORDER BY id ASC");
  $stmtPin->execute();
  $resulPin = $stmtPin->fetchAll(PDO::FETCH_ASSOC);
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



<div class="container">
    <!-- <div class="img text-center">
    <img src="/finalp/<?php echo $no['info'] ?>" class="img-fluid" alt="Responsive image " style="max-width: 500px;height:300px">
    </div> -->
<div id="panorama2" class="img-responsive"></div>

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
  <tbody>
  <?php foreach($result as $item) { ?>
    <tr>
      <th scope="row"><?php echo $item['id1']; ?></th>
      <td><?php echo $item['id2']; ?></td>
      <td><?php echo $item['pitch']; ?></td>
      <td><?php echo $item['yaw']; ?></td>
      <td><?php echo $item['weight']; ?></td>
      <td>
          <a type="button" href="/finalp/edit-hotspot.php?currentnode=<?php echo $item['id1']?>&nextnode=<?php echo $item['id2'];?>" class="btn btn-info edit">Edit Hotspots</a>
          <button data-currentnode="<?php echo $item['id1'];?>" data-nextnode="<?php echo $item['id2'];?>" type="button" class="btn btn-danger deleteHotspot">Delete Hotspots</button>
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
    <tbody>
    <?php foreach($resulPin as $item) { ?>
      <tr>
        <th scope="row"><?php echo $item['id']; ?></th>
        <td><?php echo $item['lineNum']; ?></td>
        <td><?php echo $item['name']; ?></td>
        <td><?php echo $item['pitch']; ?></td>
        <td><?php echo $item['yaw']; ?></td>
        <td><?php echo $item['info']; ?></td>
        <td>
            <!-- <a href="/finalp/editNode.php?node=<?php echo $item['id'];?>" type="button" class="btn btn-info">Edit Node</a> -->
            <button  type="button" data-id="<?php echo $item['id'];?>" class="btn btn-danger deletePin">Delete Node</button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createPin">
    Create Pin
  </button>
  <?php include 'pins.php' ?>
</div>

<?php
include "footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<div id="edit-modal"></div>

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
<script>
$(".deleteHotspot").click(function(){
  var id1 = $(this).data('currentnode');
  var id2 = $(this).data('nextnode');
  console.log(id1);
  console.log(id2);
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-hotspot.php?currentnode='+id1+'&nextnode='+id2;
    //console.log("/finalp/delete-node.php?node="+id);
  }
})
//console.log(<?php echo $no['info']?>);
viewer = pannellum.viewer('panorama2', {
"type": "equirectangular",
"autoRotate": -10,
"panorama": "/finalp/<?php echo $no['info']?>",
"hotSpots": gethotspots(<?php echo $no['id']?>) ,
"autoLoad": true,
"stopAutoRotate":false,
"hfov":150

});


function gethotspots(p1)
{

hotspots=new Array();
var newUs ="createTooltipFunc" ;
var newValue= hotspot;
var newUs1 ="createTooltipArgs" ;
var newValue1= "";
var newUs2 ="clickHandlerFunc" ;
//var newValue2= openModal;
var newUs3 ="cssClass";
var newValue3="park-hot-spot hs-park-overview";
var newValue32="custom-hotspot";
var newValue33="custom-hotspot-here";
var newValue34="custom-hotspot-green-grave";
// var newValue32="custom-hotspot-grave";
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
          // obj[newUs2]=newValue2;
          // if(obj['cssClass']==null)
          if(obj['name']==null){
          // if(checkType()==1 || (checkType()==0 && featureHotSpots.indexOf(obj['id'])!=-1))
          // {
          obj[newUs1]=obj['id'];
    //      obj[newUs2]=newValue2;
          // if(featureHotSpots[0]==obj[newUs1])
          // {
          //       obj[newUs3]=newValue33;
          // }else {
              obj[newUs3]=newValue3;
          // }

          // obj[newUs4]=newValue4;
        // }
        }
        else{
           obj[newUs3]=newValue32;
        }
          // else {
          //   // if(checkType()==0 && previuseHotSpot.indexOf(obj['id'])!=-1)
          //   // {
              obj[newUs1]=obj['name'];
          //     if(obj[newUs1]==name)
          //     {
          //       obj[newUs3]=newValue34;
          //     }
          //     else {
          //       obj[newUs3]=newValue32;
          //     }
          //
          //     // obj[newUs4]=;
          //     // obj[newUs4]=newvalue41;
          //    // }
          // }

          // }
          strings.push(obj);
          // hotSpotsIds.push(obj['id']);
        }
        // console.log(strings);
        return strings;
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
                  <?php
                  foreach ($result2 as $nodes) { ?>
                    <option value="<?php echo $nodes['id']; ?>"><?php echo $nodes['id']; ?></option>
                <?php  }?>

                </select> -->
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Info</label>
                <input type="text" class="form-control" name="info">
              </div>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="submit2" class="btn btn-primary">Add Pin</button>
          </form>
        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
<script>

$(".deletePin").click(function(){
  var id = $(this).data('id');
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-pin.php?pin='+id;

  }
})
</script>
