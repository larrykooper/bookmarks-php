<?php
session_start();
require('ckuser.php');
require_once('db_con.php');
$userdisp = $theusername;
$wantedUser = $theusername;
$pageFrom = 'random';

$MyQuery =  "SELECT UserSite.URLID,
    DATE_FORMAT(Max(UserVisit.VisitDateTime),'%Y-%m-%d') AS LVDispl,
    UserSite.SiteDescr, UserSite.ExtendedDesc,
    UserSite.InRotation, UserSite.Private,
    DATE_FORMAT(UserSite.OrigPostingTime, '%Y-%m-%d') AS PostTime,
    Count(UserVisit.VisitDateTime) AS mycol
    FROM UserSite LEFT JOIN UserVisit ON (UserSite.URLID=UserVisit.URLID) AND (UserSite.UserID = UserVisit.UserID)
    WHERE (UserSite.UserID ='$theusername')
    GROUP BY UserSite.URLID, UserSite.SiteDescr ORDER BY RAND() LIMIT 1";

$result = mysql_query($MyQuery) or die (mysql_error()."<br />Couldn't execute query: $MyQuery");

$bookmarks_data = array();

// Get the data for one bookmark

$row = mysql_fetch_array($result);
// Get data for tags
$MyQuery2 = "SELECT Tag FROM UserSiteTag WHERE URLID=" . $row['URLID'] . " AND UserID='". $theusername ."' ORDER BY TagOrder";

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

require "templates/bookmarks.php";
