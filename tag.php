<?php
session_start();
require('ckuser.php');

// ---------------------------------------------------------------------------------------
function display_pnt()
// Display previous, next, and total
{
	global $MyQS, $start, $perpage, $total_rows;
// display previous / next
// get start out of the querystring
$MyQS = ereg_replace('&start=[0-9]+', '', $MyQS);
$MyQS = ereg_replace('start=[0-9]+', '', $MyQS);
// end of getting start out of the qs
if ($MyQS == '')
	$Delim = '';
else
	$Delim = '&';
// previous
if ($start <> 0)
{
	$newstart = $start - $perpage;
    print '<a href="bookmarks.php?'.$MyQS .$Delim.'start='.$newstart.'" class="rt">< previous</a>';
}
else
{
    print '&nbsp;';
}
//print '  ';
//print ' | ';
// next
if (($start + $perpage) < $total_rows)
{
	$newstart = $start + $perpage;
    print '<a href="bookmarks.php?'. $MyQS .$Delim.'start='.$newstart.'" class="bodyl">next ></a>';
}
else
{
    print '&nbsp;';
}
echo '&nbsp;'.$total_rows.' items total<br /><br />';
}
// end function display_pnt()


?>
<html>
<head>
<?php
if (array_key_exists('valid_user', $_SESSION))
{
$theusername = $_SESSION['valid_user'];
}
$MyQS = $_SERVER['QUERY_STRING'];
$perpage = 100; // Number of items to display per page lkhere set it to 100
// Examine QueryString
$wantedTagString = $_GET['tags'];

require('db_con.php');
?>
<title>LarryBeth</title>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
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
?>
<div class='LBBRight'>
<div class='LBBRightTitle'>Related tags</div>
<?php
// Set up the Tag Filtering Query
$TagFilterQPart1 = "SELECT a.UserID, a.URLID FROM ";
$stgTag = explode(' ',$wantedTagString);
$numTags = count($stgTag);
If ($numTags == 1)
{
	$TagFilterQ = $TagFilterQPart1 . "UserSiteTag AS a WHERE a.Tag ='" . $stgTag[0] . "'";
}
else
{
	$TagFilterQPart2 = "UserSiteTag AS a";
	$TagFilterQPart3 = "WHERE a.Tag='" . $stgTag[0] . "'";
	for ($somevar = 2; $somevar < $numTags+1; $somevar++)
	{
		$theltr = Chr(96+$somevar);
		$prevltr = Chr(95+$somevar);
		$TagFilterQPart2 = "(" . $TagFilterQPart2 . ") INNER JOIN UserSiteTag AS " . $theltr . " ON " . $prevltr . ".URLID = " . $theltr . ".URLID ";
		$TagFilterQPart3 = $TagFilterQPart3 . " and " . $theltr . ".tag = '" . $stgTag[$somevar-1] . "'";
	}
	$TagFilterQ = $TagFilterQPart1 . $TagFilterQPart2 . $TagFilterQPart3;
}
$CTempQ = "CREATE TEMPORARY TABLE MyTT " . $TagFilterQ;
$result9 = mysql_query($CTempQ) or die (mysql_error()."<br />Couldn't execute query: $CTempQ");
// done creating temp table
if ($numTags == 1)
{
	$queryRelTags = "SELECT Tag, COUNT(*) as Myct FROM UserSiteTag ust INNER JOIN MyTT tt ON ((tt.UserID = ust.UserID) AND (tt.URLID = ust.URLID)) GROUP BY Tag ORDER BY Myct DESC";
	$resultCT = mysql_query($queryRelTags) or die (mysql_error()."<br />Couldn't execute query: $queryRelTags");
	$num_CT = mysql_num_rows($resultCT);
	for ($i=0; $i <$num_CT; $i++)
	{
		$rowCT = mysql_fetch_array($resultCT);
		$TheCount = $rowCT['Myct'];
		$TheTag = $rowCT['Tag'];
		if ($TheTag <> $stgTag[0])
		{
			print "<div><span class=\"LBBNum\">";
			print $TheCount;
			print "</span><a href=\"tag.php?tags=";
			print $TheTag;
			print "\" class=\"right\">";
			print $TheTag;
			print "</a></div>";
		}
	}
}
?>
</div>
<div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername;
print '</p>';


$MyQueryPart1 = "SELECT UserSite.UserID, UserSite.URLID, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime FROM UserSite";
$MyQuery = $MyQueryPart1 . " INNER JOIN MyTT ON (UserSite.URLID = MyTT.URLID) AND (UserSite.UserID = MyTT.UserID) WHERE ((isNull(UserSite.Private)) OR (UserSite.Private = 0) OR (UserSite.UserID ='" . $theusername. "')) ORDER BY UserSite.OrigPostingTime DESC";
// Display main contents
?>
<table>
<tr><th><a href="bookmarks.php?user=<?php echo $userdisp?>&sortkey=name" class="bodyt">Name</a></th>
<th class="rttopu"><a href="bookmarks.php?user=<?php echo $userdisp?>&sortkey=postdate" class="bodyt">Posting Date</a></th></tr>
<?php

$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");
$num_results = mysql_num_rows($result);

$total_rows = $num_results; //

// display total number of items
display_pnt();

for ($i=0; $i <$num_results; $i++)
{
// Display one bookmark
	$row = mysql_fetch_array($result);
	$myUserID = $row['UserID'];
	$myName = $row['SiteDescr'];
	$myExtended = $row['ExtendedDesc'];
	$myOrigDate = $row['PostTime'];
	$myURLID = $row['URLID'];
	$myUserID = $row['UserID'];
	$myPrivate = $row['Private'];
	//print $myPrivate;
	if ((!$myPrivate) or ($myUserID == $theusername))
	{


		print "<tr><td>";
		print "<a class=\"bodyl\" target=\"_blank\" href=\"bkmarkredir.php?snum=";
		print $myURLID;
		print "\">";
		print $myName;
		print "</a></td><td class=\"rttop\">";
		print $myOrigDate;
		print "</td></tr>";
		print "<tr><td colspan=\"2\">";
		// Display Extended
		If (strlen($myExtended) > 0)
		{

			print $myExtended;
		}
		print "</td></tr>";
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
		print "</a></td>";
		if ($myUserID == $theusername)
		{
			// edit
			print "<td class=\"rtside\"><a href=\"bookmarks.php?editsite=";
			print $myURLID;
			print "\" class=\"bodyt\">Edit </a>";
		}
		else
		{
		//copy
		// Get actual URL
			$URLQuery = "Select URL FROM URL Where URLID =" . $myURLID;
			$URLresult = mysql_query($URLQuery) or die (mysql_error()."<br />Couldn't execute query: $URLQuery");
			$Urow = mysql_fetch_array($URLresult);
			$TheURL = $Urow['URL'];
			print "<td class=\"rtside\"><a href=\"bookpost.php?url=";
			print $TheURL;
			print "&title=";
			print $myName;
			print "\" class=\"bodyt\">Copy </a>";
		}
		print "this item</td></tr>";
	} // suppress private
} // for i$
?>
</table>
</div>
</body>
</html>