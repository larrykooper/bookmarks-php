<?php 
session_start();
require('const1.php');
if (isset ($_POST['userid']) && isset($_POST['password']))
{
	// If the user has just tried to log in 
	$userid = $_POST['userid'];
	$password = $_POST['password'];		
	$remember = $_POST['remember'];	
	require( 'db_con.php' );		
	if ($userid == 'stormville' || $userid == 'specialk')  // temporary 
	{	
		$query = "SELECT UserID, Password FROM User WHERE UserID='$userid' and Password=PASSWORD('$password')";
		$result = mysql_query($query) or die (mysql_error()."<br />Couldn't execute query: $query");
		if (mysql_num_rows($result) > 0 )
		{
			// If user is found in database, register the user id		
			$_SESSION['valid_user'] = $userid;		
			// If they have asked, set cookie	
			if ($remember == "y")	
			{
				setcookie('uu', $userid, time()+60*60*24*730);  /* expire in 2 years */
				setcookie('pp', $password, time()+60*60*24*730);  /* expire in 2 years */	
			}		
			// redirect 
			$thelocstring = "Location: http://".$sitename."/bookmarks/bookmarks.php?user=".$userid;		
			header ($thelocstring);  
		}	
  }		
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Login</title>
<link rel="stylesheet" type="text/css" href="bkm.css">
</head>
<body>
<?php
include('header.inc');
?>
<div class='LBBRight'></div>
<div class="LBBMain">
<?
if (array_key_exists('valid_user', $_SESSION)) 
{
	echo '<p class="help">Welcome, '.$_SESSION['valid_user'].' </p>';
}
else
{ 
	if (isset($userid))
	{
	// if user has tried and failed to log in 
	echo 'Password/Username invalid, please try again.<br />Click <a class="body" href="forgotpass.php">Forgot your password</a> if you do not know what your password is.<br /><br />';
	}
	else
	{
	// They have not tried to log in yet or have logged out 
	}
	// Put up login form 
	echo '<fieldset class="login">';
	echo '<legend>Log-in to Bookmarks</legend>';
	echo '<form method="post" action="userlogin.php" id="form">';
	echo '<label for="userid">Username:</label><br />';
	echo '<input type="text" size="32" name="userid"><br /><br />';
	echo '<label for="password">Password:</label><br />';
	echo '<input type="password" size="32" name="password"><br /><br />';	
	echo '<input type="checkbox" name="remember" value="y">';
	echo '<label for="remember">Remember my login on this computer</label><br /><br />';	
	echo '<input type="image" src="images/greenbutton.jpg"><br /><br />';
	echo '<a class="body" href="forgotpass.php">Forgot your password?</a>';	
	echo '</form>';
	echo '</fieldset>';
}
?>
</div>
</body>
</html>