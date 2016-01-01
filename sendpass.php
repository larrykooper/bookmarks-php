<?php
session_start();
//---------------------------------------------------------------------------------------
function GetRndPassw ()
{
	$Pword = "";
	for ($i=1; $i <= 6; $i++)
	{
		$myLtr = chr(rand(97, 122));
		$Pword = $Pword . $myLtr;
	}
	return $Pword;
}
//End Function GetRndPassw
//---------------------------------------------------------------------------------------

ini_set("sendmail_path", "/usr/sbin/sendmail -t -i");
$frmUserid=$_POST['userid'];
require_once( 'db_con.php' );
// Reset the user's password to 6 random letters and email it to them
$query = "SELECT EmailAddress FROM User WHERE UserID='$frmUserid'";
$result = mysql_query($query) or die (mysql_error()."<br />Couldn't execute query: $query");
if (mysql_num_rows($result) > 0 )
{
	// User is found in database
	$BodyText = "An email has been sent to the email address you gave us when you registered.";
	$rowA = mysql_fetch_array($result);
	$UserEmail = $rowA['EmailAddress'];
	$toaddress=$UserEmail;
	$subject='Your Bookmarks Password';
	$newpass = GetRndPassw();
	$mailcontent='Your password has been reset to: ' .$newpass."\r\n";
	$mailcontent .='
	<html>
	<body>
	<p>
	To log-in go to <a href="http://marybeth.nyc/bookmarks/userlogin.php">Bookmarks, LarryBeth Style</a></p>
	</body>
	</html>
	';

  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'From: Bookmarks LarryBeth Style[bookmarks-comments@larrybeth.com]'. "\r\n";

	mail($toaddress, $subject, $mailcontent, $headers);
	// Change user's passwd in database
	$myUpStmt = "UPDATE User SET Password = PASSWORD('$newpass') WHERE UserID = '$frmUserid'";
	$result5 = mysql_query($myUpStmt) or die (mysql_error()."<br />Couldn't execute query: &myUpStmt");

}
else
{
	$BodyText = "Sorry, your username was not found.";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LarryBeth Forgotten Password Page</title>
<link rel="stylesheet" type="text/css" href="bkm.css">
</head>
<body>
<?php
include('header.inc');
?>
<div class='LBBRight'></div>
<div class="LBBMain">
<p>
<?php
print $BodyText;
?>
</p>
</div>
</body>
</html>
