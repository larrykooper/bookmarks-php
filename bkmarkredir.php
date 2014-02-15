<?php
session_start();
require_once('ckuser.php');
$URLID = $_GET['snum'];
// Open connection to database 
require_once( 'db_con.php' );
// Look up the site URL so we can redirect to it 
$MyQuery = "Select URL FROM URL Where URLID =" . $URLID; 
$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");
$row = mysql_fetch_array($result);
$TheURL = $row['URL'];
$thelocstring = "Location: $TheURL";
if ($validated)
{	
	$theusername = $_SESSION['valid_user'];
	$sel_query = "SELECT UserSiteID FROM UserSite WHERE UserID = '$theusername' AND URLID = $URLID";
	$s_result = mysql_query($sel_query) or die (mysql_error()."<br />Couldn't execute query: $sel_query");
	$num_results = mysql_num_rows($s_result);
	if ($num_results > 0)
	{
		$insert_query = "INSERT INTO UserVisit (UserID, VisitDateTime, URLID) VALUES ('$theusername', NOW(), $URLID)";
		$result = mysql_query($insert_query)or die (mysql_error()."<br />Couldn't execute query: $insert_query");
	}
}
header ($thelocstring);
exit();

?>

