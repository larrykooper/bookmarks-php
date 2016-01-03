<?php
session_start();
require('ckuser.php');
if ($validated)
{
// global variables

$frmFullname = "";
$frmOldPassword = "";
$frmNewPassword = "";
$frmNewPassword2 = "";
$frmEmail = "";
// ----------------------------------------------------------------------------------------
function show_form($errors = '')
{
	global $theusername, $frmFullname, $frmOldPassword, $frmNewPassword, $frmNewPassword2, $frmEmail;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Edit My Profile</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>

<body>
<?php
include('headerlogged.inc');
?>
<div class='LBBRight'></div>
<div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername.'.  ';
?>
<?php

	if ($errors)
	{
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
	}
?>


<fieldset>
<legend>Update your profile</legend>
<form method=post action="editprofile.php" id="form1">
<label for="user_fullname">Full name:</label><br />
<input type="text" size="32" name="user_fullname" value="<?php echo $frmFullname ?>"> Optional<br /><br />

<label for="email">Email:</label><br />
<input type="text" size="32" name="email" value="<?php echo $frmEmail ?>"> Optional, will be used to send you your password.<br /><br />
<input type=submit class="push" name="sub_btn1" value="update my profile">
<input type="hidden" name="nameform_submitted" value="1">
</form>
<form method=post action="editprofile.php" id="form2">
<label for="oldpassword">Old Password:</label><br />
<input type="password" size="32" name="oldpassword" value="<?php echo $frmOldPassword ?>"> Required<br /><br />

<label for="newpassword">New Password:</label><br />
<input type="password" size="32" name="newpassword" value="<?php echo $frmNewPassword ?>"> Required<br /><br />
<label for="newpassword2">Retype new password:</label><br />
<input type="password" size="32" name="newpassword2" value="<?php echo $frmNewPassword2 ?>"> Required<br /><br />

<input type=submit class="push" name="sub_btn2" value="change password"><br />
<input type="hidden" name="passform_submitted" value="1">
</form>
</fieldset>

<?php
}// end function show_form
// ----------------------------------------------------------------------------------------
function validate_nameform()
{
	global  $frmFullname, $frmEmail;
    $errors = array();

	$frmFullname = $_POST['user_fullname'];
	$frmEmail = $_POST['email'];

    return $errors;
} // end function validate_nameform
// -----------------------------------------------------------------------------------------
function validate_passform()
{
	global   $frmOldPassword, $frmNewPassword, $frmNewPassword2, $theusername;
    $errors = array();

	$frmOldPassword = $_POST['oldpassword'];
	$frmNewPassword = $_POST['newpassword'];
	$frmNewPassword2 = $_POST['newpassword2'];

	if (strlen($frmOldPassword) == 0)
		$errors[] = 'Old password is required.';
	if (strlen($frmNewPassword) == 0)
		$errors[] = 'Password is required.';
	if (strlen($frmNewPassword) > 10)
		$errors[] = 'Password cannot be longer than 10 characters.';
	if (strlen($frmNewPassword) < 6)
		$errors[] = 'Password cannot be shorter than 6 characters.';
	if (!ereg('^[a-zA-Z0-9]+$', $frmNewPassword))
		$errors[] = 'Password may only contain letters and numbers.';
	if ($frmNewPassword <> $frmNewPassword2)
		$errors[] = 'Password confirmation does not match password.';
	require_once('db_con.php');
	$UNquery = "SELECT UserID FROM User WHERE UserID='$theusername' and Password=PASSWORD('$frmOldPassword')";
	$UNresult = mysql_query($UNquery) or die (mysql_error()."<br />Couldn't execute query: $UNquery");
	if (mysql_num_rows($UNresult) == 0 )
		$errors[] = 'Old password is incorrect.';

    return $errors;
} // end function validate_passform
// ---------------------------------------------------------------------------------------
function disp_pageheader()
{
	global $theusername;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Edit My Profile</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body>
<?php
include('headerlogged.inc');
?>
<div class="LBBRight">
<div class="LBBRightTitle"></div>
</div>
<div class="LBBMain">
<?php
echo '<p class="help">Welcome, '.$theusername.'. ';
print '</p>';
}
// end function disp_pageheader

// ---------------------------------------------------------------------------------------
function process_nameform()
{
	global  $theusername, $frmFullname, $frmEmail;
	require_once('db_con.php');

	// Update the database

	$myUpStmt = "UPDATE User SET EmailAddress = '$frmEmail', FullName = '$frmFullname' WHERE UserID = '$theusername'";
	$result5 = mysql_query($myUpStmt) or die (mysql_error()."<br />Couldn't execute query: &myUpStmt");
	disp_pageheader();
	print "Your information has been updated. <br>";
}
// end function process_nameform
// -----------------------------------------------------------------------------------------
function process_passform()
{
	global  $theusername, $frmOldPassword , $frmNewPassword, $frmNewPassword2;
	require_once('db_con.php');
	//  Update the database
	$myUpStmt = "UPDATE User SET Password = PASSWORD('$frmNewPassword') WHERE UserID = '$theusername'";
	$result5 = mysql_query($myUpStmt) or die (mysql_error()."<br />Couldn't execute query: &myUpStmt");

	// Set persistent cookie

	setcookie('pp', $frmNewPassword, time()+60*60*24*730);  /* expire in 2 years */
	disp_pageheader();
	print "Your password has been updated.<br>";
}
// end function process_passform

// -----------------------------------------------------------------------------------------
?>
<?php
if ($_POST['nameform_submitted'])
{
	$form_errors = validate_nameform();
    if ($form_errors)
	{
        show_form($form_errors, $frmUsername, $frmFullname, $frmPassword, $frmPassword2, $frmEmail);
    }
	else
	{
        // The submitted data is valid, so process it
        process_nameform();
    }
}
elseif ($_POST['passform_submitted'])
	{

		$form_errors = validate_passform();
	    if ($form_errors)
		{
	        show_form($form_errors, $frmUsername, $frmFullname, $frmPassword, $frmPassword2, $frmEmail);
	    }
		else
		{
	        // The submitted data is valid, so process it
	        process_passform();
	    }

	}
else
	{

	    // The form wasn't submitted, so display
		// Read from the database
		require_once( 'db_con.php' );
		$UserQuery = "SELECT EmailAddress, FullName FROM User WHERE UserID='$theusername'";
		$UserResult = mysql_query($UserQuery) or die (mysql_error()."<br />Couldn't execute query: $UserQuery");
		$row = mysql_fetch_array($UserResult);
		$frmEmail = $row['EmailAddress'];
		$frmFullname = $row['FullName'];
		// Display the form

	    show_form("");
	}
?>
</div>
</body>
</html>
<?php
// ----------------------------------------------------------------------------------------
// This is what happens if the username is not recognized
}
else
{
	require('bkbottom.php');
}
?>
