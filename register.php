<?php
// global variables

$frmUsername = "";
$frmFullname = "";
$frmPassword = "";
$frmPassword2 = "";
$frmEmail = "";


function show_form($errors = '')
{
	global  $frmUsername, $frmFullname, $frmPassword, $frmPassword2, $frmEmail;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Register</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body>
<?php
include('header.inc');
?>
<div class='LBBRight'></div>
<div class="LBBMain">
<?php

	if ($errors)
	{
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
	}
?>
<fieldset class="chg">
<legend>Register to post on Bookmarks</legend>
<br/><br/>
We're sorry! Registration has been disabled temporarily! Please visit us again.


</fieldset>

<?php
}// end function show_form
// ------------------------------------------------------------------------------------------------
function validate_form()
{
	global  $frmUsername, $frmFullname, $frmPassword, $frmPassword2, $frmEmail;
    $errors = array();
	$frmUsername = $_POST['user_name'];
	$frmFullname = $_POST['user_fullname'];
	$frmPassword = $_POST['password'];
	$frmPassword2 = $_POST['password2'];
	$frmEmail = $_POST['email'];

	if (strlen($frmUsername) == 0)
		$errors[] = 'Username is required.';
	if (strlen($frmPassword) == 0)
		$errors[] = 'Password is required.';
	if (strlen($frmUsername) > 16)
		$errors[] = 'Username cannot be longer than 16 characters.';
	if (!ereg('^[a-zA-Z0-9]+$', $frmUsername))
		$errors[] = 'Username may only contain letters and numbers.';
	if (strlen($frmPassword) > 10)
		$errors[] = 'Password cannot be longer than 10 characters.';
	if (strlen($frmPassword) < 6)
		$errors[] = 'Password cannot be shorter than 6 characters.';
	if (!ereg('^[a-zA-Z0-9]+$', $frmPassword))
		$errors[] = 'Password may only contain letters and numbers.';
	if ($frmPassword <> $frmPassword2)
		$errors[] = 'Password confirmation does not match password.';
	// See if username is taken
	require_once('db_con.php');
	$myQ1 = "SELECT UserID FROM User WHERE UserID = '" .$frmUsername. "'";
	$res1 = mysql_query($myQ1) or die (mysql_error()."<br />Couldn't execute query: &myQ1");
	if (mysql_num_rows($res1)>0)
		$errors[] = 'That username is already taken.';

    return $errors;
} // end function validate_form
// -----------------------------------------------------------------------------------------
//function process_form()
//{
//	global  $frmUsername, $frmFullname, $frmPassword, $frmPassword2, $frmEmail;
//	require_once('db_con.php');

	// Add user to database
//	$myInsStmt = "INSERT INTO User (UserID, Password, EmailAddress, FullName) VALUES ('" . $frmUsername . "', PASSWORD('" . $frmPassword. "'),'" . $frmEmail . "', '" . $frmFullname ."')";
//	$result5 = mysql_query($myInsStmt) or die (mysql_error()."<br />Couldn't execute query: &myInsStmt");
	// Register session variable
//	$_SESSION['valid_user'] = $frmUsername;
	// Set persistent cookie
//	setcookie('uu', $frmUsername, time()+60*60*24*730);  /* expire in 2 years */
//	setcookie('pp', $frmPassword, time()+60*60*24*730);  /* expire in 2 years */
	?>

<?php
if ($_POST['submitted'])
{
	$form_errors = validate_form();
    if ($form_errors)
	{
        show_form($form_errors);
    }
	else
	{
        // The submitted data is valid, so process it
        process_form();
    }
}
else
{
    // The form wasn't submitted, so display
    show_form("");
}
?>
</div>
</body>
</html>
