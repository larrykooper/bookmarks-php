<?php
session_start();
require('ckuser.php');
?>
<html>
<head>
<?php
require('db_con.php');
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="keywords" content="bookmarks, tags, LarryBeth, Larry Kooper, Mary Beth Kooper" />
<title>LarryBeth Bookmarks</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css" />
</head>
<body>
<?php
If ($validated)
{
include('headerlogged.inc');
}
else
{
include('header.inc');
}
// Display tags that are most active recently
?>
<div class="LBBRight">
<div class="LBBRightTitle">Active recently</div>
<?php
// ----------------------------------------------------------------------------------
// Get last 100 postings
$MyQuery = "CREATE TEMPORARY TABLE TheTT SELECT UserID, SiteDescr, URLID, ExtendedDesc, OrigPostingTime FROM UserSite WHERE (Private IS NULL OR Private <> 1) ORDER BY OrigPostingTime DESC LIMIT 100";


$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");

$queryRecentActive = "SELECT Tag, COUNT(*) AS Myct FROM UserSiteTag ust INNER JOIN TheTT tt ON ((tt.UserID = ust.UserID) AND (tt.URLID = ust.URLID)) GROUP BY Tag  ORDER BY Myct DESC ";

$resultCT = mysql_query($queryRecentActive) or die (mysql_error()."<br />Couldn't execute query: $queryRecentActive");
$num_CT = mysql_num_rows($resultCT);
for ($i=0; $i <$num_CT; $i++)
{
	$rowCT = mysql_fetch_array($resultCT);
	$TheCount = $rowCT['Myct'];
	$TheTag = $rowCT['Tag'];
	print "<div><span class=\"LBBNum\">";
	print $TheCount;
	print "</span><a href=\"tag.php?tags=";
	print $TheTag;
	print "\" class=\"right\">";
	print $TheTag;
	print "</a></div>";
}
print "</div>";
// End of displaying recently active
// ----------------------------------------------------------------------------------
// Display main contents
print "<div class=\"LBBMain\">";
if (array_key_exists('valid_user', $_SESSION))
{
$theusername = $_SESSION['valid_user'];
echo '<p class="help">Welcome, '.$theusername.' </p>';
}

$MyCQ = "SELECT UserID, SiteDescr, URLID, ExtendedDesc, DATE_FORMAT( OrigPostingTime, '%Y-%m-%d %H:%i' ) AS PostTime FROM TheTT ORDER BY OrigPostingTime DESC";
$resultCQ = mysql_query($MyCQ) or die (mysql_error()."<br />Couldn't execute query: $MyCQ");
$num_results = mysql_num_rows($resultCQ);

If (!$validated)
{
?>
<p class="help">Welcome to Bookmarks, LarryBeth Style! </p>

<p>Once you have registered, Bookmarks LarryBeth Style allows you to post your favorite sites (bookmarks) and view them from any web browser.
You can also view other users' bookmarks and see who is interested in the same sites.
You can label your bookmarks with tags (keywords) and view them by tag.</p>

Bookmarks LarryBeth Style also allows you to keep track of when you visit your favorite sites!  (See our strict <a href="privacy.php" class="body">privacy policy</a>).

You can view your bookmarks by time posted, by name, by time last visited, or by count of visits.<br>
<?php
}
?>
<br>Recently posted sites:<br>
<table border="0">
<tr><th class="thome">Name</th>
<th class="thomert">Posting Date</th></tr>
<?php

for ($i=0; $i <$num_results; $i++)
{
// Display one bookmark
	$row = mysql_fetch_array($resultCQ);
	$myUserID = $row['UserID'];
	$myName = $row['SiteDescr'];
	$myExtended = $row['ExtendedDesc'];
	$myOrigDate = $row['PostTime'];
	$myURLID = $row['URLID'];
	// Calculate count of other users
	$queryPeople = "SELECT COUNT(*) AS PeopleCt FROM UserSite WHERE URLID = " . $myURLID;
	$resPeople = mysql_query($queryPeople) or die (mysql_error()."<br />Couldn't execute query: $queryPeople");
	$rPeople = mysql_fetch_array($resPeople);
	$pCount = $rPeople['PeopleCt'];
	$othcount = $pCount - 1;
	// done with calc count
	print "<tr><td>";
	print "<a href=\"bkmarkredir.php?snum=";
	print $myURLID;
	print "\" target=\"new\" class=\"bodyl\">";
	print stripslashes($myName);
	print "</a></td><td nowrap class=\"rttop\">";
	print $myOrigDate;
	print "</td></tr>";
	// Display Extended
	If (strlen($myExtended) > 0)
	{
		print "<tr><td colspan=\"2\">";
		print stripslashes($myExtended);
		print "</td></tr>";
	}
	// Beginning of code to display tags for one bookmark
	$MyQuery2 = "SELECT Tag FROM UserSiteTag WHERE URLID=" . $myURLID . " AND UserID='". $myUserID ."' ORDER BY TagOrder";
	$result2 = mysql_query($MyQuery2) or die (mysql_error()."<br />Couldn't execute query: $MyQuery2");
	$BMTagString = "";
	$num_results2 = mysql_num_rows($result2);
	for ($j=0; $j <$num_results2; $j++)
	{
		$row2 = mysql_fetch_array($result2);
		$myTag = $row2['Tag'];
		$BMTagString = $BMTagString . "<a class=\"bodym\" href=\"bookmarks.php?user=" . $myUserID . "&tags=". $myTag . "\">";
		$BMTagString = $BMTagString . $myTag . " </a>";
	}
	print "<tr><td class=\"below\">";
	print $BMTagString;
	// end of code to display tags
	print "&nbsp;";
	print "by ";
	print "<a class=\"bodyt\" href=\"bookmarks.php?user=";
	print $myUserID;
	print "\">";
	print $myUserID;
	print "</a>";
	// display 'and 999 other people'
	print "&nbsp;";
	if ($othcount > 0)
	{
		print "<a href=\"urlpost.php?url=";
		print $myURLID;
		print "\" class=\"bodyt\">";
		print "and ";
		print $othcount;
		print " other ";
		if ($othcount > 1)
			print "people";
		else
			print "person";
		print "</a>";
	}
	print "</td>";
	//if ($validated)
	//{
		// display edit this item or copy this item
		if ($myUserID == $theusername)
		{
			// edit
			print "<td class=\"rtside\"><a href=\"bookmarks.php?editsite=";
			print $myURLID;
			print "\" class=\"bodyt\">Edit</a>";
		}
		else
		{
			// copy
			// Get actual URL
			$URLQuery = "Select URL FROM URL Where URLID =" . $myURLID;
			$URLresult = mysql_query($URLQuery) or die (mysql_error()."<br />Couldn't execute query: $URLQuery");
			$Urow = mysql_fetch_array($URLresult);
			$TheURL = $Urow['URL'];
			print "<td class=\"rtside\"><a href=\"bookpost.php?url=";
			print $TheURL;
			print "&title=";
			print $myName;
			print "\" class=\"bodyt\">Copy</a>";
		}
		print " this item</td></tr>";
	//}
} // end for i = 0 to num_results
?>
</table>
</div>
</body>
</html>