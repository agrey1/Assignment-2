<?php

session_start();
$_SESSION = array();
session_destroy();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="refresh" content="2;url=/staff" />
        <title>FootWear - Logout</title>
    </head>
    <body>
        <p>You have been logged out. Click <a href="/staff">here</a> to return to the home page.</p>
		<i>You will be redirected automatically...</i>
    </body>
</html>