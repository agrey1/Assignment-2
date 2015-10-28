<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 4)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Add Staff";

include('../../include/wrapperstart.php');
?>

<p>This page will allow admins to add staff.</p>

<?php
include('../../include/wrapperend.php');
?>