<?php 
/*
require_once('../../include/connect.php');
$mysqli = mysqlConnect();
*/
require_once('../../include/connect.php');
$mysqli = mysqlConnect();

//$id = $_POST['id'];

$id = $mysqli->escape_string($_POST['id']);

$quantity = $mysqli->escape_string($_POST['quantity']);



$sqlupdate = "UPDATE `Shoe` SET quantity='$quantity' WHERE id='$id'";
$mysqli->query($sqlupdate);

header ('Location: index.php');

?>