<?php
include "connect.php";
$pageTitle = 'nodes';
try {

  $stmt = $conn->prepare("SELECT * FROM node");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

try {

  $stmt1 = $conn->prepare("SELECT line_name FROM node GROUP BY line_name ORDER BY line_name ASC");
  $stmt1->execute();
  $resultLineNames = $stmt1->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
################################################
include "navbar.php";
?>

<div class="container">

  <div style="width:520px;margin:0px auto;margin-top:30px;">
    <h5>select line name :</h5>
    <select class="livesearch selectLine" style="width:400px;">
      <option value="0">Choose line</option>
      <?php foreach ($resultLineNames as $item): ?>
            <option value="<?php echo $item['line_name'] ?>"><?php echo $item['line_name'] ?></option>
          <?php endforeach; ?>

    </select>
  </div>



<table class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Line Name</th>
      <th scope="col">Image Path</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody id="nodes-table">
  <?php foreach($result as $item) { ?>
    <!-- ///iffff
      $(".livesearch").chosen()!=$item['line_name']
      return
////////////////////////////// -->
    <tr>
      <th scope="row"><?php echo $item['id']; ?></th>
      <td><?php echo $item['line_name']; ?></td>
      <td><?php echo $item['info']; ?></td>
      <td>
          <a href="/finalp/editNode.php?node=<?php echo $item['id'];?>" type="button" class="btn btn-info">Edit Node</a>
          <button  type="button" data-id="<?php echo $item['id'];?>" class="btn btn-danger deleteNode">Delete Node</button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
    <a type="button" class="btn btn-primary" href="/finalp/addNode.php">
        Create Node
    </a>
</div>
<?php
include "footer.php";
?>
<script>
$(document).on('click','.deleteNode',function(){
  var id = $(this).data('id');
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-node.php?node='+id;
    console.log("/finalp/delete-node.php?node="+id);
  }
})

$(document).on('change','.selectLine',function(){
  var line = $(this).val();
  $.ajax({
          url: 'handleRequests.php',
          type: 'GET',
          data: {line: line},
          async: false,
          success: function(response){
            $('#nodes-table').replaceWith(response);
            console.log(response);
          },
          }
      );
})
</script>
