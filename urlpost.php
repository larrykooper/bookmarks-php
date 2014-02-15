<?php
session_start();
?>

<html>
<head>
<?php

if (array_key_exists('valid_user', $_SESSION))
{
$theusername = $_SESSION['valid_user'];

// Examine QueryString

$myURLID = $_GET['url'];
require('db_con.php');
$MySortKey = $_GET['sortkey'];
if ($MySortKey == "")
	$MySortKey = "postdate";

switch ($MySortKey)
	{
		case 'name':
			$MyQueryPart4 = " ORDER BY SiteDescr"; 
			break;
		case 'postdate':
			$MyQueryPart4 = " ORDER BY OrigPostingTime DESC";
			break;
		default:
			$MyQueryPart4 = " ORDER BY OrigPostingTime DESC"; 
			break;
	}	
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bookmarks Shared</title>
<link rel="stylesheet" type="text/css" href="bkm.css">
</head>
<body>
<?php
include('headerlogged.inc');
?>
<?php
// Display Common Tags
?>

<div class="LBBRight">
<div class="LBBRightTitle">Common tags</div>	

<?php
$queryCommonTags = "SELECT Tag, COUNT(*) AS Myct FROM UserSiteTag WHERE URLID =". $myURLID . " GROUP BY Tag HAVING Myct > 1  ORDER BY Myct DESC ";
$resultCT = mysql_query($queryCommonTags) or die (mysql_error()."<br />Couldn't execute query: $queryCommonTags");
$num_CT = mysql_num_rows($resultCT);
for ($i=0; $i <$num_CT; $i++)
{
	$rowCT = mysql_fetch_array($resultCT);
	$TheCount = $rowCT['Myct'];
	$TheTag = $rowCT['Tag'];
	print "<div class=\"LBBTag\"><span class=\"LBBNum\">";
	print $TheCount;
	print "</span><a href=\"tag.php?tags=";
	print $TheTag;
	print "\" class=\"right\">";	
	print $TheTag;
	print "</a></div>";	
}
print "</div>";
// End of displaying common tags
// Display main contents
?>
<div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername.'.  ';
?>
</p>
Sort by:
<table border="0">
<tr>
<th><a href="urlpost.php?url=<?php echo $myURLID; ?>&sortkey=name" class="bodyt">Name</a></th>
<th class="rttopu"><a href="urlpost.php?url=<?php echo $myURLID; ?>&sortkey=postdate" class="bodyt">Posting Date</a></th></tr>

<?php
$MyQuery = "SELECT UserID, SiteDescr, ExtendedDesc, Private, DATE_FORMAT( OrigPostingTime, '%Y-%m-%d %H:%i' ) AS PostTime FROM UserSite WHERE URLID = " . $myURLID . $MyQueryPart4; 
//print $MyQuery; // debug

$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");
$num_results = mysql_num_rows($result);
//print $num_results;
for ($i=0; $i <$num_results; $i++) 
{
// Display one bookmark
	$row = mysql_fetch_array($result);
	$myUserID = $row['UserID'];
	$myName = $row['SiteDescr'];	
	$myExtended = $row['ExtendedDesc'];
	$myOrigDate = $row['PostTime'];	
	$myPrivate = $row['Private'];
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
		// Display Extended 
		If (strlen($myExtended) > 0)  
		{		
			print "<tr><td colspan=\"2\">";
			print $myExtended;
			print "</td></tr>";
		}		
	// If displaying a bookmark for the registered user, display Private if it is private
	if ($myUserID == $theusername)
	{		
		if ($myPrivate)
		{			
			print "<tr><td>";			
			print "Private";		
			print "</td></tr>";	
		}	
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
			$BMTagString = $BMTagString . "<a class=\"bodym\" href=\"bookmarks.php?tags=". $myTag . "\">";				
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
	
} // for $i
print "</table>";
print "</div>";
// This is what happens if the username is not recognized.
} 
else
{
	require('bkbottom.php');
}
?>
</body>
</html>