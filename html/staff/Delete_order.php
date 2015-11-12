<?php 

$mysqli = new mysqli('localhost', 'root', '', 'FootWearShop'); //Connect and select 'FootWearShop' database
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	


	$id = $mysqli->escape_string($_GET['id']);
	$sql1 = "DELETE FROM `order_shoe` WHERE order_id='$id'";
     $sql2 = "DELETE FROM `order` WHERE id='$id'";
     $result2 = $mysqli->query($sql1);
	 $result2 = $mysqli->query($sql2);
	
	header ('Location: orders.php');

?>