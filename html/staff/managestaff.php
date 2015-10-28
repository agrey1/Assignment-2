<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 4)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Manage Staff";

include('../../include/wrapperstart.php');
?>

<p>This page will allow admins to view and edit staff.</p>

<?php
include('../../include/wrapperend.php');
?>