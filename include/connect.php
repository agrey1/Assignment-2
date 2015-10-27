<?php

function mysqlConnect()
{
	//$mysqli = new mysqli('localhost', 'root', 'YOUR_MYSQL_PASSWORD', 'FootWearShop'); //Connect and select 'FootWearShop' database
	$mysqli = new mysqli('localhost', 'root', 'VK5Evy3KyAREAV59', 'FootWearShop'); //Connect and select 'FootWearShop' database
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	return $mysqli;
}

?>