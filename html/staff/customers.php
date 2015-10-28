<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Customers";

include('../../include/wrapperstart.php');
?>

<p>Allow admins and managers to make changes to customer accounts. (View, delete, edit)</p>

<?php
include('../../include/wrapperend.php');
?>