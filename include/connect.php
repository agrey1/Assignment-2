<?php

function mysqlConnect()
{
	$mysqli = new mysqli('silva.computing.dundee.ac.uk', 'alexandergrey', '2015computing.mysql');
	
	if($mysqli->connect_error)
	{
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	return $mysqli;
}

?>