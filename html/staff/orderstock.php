<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}

$title = "Order Stock";

include('../../include/wrapperstart.php');
?>

<p>Allow managers and admins to order stock from our suppliers.</p>

<?php
include('../../include/wrapperend.php');
?>