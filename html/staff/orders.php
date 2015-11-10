<?php

$title = "Customer Orders";

include('../../include/wrapperstart.php');
?>

<p>Allow all staff to view, delete and edit orders. (Orders that the customers have placed)</p>

<?php
/*
$servername = "localhost";
$username = "username";
$password = "";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
*/
$sql = "SELECT * FROM `Order`";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
          echo "<br> id: ". $row["id"]. " - date placed: ". $row["date_placed"]. " - date dispatched " . $row["date_dispatched"] . "<br>";
		  ?>		  
		  <a href="Delete_order.php?id=<?php echo $row["id"]; ?>">Delete order</a><br>
		  
		  <?php
		  $shoeid=$row["id"];
		  $sql2 = "SELECT * FROM `Order_shoe` WHERE `order_id` = '$shoeid'";
          $result2 = $mysqli->query($sql2);
		  
		  if ($result->num_rows > 0) {
                // output data of each row
                while($row2 = $result2->fetch_assoc()) {
                      echo "<br> id: ". $row2["id"]. " - shoe id: ". $row2["shoe_id"]. "<br>";
				}
		  }
     }
} else {
     echo "0 results";
}

//$conn->close();
?>  


<?php
include('../../include/wrapperend.php');
?>