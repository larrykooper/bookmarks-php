<?php
session_start();
require('ckuser.php');
if (!$validated)
{
	$theusername = "Guest";
} 
?>
<?php
// ---------------------------------------------------------------------------------------
function TagString ($theResult)
{ 
	$TString = "";
	$num_results = mysql_num_rows($theResult);	
	for ($i=0; $i < $num_results; $i++)
	{
		$myrow = mysql_fetch_array($theResult);	
		$aTag = $myrow['Tag'];	
		$bTag = htmlentities($aTag);  // This changes special chars into their HTML equivalents	
		$TString = $TString . $bTag . " ";		
	}
	return $TString;
}
//End Function TagString
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
// ---------------------------------------------------------------------------------------
// ENTRY POINT
// ---------------------------------------------------------------------------------------
?>
<html>
<head>
<?php
$MyQS = $_SERVER['QUERY_STRING'];
$perpage = 100; // Number of items to display per page lkhere set it to 100  
// Examine QueryString
$Editing = 0;
$SiteToEdit = 0;
$Tagfilter = 0;
$Deleting = 0;
$Userfilter = 0;
$wantedUser = "";
$wantedTagString = "";

foreach ($_GET as $k => $v)
{
	switch($k)
	{
		case 'editsite':
			$Editing=1;
			$SiteToEdit = $v;
			break;
		case 'tags':
			$Tagfilter = 1;
			$wantedTagString = $v;
			break;			
		case 'sortkey':
			$MySortKey = $v;
			break;
		case 'delete':
			$Deleting = 1;
			$SiteToDelete = $v;
			break;	
		case 'start':
			$start = intval($v);
			break;		
		case 'settagsort':				 
			$_SESSION['tagsort'] = $v; // alpha or freq
			break;	
	}
}
if ($wantedUser == "")
	$wantedUser = $theusername;
if ($MySortKey == "")
	$MySortKey = "name";	
if ($start == "")
	$start = 0;	

switch ($MySortKey)
	{
		case 'name':
			$MyQueryPart4 = " ORDER BY UserSite.SiteDescr"; 
			break;
		case 'postdate':
			$MyQueryPart4 = " ORDER BY UserSite.OrigPostingTime DESC";
			break;
		case 'lastvisit':
			$MyQueryPart4 = " ORDER BY LVSort DESC";
			break;
		case 'count':
			$MyQueryPart4 = " ORDER BY mycol DESC";
			break;
		default:
			$MyQueryPart4 = " ORDER BY UserSite.SiteDescr"; 
			break;
	}	
	

// Examine Form Post Variables
if ($_POST['submit'] == "save") 
{
	$Mode = "save";
}
else 
{
	$Mode = "notsave";
}	
require_once( 'db_con.php' );
// Set page title
$myTitle = "Bookmarks LarryBeth Style";
?>
<title><?php echo $myTitle?></title>
<link rel="stylesheet" type="text/css" href="bkm.css">
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
If ($Userfilter)
	$userdisp = $wantedUser;
else
	$userdisp = $theusername;
// ----------------------------------------------------------------------------------------

// Display all of this user's tags for sites in-rotation 
?>

<div class='LBBRight'>
<div class='LBBRightTitle'>All tags</div>

<?php
if (!array_key_exists('tagsort', $_SESSION)) 
	$_SESSION['tagsort'] = 'alpha';
if ($_SESSION['tagsort'] == 'alpha')
	$MyTagSort = "Tag"; 
else 
	$MyTagSort = "tcount DESC"; 

$queryAllTags = "SELECT count(*) AS tcount, Tag FROM UserSiteTag ust INNER JOIN UserSite us ON (ust.UserID = us.UserID) AND (ust.URLID = us.URLID) WHERE ust.UserID ='" . $userdisp ."' AND us.InRotation = 1 GROUP BY Tag ORDER BY ". $MyTagSort; 

$result9 = mysql_query($queryAllTags) or die (mysql_error()."<br />Couldn't execute query: $queryAllTags");
$num_result9 = mysql_num_rows($result9);
for ($i=0; $i <$num_result9; $i++) 
{
	$row9 = mysql_fetch_array($result9);
	$TheCount = $row9['tcount'];
	$TheTag = $row9['Tag'];
	print "<div class=LBBTag><span class=\"LBBNum\">";
	print $TheCount;
	print "</span><a href=\"showinro.php?tags=";
	print $TheTag;
	print "&user=".$userdisp;
	print "\" class=\"right\">";	
	print $TheTag;
	print "</a></div>";
		
}
// Display tag-sorting options  

print "<br>sort by ";
If ($_SESSION['tagsort']=='freq')
{
print "<a class=LBBTag href=\"showinro.php?user=" . $userdisp ."&settagsort=alpha\">";
print "alpha";
print "</a>";
print " | freq";
}
else 
{
print "alpha";
print "<a class=LBBTag href=\"showinro.php?user=" . $userdisp ."&settagsort=freq\">";
print " | freq";
print "</a>";
} 
print "</div>";
// end of displaying all tags
// -----------------------------------------------------------------------------------------
?>
<div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername.'.  ';
?>
You are now viewing your in-rotation bookmarks.</p>

<?php

// -----------------------------------------------------------------------------------------
If ($Deleting)
{
	$myDelStmt1 = "DELETE FROM UserSiteTag WHERE URLID =" . $SiteToDelete . " AND UserID='". $theusername ."'";		
	$result6 = mysql_query($myDelStmt1) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt1");	
	$myDelStmt2 = "DELETE FROM UserSite WHERE URLID =" . $SiteToDelete . " AND UserID ='" . $theusername ."'";
	$result6 = mysql_query($myDelStmt2) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt2");	
}  // end if deleting
// -----------------------------------------------------------------------------------------

// Display editing form if we need to
If ($Editing)  
{
	//print "editing";				
	$querySiteInfo = "SELECT UserSiteID, SiteDescr, ExtendedDesc, InRotation, Private, ul.URL FROM UserSite us INNER JOIN URL ul ON us.URLID = ul.URLID WHERE us.URLID=" . $SiteToEdit  . " AND UserID='". $theusername ."'";
	$querySTags =  "SELECT Tag FROM UserSiteTag WHERE URLID=" . $SiteToEdit . " AND UserID='". $theusername ."' ORDER BY TagOrder";		
	$result = mysql_query($querySiteInfo) or die (mysql_error()."<br />Couldn't execute query: $querySiteInfo");
	$row = mysql_fetch_array($result);	
	$siteSiteName = $row['SiteDescr'];
	$siteURL = $row['URL'];	
	$siteExtended = $row['ExtendedDesc'];
	$siteInRo = $row['InRotation'];
	$sitePrivate = $row['Private'];
?>
	<fieldset class="chg">
	<legend>Edit this bookmark</legend>
	<form method="POST" action="bookmarks.php" id="form"> 
<table>
<tr><td align="right"><label for="url">URL:</label></td>		
<td>
<?php
	print $siteURL;
	print "<input type=\"hidden\" name=\"siteediting\" value=\"";	
	print $SiteToEdit; 
	print "\">";
?>
</td></tr>	

<tr><td align="right"><label for="description">Description:</label></td>
<td>
<?php
	print "<input type=\"text\" name=\"description\" value=\""; 
	print $siteSiteName;
	print "\" size=80>";
?>	
</td></tr>
		
<tr><td align="right"><label for="extended">Extended:</label></td>
<td>
<?php
	print "<input type=\"text\" name=\"extended\" value=\"";
	print $siteExtended;
	print "\" size=80> (optional)";	
?>
</td></tr>

<tr><td align="right"><label>Tags:</label></td>
<td>
<?php
	print "<input type=\"text\" name=\"tags\" value=\""; 	
	$result4 = mysql_query($querySTags) or die (mysql_error()."<br />Couldn't execute query: $querySTags");
	$theTagString = TagString($result4);	 
	print $theTagString;	 
	print "\" 	size=80><nobr> (space separated)</nobr>";
?>
</td></tr>

<?php
if ($siteInRo)
	$ckdInro = "checked";
else
	$ckdInro = "";
if ($sitePrivate)
	$ckdPriv = "checked";
else 
	$ckdPriv = "";		
?>		
<tr>&nbsp;</tr>
<tr><td align="right"></td>
<td>
<input type="checkbox" <?php echo $ckdInro?>  name="cb_inrotation" value="y"> 
<label for="cb_inrotation">In Rotation</label> -- Check here if you would like to regularly visit this site<br /><br /> 
</td></tr>
<tr><td align="right"></td>
<td>
<input type="checkbox" <?php echo $ckdPriv?> name="cb_private" value="y"> 
<label for="cb_private">Private</label> -- Do not display this bookmark to other users<br /><br /> 
</td></tr>

<?php
	print "<input type=\"hidden\" name=\"oldtagstring\" value=\"";
	print $theTagString;
	print "\">";
	print "<tr><td align=\"right\"><input type=submit name=\"submit\" value='save'>";
?>
</td>
<td>or <a href="bookmarks.php?delete=<?php echo $SiteToEdit; ?>" class="bodyt">Delete this post</a>
</td></tr>	
</table>
</form> 
</fieldset>
<br /><br />	
<?php

// Done displaying editing form
} // if editing
// -----------------------------------------------------------------------------------------
// Now save stuff if we need to 
if ($Mode == "save") 
{	
	// Get data from form
	$frmDescr = $_POST['description'];	
	$frmExtended = $_POST['extended'];
	$frmTagString = $_POST['tags'];
	$frmSiteEditing = $_POST['siteediting'];
	$frmInRotation = $_POST['cb_inrotation'];
	$frmPrivate = $_POST['cb_private'];
	$OldTags = $_POST['oldtagstring'];	
	
	if ($frmInRotation == "y") 
		$dbInro = 1;
	else 
		$dbInro = 0;
	if ($frmPrivate == "y")
		$dbPriv = 1;
	else
		$dbPriv = 0;	
	
	// Update UserSite table
	$myUpStmt = "UPDATE UserSite SET SiteDescr = '" . $frmDescr . "', ExtendedDesc = '" . $frmExtended . "', InRotation = " . $dbInro . ", Private = ". $dbPriv . " WHERE URLID = " . $frmSiteEditing . " AND UserID = '$theusername'";	
	$result5 = mysql_query($myUpStmt) or die (mysql_error()."<br />Couldn't execute query: $myUpStmt");	
	// Update tags if we need to	
	if ($frmTagString <> $OldTags) 
	{ 
		$myDelStmt = "DELETE FROM UserSiteTag WHERE URLID =" . $frmSiteEditing . " AND UserID='". $theusername ."'";		
		$result6 = mysql_query($myDelStmt) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt");		 	
		//  parse out the tags and write them to db 			 
		$MyArray = explode(' ',$frmTagString);
		$tagcount = 1;
		foreach ($MyArray as $theTag)
		{	
			If (strlen($theTag) > 0)
			{  		
				$queryCheckDup = "SELECT Tag FROM UserSiteTag WHERE UserID = '$theusername' AND URLID = $frmSiteEditing 
AND Tag = '$theTag'";
				$resultD = mysql_query($queryCheckDup) or die (mysql_error()."<br />Couldn't execute query: $queryCheckDup");	
				$my_num = mysql_num_rows($resultD); 
				if ($my_num == 0) 
				{
					// do the insert				
					$myInsStmt = "INSERT INTO UserSiteTag (UserID, URLID, Tag, TagOrder) VALUES ('" . $theusername ."',". $frmSiteEditing ." , '". $theTag . "', ". $tagcount .")";				
					$result7 = mysql_query($myInsStmt) or die (mysql_error()."<br />Couldn't execute query: $myInsStmt");		
					$tagcount = $tagcount + 1;	
				}				
			}				
		}  // ends foreach loop		 
	}	// if new tags differ from old tags			
} // if mode = save

// End of saving stuff
// ----------------------------------------------------------------------------------------
?>
<?php
// Display main contents (bookmarks)

// Set the query 
// ----------------------------------------------------------------------------------------
if ($Tagfilter) 
{ 
	// Set up the Tag Filtering Query
	$TagFilterQPart1 = "SELECT a.URLID FROM "; 
	$stgTag = explode(' ',$wantedTagString);
	$numTags = count($stgTag);  
	If ($numTags == 1)
	{   
		$TagFilterQ = $TagFilterQPart1 . "UserSiteTag AS a WHERE a.UserID = '" . $userdisp . "' AND a.Tag ='" . $stgTag[0] . "'"; 
	}	
	else
	{
		$TagFilterQPart2 = "UserSiteTag AS a";
		$TagFilterQPart3 = "WHERE a.UserID = '" . $userdisp . "' AND a.Tag='" . $stgTag[0] . "'";	

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
	// Create a temporary table to do the tag filtering
	$result9 = mysql_query($CTempQ) or die (mysql_error()."<br />Couldn't execute query: $CTempQ");		
	
		
		$MyQueryPart1 = "SELECT UserSite.URLID, Max(UserVisit.VisitDateTime) AS LVSort, DATE_FORMAT( Max(UserVisit.VisitDateTime),'%Y-%m-%d') AS LVDispl, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.InRotation, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime, Count(UserVisit.VisitDateTime) AS mycol FROM UserSite LEFT JOIN UserVisit ON UserSite.URLID=UserVisit.URLID"; 
		$MyQueryPart3 = "GROUP BY UserSite.URLID, UserSite.SiteDescr";	
		$MyCountQuery =   "SELECT COUNT(UserSite.URLID) FROM UserSite INNER JOIN MyTT ON UserSite.URLID = MyTT.URLID WHERE UserSite.UserID ='". $userdisp . "' AND UserSite.InRotation = 1";
		$MyQuery = $MyQueryPart1 . " INNER JOIN MyTT ON UserSite.URLID = MyTT.URLID WHERE UserSite.UserID ='". $userdisp . "' AND UserSite.InRotation = 1 " . $MyQueryPart3 . $MyQueryPart4 . " LIMIT ".$start." , ".$perpage;	
	

}  // if tagfilter 	
// ----------------------------------------------------------------------------------------
else 
{
	
	$MyCountQuery = "SELECT COUNT(UserSite.URLID) FROM UserSite WHERE (UserSite.UserID ='". $userdisp ."' AND UserSite.InRotation = 1)";
	$MyQuery =	"SELECT UserSite.URLID, Max(UserVisit.VisitDateTime) AS LVSort, DATE_FORMAT( Max(UserVisit.VisitDateTime),'%Y-%m-%d') AS LVDispl, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.InRotation, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime,  Count(UserVisit.VisitDateTime) AS mycol FROM UserSite LEFT JOIN UserVisit ON (UserSite.URLID=UserVisit.URLID) AND (UserSite.UserID = UserVisit.UserID) WHERE (UserSite.UserID ='". $userdisp ."' AND UserSite.InRotation = 1) GROUP BY UserSite.URLID, UserSite.SiteDescr" . $MyQueryPart4. " LIMIT ".$start." , ".$perpage;
	
	
}
$rh = mysql_query($MyCountQuery) or die (mysql_error()."<br />Couldn't execute query: $MyCountQuery"); 
$t=mysql_fetch_row($rh);
$total_rows=$t[0];   
$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");
$num_results = mysql_num_rows($result);
// display code starts here
display_pnt();
?>
Sort by:
<table border="0">
<?php
if ($Tagfilter) 
{ 
?>
<tr>
<th><a href="showinro.php?user=<?php echo $userdisp?>&sortkey=name&tags=<?php echo $wantedTagString?>" class="bodyt">Name</a></th>
<th class="rttopu"><a href="showinro.php?user=<?php echo $userdisp?>&sortkey=postdate&tags=<?php echo $wantedTagString?>" class="bodyt">Posting Date</a></th>
<?php
}
else
{
?>
<tr>
<th><a href="showinro.php?user=<?php echo $userdisp?>&sortkey=name" class="bodyt">Name</a></th>
<th class="rttopu"><a href="showinro.php?user=<?php echo $userdisp?>&sortkey=postdate" class="bodyt">Posting Date</a></th>
<?php
}
if ($userdisp == $theusername)
{
?>
<th class="rttopu"><a href="showinro.php?sortkey=lastvisit" class="bodyt">Last Visited</a></th>
<th class="rttopu"><a href="showinro.php?sortkey=count" class="bodyt">Total Visits</a></th>
<?php
}
?>
</tr>
<?php
for ($i=0; $i <$num_results; $i++) 
{	
// Display one bookmark
	$row = mysql_fetch_array($result);
	$myName = $row['SiteDescr'];	
	$myExtended = $row['ExtendedDesc'];
	$myInro = $row['InRotation'];
	$myPriv = $row['Private'];
	$myOrigDate = $row['PostTime'];
	$myTime = $row['LVDispl'];
	$myURLID = $row['URLID'];
	$myCount = $row['mycol'];	
	// Calculate count of other users
	$queryPeople = "SELECT COUNT(*) AS PeopleCt FROM UserSite WHERE URLID = " . $myURLID;
	$resPeople = mysql_query($queryPeople) or die (mysql_error()."<br />Couldn't execute query: $queryPeople");
	$rPeople = mysql_fetch_array($resPeople);
	$pCount = $rPeople['PeopleCt'];	
	$othcount = $pCount - 1;
	print "<tr><td><a href=\"bkmarkredir.php?snum=";
	print $myURLID;		
	print "\" target=\"new\" class=\"bodyl\">";
	print $myName;
	print "</a></td>";
	print "<td class=\"rttop\">";
	print $myOrigDate;
	print "</td>";	
	if ($userdisp == $theusername)
	{
		print "<td class=\"rttop\" align=\"right\">";
		print $myTime;
		print "</td><td class=\"rttop\" align='right'>";
		print $myCount;
		print "</td>";
	}
	print "</tr>"; 	
	print "<tr>";	
	// Display Extended Descr
	If (strlen($myExtended) > 0)  
	{
		print "<td colspan=\"2\">";
		print $myExtended;
		print "</td>";
	}	
	print "</tr>";	
	// If displaying tags for the registered user, display In Rotation and Private 
	if ($userdisp == $theusername)
	{
		$donetr = 0;
		if ($myInro) 
		{
			print "<tr><td>";	
			$donetr = 1;	
			print "In-Rotation";
		}	
		if ($myPriv)
		{
			if (!$donetr)
			{
				print "<tr><td>";
				$donetr = 1;
			}	
			else 
			{
				print "; ";
			}
			print "Private";	
		}
		if ($donetr)
			print "</td></tr>";	
	}
	// Beginning of code to display tags for one bookmark	
	$MyQuery2 = "SELECT Tag FROM UserSiteTag WHERE URLID=" . $myURLID . " AND UserID='". $userdisp ."' ORDER BY TagOrder"; 
	print "<tr><td class=\"below\">";
	$result2 = mysql_query($MyQuery2) or die (mysql_error()."<br />Couldn't execute query: $MyQuery2");
	$BMTagString = "";
	$num_results2 = mysql_num_rows($result2);
	for ($j=0; $j <$num_results2; $j++)
	{
		$row2 = mysql_fetch_array($result2);
		$myTag = $row2['Tag'];
		$BMTagString = $BMTagString . "<a href=\"bookmarks.php?user=". $userdisp ."&tags=". $myTag . "\" class=\"bodym\">";				
		$BMTagString = $BMTagString . $myTag . " </a>";				
	}
	
	print $BMTagString;	 
	print "...";
	// End of code to display tags 
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
	// Display edit this item or copy this item	

	if ($userdisp == $theusername)
	{
		// edit
		print "<td colspan=\"3\" class=\"rtside\"><a href=\"bookmarks.php?editsite=";	
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
	 
} // end of for $i
?>
</table>
<?php
display_pnt();
?>
</div>
</body>
</html>