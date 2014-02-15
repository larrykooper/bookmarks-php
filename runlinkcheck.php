<?php
session_start();
require('ckuser.php');
require_once('linkchecker.php');
require_once('linkcheckresult.php');
require_once('db_con.php');
require_once('template.php');

if (!$validated) 
{
    require('bkbottom.php');
    exit();
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="linkcheck.css">
<style type="text/css">
.debug {
    color: green;
    margin-left: 30px;
}
</style>
</head>
<body>
<div class="welcome">
  Welcome to the Bookmarks LarryBeth Style Links Checker.<br><br>
</div>

<?php

//$myQuery = "SELECT URL FROM URL LIMIT 135, 3";

// Double quotes are PHP's delimiter 
// Single quotes are sql's delimiter

$start = 20;
$perpage = 10;

$myQuery = "SELECT UserSite.URLID, URL.URL, UserSite.SiteDescr, UserSite.ExtendedDesc, DATE_FORMAT(UserSite.OrigPostingTime, '%Y-%m-%d') AS PostingDate FROM UserSite INNER JOIN URL ON (UserSite.URLID = URL.URLID) WHERE (UserSite.UserID ='". $theusername . "') ORDER BY URL.URL LIMIT ".$start." , ".$perpage;
//echo $myQuery;

$sqlResult = mysql_query($myQuery) or die (mysql_error()."<br />Couldn't execute query: $myQuery");
$num_results = mysql_num_rows($sqlResult);
//echo "NUMBER OF RESULTS: $num_results";

for ($i=0; $i < $num_results; $i++) {
    $row = mysql_fetch_array($sqlResult);
    $url = $row['URL'];    
    $description = $row['SiteDescr'];
    $extended = $row['ExtendedDesc'];
    $datePosted = $row['PostTime'];
    $URLID = $row['URLID'];
    $result = LinkChecker::check_link($url);
    
    $urlPartial = new Template('linkcheckerView.php', array(
    'url' => $url,
    'description' => $description,
    'result' => $result,
));

    $urlPartial->render();
    
    // BEGIN     
    // echo '<div class="one_url">';
    // echo '<div>';
    // echo "URL: $url";
    // echo '</div>';
    // echo "DESCRIPTION: $description"
    // 
    //   
    // 
    // if ($result->error_text != '') {
    //     echo 'ERROR: ';
    //     echo $result->error_text;
    //     echo '<br>';
    // }
    //    
    // echo 'HTTP CODE: ';
    // echo $result->http_code;
    // echo '<br>';
    // 
    // if ($result->redirect_location != '') {
    //    echo 'REDIRECT LOCATION: ';
    //    echo $result->redirect_location;
    //    echo '<br>';
    // }
    // echo '</div>';
    // END
}

?>
</html>