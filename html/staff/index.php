<?php
$title = "Stock Levels";

include('../../include/wrapperstart.php');
?>

<p>Display stock levels here (default/main page).</p>
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
$sql = "SELECT * FROM `Shoe`";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<br> id: ". $row["id"]. " - quantity: ". $row["quantity"]. " - shoe name: ". $row["shoe_name"]. " - size: ". $row["size"]. " - color: ". $row["color"]. " - price " . $row["price"] . "<br>";
		 
     }
} else {
     echo "0 results";
}

//$conn->close();
?>  

<?php
include('../../include/wrapperend.php');
?>