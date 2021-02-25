<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db";
// Create connection

function connect()
{
  $conn = new mysqli("localhost", "root", "","db5");
  // Check connection
  if ($conn->connect_error) {

  die("Connection failed: " . $conn->connect_error);
}

return $conn;
}


function searchName($name)
{
   $conn=connect();
   $inpText = $name;
   $sql = "SELECT * FROM `pin` WHERE `name` LIKE '%$name%'";

    $result= $conn->query($sql);

   if ($result->num_rows>0) {

     while ($row = $result->fetch_assoc()) {
      echo '<a href="#" class="list-group-item list-group-item-action border-1">'.$row['name'].'</a>';
    //    echo $row['name'];
     }
   } else {
     echo '<p class="list-group-item border-1">No Record</p>';
    //   echo "No Record";
   }

//    if ($result) {
//   foreach ($result as $row) {
//     echo '<a href="#" class="list-group-item list-group-item-action border-1">'.$row['name'].'</a>';
//   }
// } else {
//   echo '<p class="list-group-item border-1">No Record</p>';
// }
  }



  function getNode($name)
  {

    try{
      $conn=connect();
      $sql = "SELECT `nodeID` FROM pin WHERE name='$name'";
      $result = $conn->query($sql);
      $row= $result->fetch_assoc();

       return $row['nodeID'];
      } catch(Exception $e){
        echo $e->getMessage();
      }

  }

  function getNodePath($nodeId1)//image path
  {
      $conn=connect();
      $sql = "SELECT `info` FROM node WHERE id='$nodeId1'";
      $result = $conn->query($sql);

        $result= $result->fetch_assoc();

        return $result['info'];
  }






function getHotSpots($num)
{

    $spots='';
    $conn=connect();
    $sql = "SELECT * FROM hotspot where id1='$num'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id=$row["id2"];
      $pitch=$row["pitch"];
      $yaw=$row["yaw"];
      //$spots.='{"id":'.$id.',"pitch":'.$pitch.',"yaw":'.$yaw.',"clickHandlerArgs":'.$id.'}*';
    //  $spots.=`{"id":`.$id.`,"pitch":`.$pitch.`,"yaw":`.$yaw.`,"clickHandlerArgs":`.$id.`}*`;
      // echo $row["info"];
      $spots.='{"id":'.$id.',"pitch":'.$pitch.',"yaw":'.$yaw.',"clickHandlerArgs":'.$id.'}*';

    }
}


$sql1 = "SELECT * FROM pin where nodeID='$num'";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
// output data of each row
while($row1 = $result1->fetch_assoc()) {
  $id=$row1["id"];
  $line=$row1["lineNum"];
  $name=$row1["name"];
  $name = str_replace('"', '', $name);
  $pitch=$row1["pitch"];
  $yaw=$row1["yaw"];
  // $spots.='{"id":'.$id.',"pitch":'.$pitch.',"yaw":'.$yaw.',"clickHandlerArgs":'.$id.'}*';
 // $spots.=`{"id":`.$id.`,"line":`.$line.`,"name":`.$name.`,"pitch":`.$pitch.`,"yaw":`.$yaw.`}*`;
// $spots.='{"id":'.$id.',"line":'.$line.',"name":'.$name.',"pitch":'.$pitch.',"yaw":'.$yaw.'}*';
 // echo $row["info"];
 $spots.='{"id":'.$id.',"line":'.$line.',"name":"'.$name.'","pitch":'.$pitch.',"yaw":'.$yaw.'}*';
}
}

// echo $spots;
return $spots;
}



function getJsonFormat()
{

  $conn=connect();
  $sql = "SELECT `id1`, `id2`,`weight` FROM `hotspot` ORDER BY `hotspot`.`id1` ASC";
  $return_arr = array();
  $result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)){
    $id1 = $row["id1"];
    $id2 = $row["id2"];
    $w=$row["weight"];

    $return_arr[] = array("id1" => $id1,
                    "id2" => $id2,
                    "weight"=>$w);
}
// Encoding array in JSON format
// echo json_encode($return_arr);
return $return_arr;
}




