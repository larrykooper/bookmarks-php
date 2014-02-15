<?php
session_start();
require('ckuser.php');
require('const1.php');
require_once( 'db_con.php' );
// vnsinro.php
// Visit next site in rotation 
// You must be a registered, signed-in user 
if ($validated) 
{
	// Get user name
	$theusername = $_SESSION['valid_user'];
	$MyQuery = "SELECT UserSite.URLID, Max(UserVisit.VisitDateTime) AS TheTime FROM UserSite LEFT JOIN UserVisit ON (UserSite.URLID = UserVisit.URLID) AND (UserSite.UserID = UserVisit.UserID) WHERE (UserSite.InRotation)=1 AND UserSite.UserID = '$theusername' GROUP BY UserSite.URLID ORDER BY TheTime";
	$MyResult = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery"); 
	$MyNum_results = mysql_num_rows($MyResult);
	if ($MyNum_results > 0)
	{
		$MyRow = mysql_fetch_array($MyResult);
		$MyURLID = $MyRow['URLID'];
		$MyQuery2 = "SELECT URL	FROM URL WHERE URLID = $MyURLID";
		$MyResult2 = mysql_query($MyQuery2) or die (mysql_error()."<br />Couldn't execute query: $MyQuery2");
		$MyRow2 = mysql_fetch_array($MyResult2);
		$TheURL = $MyRow2['URL'];
		$thelocstring = "Location: $TheURL";
		// Log the visit in the database 
		$insert_query = "INSERT INTO UserVisit (UserID, VisitDateTime, URLID) VALUES ('$theusername', NOW(), $MyURLID)";
		$resultK = mysql_query($insert_query)or die (mysql_error()."<br />Couldn't execute query: $insert_query");
		// Redirect to it 
		header ($thelocstring);
		exit();
	}
	else 
	{
	// User has not posted any sites in rotation 
$myheader = <<< End_Of_Header
	<html>
	<head>
	<title>Bookmarks</title>
	<link rel="stylesheet" type="text/css" href="bkm.css">
	</head>
	<body>
End_Of_Header;
	print $myheader;	
	include('headerlogged.inc');
$mymessage = <<< End_Of_MyMess
	<br />You have not yet posted any sites in rotation. 
  To do so, click on <a href="bookpost.php" class="body">Post a site</a> and check the box for In Rotation. 
End_Of_MyMess;
	print $mymessage;	
	}
	// ----------------------------------------------------------------------------------------	
} 
else
	// This is what happens if the username is not recognized
	// not validated
	{
	require('bkbottom.php');
	}
?>