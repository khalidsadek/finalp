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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />




<div class="container">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <form>
            <div class="form-group row">
              <label for="" class="col-sm-2 form-control-label">Country</label>
              <div class="col-sm-10">
                <select class="form-control selectpicker" id="select-country" data-live-search="true">
                    <option data-tokens="china">China</option>
                    <option data-tokens="malayasia">Malayasia</option>
                    <option data-tokens="singapore">Singapore</option>
                </select>

              </div>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->
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

$("#")
</script>
