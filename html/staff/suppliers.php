<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}
$title = "Suppliers";

include('../../include/wrapperstart.php');
?>

<p>Allow admins and managers to view, edit and add supplier information.</p>

<?php
include('../../include/wrapperend.php');
?>