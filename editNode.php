<?php
$pageTitle = 'nodes';
include "connect.php";
$node = $_GET['node'];

$query = $conn->prepare("SELECT * FROM node where id=$node");
$query->execute();
$no = $query->fetch(PDO::FETCH_ASSOC);
try {

  $stmt = $conn->prepare("SELECT * FROM hotspot WHERE id1=$node");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
try {

    $stmt2 = $conn->prepare("SELECT * FROM node");
    $stmt2->execute();
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
################################################
try {
    if(isset($_POST['submit'])){
      //$node_id1 = $_POST['node_id1'];
      $node_id2 = $_POST['id2'];
      $pitch = $_POST['pitch'];
      $yaw = $_POST['yaw'];
      $weight = $_POST['weight'];

      $sql = "INSERT INTO hotspot (id1, id2, pitch, yaw, weight)
      VALUES ('$node', '$node_id2', '$pitch', '$yaw', '$weight')";
      $conn->exec($sql);
      /////////////////////////////
      $sql2 = "UPDATE node SET hasHotspots='1' WHERE id=$node";
      $stmt3 = $conn->prepare($sql2);
      $stmt3->execute();
      header("Location: /finalp/editNode.php?node=$node");
    }
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

include "navbar.php";
?>

<div class="container">
    <div class="img text-center">
    <img src="/finalp/<?php echo $no['info'] ?>" class="img-fluid" alt="Responsive image " style="max-width: 500px;height:300px">
    </div>
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
          <a type="button" href="/finalp/edit-hotspot.php?hotspot_id=<?php echo $item['id2']?>&node=<?php echo $node?>" class="btn btn-info edit">Edit Hotspots</a>
          <a href="/finalp/delete-hotspot.php?hotspot=<?php echo $item['id'];?>" type="button" class="btn btn-danger">Delete Hotspots</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-hotspot-modal">Add Hotspot</button>
</div>

<?php
include "footer.php";
?>

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
                        <input disabled type="text" class="form-control" value="<?php echo $node ?>" name="node_id1">
                    </div>
                    <div class="form-group row">
                    <label>Next Node</label>
                    <select class="form-control" name="node_id2">
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

