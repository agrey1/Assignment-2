<?php

//Relative pathing to support multiple platforms/OS
require_once('../include/User.php');
require_once('../include/connect.php');
$mysqli = mysqlConnect();

$user = new User($mysqli);


try
{
	$user->register("david@test.com", "some_password", "customer");
}
catch(Exception $e)
{
	die($e->getMessage());
}


/*
try
{
	$user->login("david@test.com", "some_password");
}
catch(Exception $e)
{
	die($e->getMessage());
}
*/

echo $user->isLoggedIn();

?>