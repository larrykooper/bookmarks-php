<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Log-Out</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body>
<?php
include('header.inc');
?>
<div class='LBBRight'></div>
<div class="LBBMain">
<?php
$old_user = $HTTP_SESSION_VARS['valid_user'];
unset($HTTP_SESSION_VARS);
$result_dest = session_destroy();
if (!empty($old_user))
{
	if ($result_dest)
	{
		// if they were logged in and are now logged out
		echo '<p>Logged out.<br /><br />';
		print "Would you like to <a href=\"userlogin.php\" class=\"body\">Log in</a> again?</p>";
	}
	else
	{
		// they were logged in and could not be logged out
		echo 'Could not log you out.<br />';
	}
}
else
{
	// they weren't logged in but came to this page somehow
	echo 'You were not logged in, and so have not been logged out.';
	print "<a href=\"userlogin.php\" class=\"body\"> Log in</a> now to view your bookmarks.";

}
?>
</body>
</html>