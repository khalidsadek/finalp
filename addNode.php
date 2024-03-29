<?php
include "connect.php";
$pageTitle = 'nodes';
session_start();

    if (isset($_POST['submit'])) {

        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
           if ($fileError == 0) {
               if ($fileSize < 10000000 ) { // 1MB = 1,000,000B
                    //$fileNameNew = uniqid('', ture).".".$fileActualExt;//getting unique id for the image in microseconds to prevent overriding on existed image
                    $fileN= $_POST['id'].".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileN;//USING ACTUAL NAME
                    // $fileDestination = 'uploads/'.$fileNameNew;//USING MICROSECONDS NAME
                    move_uploaded_file($fileTmpName, $fileDestination);
                    //header("Location: /finalp/nodes.php");
       ///////////////////////////////////////////////////////////       
       $linename = $_POST['linename'];
       $id = $_POST['id'];
       $info = $fileDestination;

        $_SESSION["id"] = $id;

        $check_stmt = $conn->prepare("SELECT * FROM node WHERE id=?");
        $check_stmt->execute([$id]);
        if($check_stmt->fetch() > 0){
            $name_error = "Sorry... ID already exist";
        }
        else{
            if(is_numeric($id) && is_numeric($linename) && $id != null && $linename != null && $fileName != null){
            $sql = "INSERT INTO node (id,line_name, info) VALUES ('$id','$linename','$info')";
            $conn->exec($sql);
            header("Location: /finalp/nodes.php");
            }else{
                echo "<script>alert('Check your inputs again')</script>";
            }
        }


        /////////////////////////////////////////////////////////////////////////
    } else {
        echo "<script>alert('File is too big')</script>";
      }
    }  else {
       echo "<script>alert('there was an error uploading your file !')</script>";
       //echo "there was an error uploading your file !";
   }  
} else{
    echo "<script>alert('you cannot upload files of this type !')</script>";
    //echo "you cannot upload files of this type !";
}

    }

    if(isset($_POST['submit2'])){
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError == 0) {
                if ($fileSize < 10000000 ) {//500000kb=500mb   my file should be less than 1000000
                    $fileN= $_POST['id'].".".$fileActualExt;//.".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileN;//USING ACTUAL NAME
                    echo "befoooooooreeeee moveeeeeeeeeee addNideee,,";
                    move_uploaded_file($fileTmpName, $fileDestination);
///////////////////////////////////////////////////////////

        $linename = $_POST['linename'];
        $id = $_POST['id'];
        $info = $fileDestination;

        if(is_numeric($id) && is_numeric($linename) && $id != null && $linename != null && $fileName != null){

        $sql2 = "UPDATE node SET id=?, line_name=?, info=? WHERE id=?";
        $conn->prepare($sql2)->execute([$id, $linename, $fileDestination, $id]);
        header("Location: /finalp/nodes.php");

        }else{
            echo "<script>alert('ID should be numeric')</script>";
        }
            /////////////////////////////////////////////////////////////////////////
        } else {
            echo "<script>alert('File is too big')</script>";
          }
        }  else {
           echo "<script>alert('there was an error uploading your file !')</script>";
           //echo "there was an error uploading your file !";
       }  
    } else{
        echo "<script>alert('you cannot upload files of this type !')</script>";
        //echo "you cannot upload files of this type !";
    }
            }
        
    
        
include "navbar.php";
?>
<div class="container py-3">
    <div class="row">
        <div class="mx-auto col-sm-6">
            <!-- form user info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">ADD NODE FORM</h4>
                </div>
                <div class="card-body">
                    <form class="form" role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">NODE ID</label>
                            <div class="col-lg-9">
                                <input required class="form-control" type="text" name="id" value="<?php if(isset($_SESSION["id"])){echo $_SESSION["id"];} ?>">
                                <small style="color:red">
                                    <?php if(isset($name_error)){echo $name_error;}?>
                                </small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Line Number</label>
                            <div class="col-lg-9">
                                <input required class="form-control" type="text" name="linename">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Node Image</label>
                            <div class="col-lg-9">
                                <input required class="form-control" type="file" name="file">
                            </div>
                        </div>
                            <label class="col-lg-3 col-form-label form-control-label"></label>
<!--                            <div class="col-lg-9">-->
                                <?php if(isset($_SESSION["id"]) && is_numeric($_SESSION["id"])){
                                    echo '<button type="submit" name="submit2" class="btn btn-primary btn-block">Override</button>';
                                    echo '<a href="/finalp/addNode.php" type="button" class="btn btn-danger btn-block">Return back</a>';
                                    session_unset();
                                }
                                else{
                                    echo '<button type="submit" name="submit" class="btn btn-primary btn-block">ADD</button>';
                                    }
                                ?>

<!--                            </div>-->
<!--                        </div>-->
                    </form>
                </div>
            </div>
            <!-- /form user info -->
        </div>
    </div>
</div>
