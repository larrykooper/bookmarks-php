<?php
session_start();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Log-In</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body>
<?php
include('templates/header.php');
?>
<div class='LBBRight'>
</div>
<div class="LBBMain">
<?php
	echo '<fieldset class="login">';
	echo '<legend>Forgot Your Password?</legend>';
	echo '<form method="post" action="sendpass.php" id="form">';
	echo '<label for="userid">Username:</label><br />';
	echo '<input type="text" size="32" name="userid"><br /><br />';
	echo '<input type="image" src="images/submitorng.jpg"><br /><br />';
	echo '</form>';
	echo '</fieldset>';
?>
</div>
</body>
</html>