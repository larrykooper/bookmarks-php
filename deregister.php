<?php
session_start();
require('ckuser.php');
require('const1.php');
if ($validated)
{

//--------------------------------
function verify_pw()
{
	global $theusername;
	$frmPW = $_POST['password'];
	require_once('db_con.php');
	$UNquery = "SELECT UserID FROM User WHERE UserID='$theusername' and Password=PASSWORD('$frmPW')";
	$UNresult = mysql_query($UNquery) or die (mysql_error()."<br />Couldn't execute query: $UNquery");
	if (mysql_num_rows($UNresult) == 0 )
		return 0;
	else
		return 1;
}
//---------------------------------------
function process_deletion()
{
	global $theusername;
	$myDelStmt1 = "DELETE FROM UserVisit WHERE UserID = '$theusername'";
	$result6 = mysql_query($myDelStmt1) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt1");

	$myDelStmt2 = "DELETE FROM UserSite WHERE UserID = '$theusername'";
	$result7 = mysql_query($myDelStmt2) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt2");

	$myDelStmt3 = "DELETE FROM UserSiteTag WHERE UserID = '$theusername'";
	$result8 = mysql_query($myDelStmt3) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt3");

	$myDelStmt4 = "DELETE FROM User WHERE UserID = '$theusername'";
	$result9 = mysql_query($myDelStmt4) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt4");
	print "Your information has been deleted.";
}

//-------------------------------------------

	if ($_POST['submitted'])
	{
		if ($_POST['no_btn'] == "return to my bookmarks")
		{
			$thelocstring = "Location: http://".$sitename."/bookmarks/bookmarks.php";
			header ($thelocstring);
		}
		elseif ($_POST['yes_btn'] == "delete my account")
			{
				$pw_verified = verify_pw();
				if ($pw_verified)
				 	process_deletion();
				else
				{
					$thelocstring = "Location: http://".$sitename."/bookmarks/userlogin.php";
					header ($thelocstring);
				}
			}
	}
	else
// form has not been submitted
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/bkm.css">
<title>Bookmarks Deregister</title>
</head>
<body>
<?php
include('templates/headerlogged.php');
?>
<div class="LBBRight"><div class='LBBRightTitle'></div></div>
<div class="LBBMain">
<?php
echo '<p class="help">Welcome, '.$theusername.' </p>';
?>
<fieldset class="main">
<legend>Deleting your account</legend>
<p>Once you delete your account, your user name and password will no longer be valid on this site. In addition, your saved bookmarks and browsing history will be removed from this site.<br><br>

Do you wish to continue and have your information deleted?</p>

If so, please enter your password.<br />
<form method=post action="deregister.php" id="form1">
<label for="password">Password:</label>
<input type="password" size="32" name="password"><br /><br />
<input type="hidden" name="submitted" value="1">
Yes
<input type=submit name="yes_btn" value="delete my account">
No
<input type=submit name="no_btn" value="return to my bookmarks">
</form>
</fieldset>
</div>
</body>
</html>
<?php
} // end - not submitted
// ----------------------------------------------------------------------------------------
}
else
	// This is what happens if the username is not recognized
{
	require('bkbottom.php');
}
?>

