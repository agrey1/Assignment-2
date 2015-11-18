



<?php 
/*
require_once('../../include/connect.php');
$mysqli = mysqlConnect();
*/

require_once('../../include/connect.php');
$mysqli = mysqlConnect();

$id = $_POST['id'];

$status = $mysqli->escape_string($_POST['status']);

$placed = $mysqli->escape_string($_POST['placed']);

$dispatched = $mysqli->escape_string($_POST['dispatched']);

$placed = date ($placed);

$dispatched = date ($dispatched);    

$sqlupdate = "UPDATE `Order` SET date_placed='$placed', date_dispatched='$dispatched', status='$status' WHERE id='$id'";

$mysqli->query($sqlupdate);

header ('Location: orders.php');

?>