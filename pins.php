<?php
include "connect.php";
$pageTitle = 'pins';
try {

  $stmt = $conn->prepare("SELECT * FROM pins");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
################################################
include "navbar.php";
?>

<div class="container">
<table class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Line Name</th>
      <th scope="col">Name</th>
      <th scope="col">Pitch</th>
      <th scope="col">Yaw</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($result as $item) { ?>
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
$(".deleteNode").click(function(){
  var id = $(this).data('id');
  var x = confirm("Are you sure?");
  if(x == true){
    window.location = '/finalp/delete-node.php?node='+id;
    console.log("/finalp/delete-node.php?node="+id);
  }
})
</script>
<!-- href="/finalp/delete-node.php?node=<?php echo $item['id'];?>" -->
