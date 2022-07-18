<?php
include ('../conn.php');



  function filtered($data){
$conn = $GLOBALS['conn'];

if($data == ""){
$sql = "SELECT * FROM 'tbluseraccounts' ORDER BY 'ID' DESC;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {

echo " <tr>
                <td>".$row['ID']."</td>
                <td>".$row['USERNAME']."</td>
                <td>".$row['ACTIVITY_LOGIN']."</td>
                <td>".$row['ACTIVITY_LOGOUT']."</td>
                <td>".$row['UROLE']."</td>
            </tr>";

  }

} else {
echo "No data Found";
}
}else{
$sql = "SELECT * FROM tbluseraccounts WHERE 'UROLE' = '".$data."' ORDER BY ID DESC;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each ro
  while($row = mysqli_fetch_assoc($result)) {

echo " <tr>
                <td>".$row['ID']."</td>
                <td>".$row['USERNAME']."</td>
                <td>".$row['ACTIVITY_LOGIN']."</td>
                <td>".$row['ACTIVITY_LOGOUT']."</td>
                <td>".$row['UROLE']."</td>
            </tr>";

  }

} else {
echo "No data Found";
}
}
}
?>



