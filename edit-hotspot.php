<?php
$pageTitle = 'nodes';
include "connect.php";
$currentnode = $_GET['currentnode'];
$nextnode = $_GET['nextnode'];

try {

    $stmt = $conn->prepare("SELECT * FROM hotspot WHERE id1=$currentnode AND id2=$nextnode");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
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

try {
    if(isset($_POST['submit'])){
      //$node_id1 = $_POST['node_id1'];
      $id2 = $_POST['id2'];
      $pitch = $_POST['pitch'];
      $yaw = $_POST['yaw'];
      $weight = $_POST['weight'];

      $sql5 = "UPDATE hotspot SET id2=?, pitch=?, yaw=?, weight=? WHERE id1=$currentnode AND id2=$nextnode";
      //$sql5 = "UPDATE hotspot SET id2=?, pitch=?, yaw=?, weight=? WHERE id1=$currentnode";
      $stmt5 = $conn->prepare($sql5);
      $stmt5->execute([$id2, $pitch, $yaw, $weight]);
      /////////////////////////////
      header("Location: /finalp/editNode.php?node=$currentnode");
    }
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
    <head>
    <title>Title</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
<body>
<div class="container">
    <div class="form">
        <form action="" method="POST">
                    <div class="form-group row">
                        <label class="col-form-label">Current Node</label>
                        <input disabled type="text" class="form-control" value="<?php echo $result['id1'] ?>" name="id1">
                    </div>
                    <div class="form-group row">
                        <label>Next Node</label>
                        <select class="form-control" name="id2">
                        <?php foreach($result2 as $item) {
                            if($item['id'] != $result['id1']) {?>
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $result['id2']){echo 'selected';}else{echo '';} ?> ><?php echo $item['id']; ?></option>

                            <?php }
                                } ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Pitch</label>
                        <input type="text" class="form-control" name="pitch" value="<?php echo $result['pitch'] ?>">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Yaw</label>
                        <input type="text" class="form-control" name="yaw" value="<?php echo $result['yaw'] ?>">
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label">Weight</label>
                        <input type="text" class="form-control" name="weight" value="<?php echo $result['weight'] ?>">
                    </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Hotspot</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
