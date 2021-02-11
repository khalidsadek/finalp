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
################################################
include "navbar.php";
?>

<div class="container">
<table class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Line Name</th>
      <th scope="col">Image Path</th>
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
          <a href="/finalp/delete-node.php?node=<?php echo $item['id'];?>" type="button" class="btn btn-danger">Delete Node</a>
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
