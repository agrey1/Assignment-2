<?php

function mysqlConnect()
{
	$mysqli = new mysqli('localhost', 'root', 'YOUR_MYSQL_PASSWORD'); //Connect without selecting a database
	
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	return $mysqli;
}

?>