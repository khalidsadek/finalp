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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<div class="container">

  <div style="width:520px;margin:0px auto;margin-top:30px;">
    <h5>select line Number :</h5>
    <select class="livesearch selectLine" style="width:400px;">
      <option value="">Choose line</option>
      <?php foreach ($resultLineNames as $item): ?>
            <option value="<?php echo $item['line_name'] ?>"><?php echo $item['line_name'] ?></option>
          <?php endforeach; ?>

    </select>
  </div>



<table class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Line Number</th>
      <th scope="col">Image Path</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody id="nodes-table">
  <?php foreach($result as $item) { ?>
    <tr>
      <th scope="row"><?php echo $item['id']; ?></th>
      <td><?php echo $item['line_name']; ?></td>
      <td><?php echo $item['info']; ?></td>
      <td>
          <a href="/finalp/editNode.php?node=<?php echo $item['id'];?>" type="button" class="btn btn-info"><i class="far fa-edit"></i></a>
          <button  type="button" data-id="<?php echo $item['id'];?>" class="btn btn-danger deleteNode"><i class="fas fa-trash-alt"></i></button>
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
  function isNumeric(target) {
    return !isNaN(target) && !isNaN(parseFloat(target));
  }
  if(isNumeric(line))
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
