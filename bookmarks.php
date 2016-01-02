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
require('helpers.php');

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
$perpage = 100; // Number of items to display per page set to 100
// Examine QueryString
$Editing = 0;
$SiteToEdit = 0;
$Tagfilter = 0;
$Deleting = 0;
$Userfilter = 0;
$wantedUser = "";
$wantedTagString = "";
$MySortKey = "";
$start = 0;

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
        case 'user':
            $Userfilter = 1;
            $wantedUser = $v;
            break;
        case 'sortkey':
            $MySortKey = $v;
            break;
        case 'dir' :
            $myDirection = $v;
            break;
        case 'start':
            $start = intval($v);
            break;
        case 'settagsort':
            $_SESSION['tagsort'] = $v; // alpha or freq
            break;
    }
}
if ($wantedUser == "") {
    $wantedUser = $theusername;
}
if ($MySortKey == "") {
    $MySortKey = "name";
}
if ($myDirection == "") {
    if ($MySortKey == "name") {
        $myDirection = "ASC";
    } else {
        $myDirection = "DESC";
    }
}
if ($start == "") {
    $start = 0;
}

switch ($MySortKey)
    {
        case 'name':
            $MyQueryPart4 = " ORDER BY UserSite.SiteDescr " . $myDirection;
            break;
        case 'postdate':
            $MyQueryPart4 = " ORDER BY UserSite.OrigPostingTime " . $myDirection;
            break;
        case 'lastvisit':
            $MyQueryPart4 = " ORDER BY LVSort " . $myDirection;
            break;
        case 'count':
            $MyQueryPart4 = " ORDER BY mycol " . $myDirection;
            break;
        default:
            $MyQueryPart4 = " ORDER BY UserSite.SiteDescr" . $myDirection;
            break;
    }
require_once('db_con.php');
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

// Display all of this user's tags
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

// Do not display tags for private sites
if ($userdisp == $theusername)
    $queryAllTags = "SELECT count(*) AS tcount, Tag FROM UserSiteTag WHERE UserID ='" . $userdisp ."' GROUP BY Tag ORDER BY ". $MyTagSort;
else
    $queryAllTags = "SELECT count(*) as tcount, ust.Tag FROM UserSiteTag ust INNER JOIN UserSite us ON ust.UserID = us.UserID AND ust.URLID = us.URLID WHERE ust.UserID = '$userdisp' AND (us.Private IS NULL OR us.Private <> 1) GROUP BY Tag ORDER BY ". $MyTagSort;
$result9 = mysql_query($queryAllTags) or die (mysql_error()."<br />Couldn't execute query: $queryAllTags");
$num_result9 = mysql_num_rows($result9);
for ($i=0; $i <$num_result9; $i++)
{
    $row9 = mysql_fetch_array($result9);
    $TheCount = $row9['tcount'];
    $TheTag = $row9['Tag'];
    print "<div class=LBBTag><span class=\"LBBNum\">";
    print $TheCount;
    print "</span><a href=\"bookmarks.php?tags=";
    print $TheTag;
    print "&user=".$userdisp;
    print "\" class=\"right\">";
    print $TheTag;
    print "</a></div>";
}
// Display tag-sorting options

print "<div class='LBBRightTitle'>sort by ";
If ($_SESSION['tagsort']=='freq')
{
print "<a class=\"right\" href=\"bookmarks.php?user=" . $userdisp ."&settagsort=alpha\">";
print "alpha";
print "</a>";
print " | freq";
print "</div>";
}
else
{
print "alpha";
print "<a class=\"right\" href=\"bookmarks.php?user=" . $userdisp ."&settagsort=freq\">";
print " | freq";
print "</a>";
print "</div>";
}
print "</div>";
// end of displaying all tags
// -----------------------------------------------------------------------------------------
?>
<div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername.'.  ';
?>
You are now viewing the bookmarks of <a href="bookmarks.php?user=<?php echo $userdisp?> "class='body' ><?php echo $wantedUser?></a>.</p>
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

    if ((!$Userfilter)  or (($Userfilter) and ($userdisp == $theusername)))
    {
        $MyQueryPart1 = "SELECT UserSite.URLID, Max(UserVisit.VisitDateTime) AS LVSort, DATE_FORMAT( Max(UserVisit.VisitDateTime),'%Y-%m-%d') AS LVDispl, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.InRotation, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime, Count(UserVisit.VisitDateTime) AS mycol FROM UserSite LEFT JOIN UserVisit ON UserSite.URLID=UserVisit.URLID";
        $MyQueryPart3 = "GROUP BY UserSite.URLID, UserSite.SiteDescr";
        $MyCountQuery =   "SELECT COUNT(UserSite.URLID) FROM UserSite INNER JOIN MyTT ON UserSite.URLID = MyTT.URLID WHERE UserSite.UserID ='". $userdisp . "'";
        $MyQuery = $MyQueryPart1 . " INNER JOIN MyTT ON UserSite.URLID = MyTT.URLID WHERE UserSite.UserID ='". $userdisp . "'" . $MyQueryPart3 . $MyQueryPart4 . " LIMIT ".$start." , ".$perpage;
    }
    else
    // We are displaying tags for another user
    {
        $MyCountQuery = "SELECT COUNT(us.URLID) FROM UserSite us INNER JOIN MyTT tt ON us.URLID = tt.URLID WHERE (us.userID = '". $userdisp . "') AND ((us.Private IS NULL) OR (us.Private <> 1))";
        $MyQuery = "SELECT us.SiteDescr, us.URLID, us.ExtendedDesc, DATE_FORMAT( us.OrigPostingTime, '%Y-%m-%d %H:%i' ) AS PostTime FROM UserSite us INNER JOIN MyTT tt ON  us.URLID = tt.URLID WHERE (us.userID = '". $userdisp . "') AND ((us.Private IS NULL)OR (us.Private <> 1))". " LIMIT ".$start." , ".$perpage;
    }
}  // if tagfilter
// ----------------------------------------------------------------------------------------
else
{
    if ($userdisp == $theusername)
    {
        $MyCountQuery = "SELECT COUNT(UserSite.URLID) FROM UserSite WHERE (UserSite.UserID ='". $userdisp ."')";
        $MyQuery =  "SELECT UserSite.URLID, Max(UserVisit.VisitDateTime) AS LVSort, DATE_FORMAT( Max(UserVisit.VisitDateTime),'%Y-%m-%d') AS LVDispl, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.InRotation, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime,  Count(UserVisit.VisitDateTime) AS mycol FROM UserSite LEFT JOIN UserVisit ON (UserSite.URLID=UserVisit.URLID) AND (UserSite.UserID = UserVisit.UserID) WHERE (UserSite.UserID ='". $userdisp ."') GROUP BY UserSite.URLID, UserSite.SiteDescr" . $MyQueryPart4. " LIMIT ".$start." , ".$perpage;
    }
    else
    {
    // Another user
        $MyCountQuery = "SELECT COUNT(UserSite.URLID) FROM UserSite WHERE (UserSite.UserID ='". $userdisp ."') AND ((UserSite.Private IS NULL) OR (UserSite.Private <> 1))";
        $MyQuery =  "SELECT UserSite.URLID, UserSite.SiteDescr, UserSite.ExtendedDesc, UserSite.Private, DATE_FORMAT( UserSite.OrigPostingTime, '%Y-%m-%d' ) AS PostTime FROM UserSite WHERE (UserSite.UserID ='". $userdisp ."') AND ((UserSite.Private IS NULL) OR (UserSite.Private <> 1))" . $MyQueryPart4 . " LIMIT ".$start." , ".$perpage;
    }
}
$rh = mysql_query($MyCountQuery) or die (mysql_error()."<br />Couldn't execute query: $MyCountQuery");
$t=mysql_fetch_row($rh);
$total_rows=$t[0];
$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");
$num_results = mysql_num_rows($result);
// display code starts here
if ($myDirection == "ASC") {
    $displayDirection = "DESC";
} else {
    $displayDirection = "ASC";
}
display_pnt();
?>
Sort by:
<table border="0">
<?php
if ($Tagfilter) {
?>
    <tr>
        <th><a href="bookmarks.php?user=<?php echo $userdisp?>&sortkey=name&dir=<?php echo $displayDirection?>&tags=<?php echo $wantedTagString?>" class="bodyt">Name</a>
    </th>
    <th class="rttopu">
        <a href="bookmarks.php?user=<?php echo $userdisp?>&sortkey=postdate&dir=<?php echo $displayDirection?>&tags=<?php echo $wantedTagString?>" class="bodyt">Posting Date</a>
    </th>
    <?php
    }



if ($userdisp == $theusername)
{
?>
<th class="rttopu"><a href="bookmarks.php?sortkey=lastvisit&dir=<?php echo $displayDirection?>" class="bodyt">Last Visited</a></th>
<th class="rttopu"><a href="bookmarks.php?sortkey=count&dir=<?php echo $displayDirection?>" class="bodyt">Total Visits</a></th>
<?php
}
?>
</tr>
<?php
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$bookmarks_data = array();
for ($i=0; $i <$num_results; $i++)
{
// Get the data for one bookmark

    $row = mysql_fetch_array($result);
    // Get data for tags
    $MyQuery2 = "SELECT Tag FROM UserSiteTag WHERE URLID=" . $row['URLID'] . " AND UserID='". $userdisp ."' ORDER BY TagOrder";

    $result2 = mysql_query($MyQuery2) or die (mysql_error()."<br />Couldn't execute query: $MyQuery2");
    $num_results2 = mysql_num_rows($result2);
    $tags = array();
    for ($j=0; $j <$num_results2; $j++) {
        $row2 = mysql_fetch_array($result2);
        $tags[] = $row2['Tag'];
    }
    $one_bookmark_data = array('bookmark' => $row, 'tags' => $tags);
    $bookmarks_data[] = $one_bookmark_data;
    // Done getting data for tags

} // end of for $i
?>
</table>
<?php
require "templates/bookmarks.php";

display_pnt();
?>
</div>
</body>
</html>
