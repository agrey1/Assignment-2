<?php 

require_once('../../include/connect.php');
$mysqli = mysqlConnect();

/*
$mysqli = new mysqli('localhost', 'root', '', 'FootWearShop'); //Connect and select 'FootWearShop' database
if($mysqli->connect_error)
{
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
*/
	
	$name = $_POST['shoe_name'];
	$size = $_POST['size'];
	$color = $_POST['color'];
	$price = $_POST['price'];
	$supplier_id = $_POST['supplier_id'];
	$Url = "img/" . $_FILES["file"]["name"];
	
	$sql1 = "INSERT INTO `Shoe_supplier` (`shoe_id`, `supplier_id`) VALUES (LAST_INSERT_ID(), '$supplier_id');";
	$sql2 = "INSERT INTO `Shoe` (`shoe_name`, `size`, `color`, `quantity`, `price`, `image_url`) VALUES ('$name ', '$size', '$color', '0', '$price', '$Url');";
	
	$result2 = $mysqli->query($sql2);
	$result1 = $mysqli->query($sql1);
	
	header ('Location: index.php');
echo '<pre>';
if (move_uploaded_file($_FILES["file"]["tmp_name"], $Url)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";

      
	

?>