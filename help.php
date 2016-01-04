<?php
session_start();
require('ckuser.php');
require_once( 'db_con.php' );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/bkm.css">
<title>Bookmarks Help</title>
</head>
<body>

<?php
If ($validated)
{
include('headerlogged.inc');
}
else
{
include('templates/header.php');

}
?>
<div class="LBBRight">
<div class='LBBRightTitle'>Active recently</div>
<?php
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
// End of displaying recently active
?>
</div>
<div class="narrow">

	<?php
If ($validated)
{
	echo '<p class="help">Welcome, '.$theusername.'. ';
	print '</p>';
}
?>
<p class="help">Bookmarks LarryBeth Style</p>
<ul>
<li>Bookmarks, LarryBeth Style, allows you to create and maintain your collection of bookmarks (favorite sites) and share them.  You also can see who else has bookmarked your sites.  You can
add tags (keywords) to your bookmarks.</li>

<li>Once you've registered for the service, you add a simple bookmarklet to your browser <a href="#bookmarklet" class="body">(see below)</a>. When you
find a web page you'd like to add to your list, click the LarryBeth bookmarklet, and you'll
be prompted for a information about the page. You can add descriptive terms to group similar links
together, modify the title of the page, and add extended notes for yourself or for others.</li>

<li>You can access your list of links from any web browser.  You can view bookmarks in chronological order (by posting
date), by name (alphabetically), or (if they are your bookmarks) by the date you last visited them or the number of visits.</li>
</ul>

<p class="help">About Tags</p>
<p>Tags are descriptive terms, or keywords, that you can use to classify your bookmarks.  A tag cannot have any spaces in it.  If you want to use a multi-word tag, like "San Francisco," you need to take out the spaces.  We recommend replacing the spaces with underscores, like this: san_francisco .</p>
<p>For example, if you want to visit all sites tagged "books", you would use this URL:
<a href="http://www.larrybeth.com/bookmarks/tag.php?tags=books" class="body">http://www.larrybeth.com/bookmarks/tag.php?tags=books</a><br />
To see sites that are tagged both "books" and "blog," for example, separate the tags with a plus sign:
<a href="http://www.larrybeth.com/bookmarks/tag.php?tags=books+blog" class="body">http://www.larrybeth.com/bookmarks/tag.php?tags=books+blog</a>
It works for any number of tags.
</p>


<p class="help">In Rotation</p>
If you would like to visit a site regularly, mark it as "in rotation" when you post it (or anytime).  Click the "Next in rotation" link at the top of the page to visit the in-rotation site that you have visited the longest time ago.   You might use this feature to remind you to visit sites that you like, but don't look at every day.

<p class="help">Private Bookmarks</p>
If you mark a site as Private, it will not be shown to any other users, nor will the tags you have given it be shown.

<p class="help">About This Site</p>
This site was inspired by del.icio.us, created by Joshua Schachter.  We wanted a few more features, so we decided to create them. Some features Bookmarks LarryBeth Style has that del.icio.us does not have:
<ul>
<li>Allows you to view your sites in alphabetical order</li>
<li>Keeps track of when you visit your favorite sites</li>
<li>Private bookmarks, that only you can view</li>
<li>You can look up a page title from the posting form</li>
</ul>
LarryBeth Bookmarks was built with PHP and MySQL.

<a name="bookmarklet"></a>

<?php
If ($validated)
{
?>
<p class="help">Bookmarklets</p>

Please add these to your link bar.
<ul>
<li><a class="body" href='/bookmarks/bookmarks.php'>My Bookmarks</a> (use this one to get to your LarryBeth Bookmarks page)</li>
<li><a class="body" href="javascript:location.href='http://www.larrybeth.com/bookmarks/bookpost.php?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)" onclick="window.alert('Drag this link to your toolbar or right-click it and choose Add to Favorites.');" >Post to Bookmarks</a> (use this to create a bookmark. works in internet explorer, mozilla, and safari)</li>
</ul>

Help with bookmarklets for IE users:<br />

1. Right-click on the "Post to Bookmarks" link above<br />
2. Select Add to Favorites from the popup menu<br />
3. It will ask you if you want to add a favorite that may not be safe.  Click Yes.  (This message is displayed because there is Javascript code in the favorite).<br />
4. In Create In, click on Links.<br />
5. Click OK.<br />
You should now have a button in your links bar called "Post to Bookmarks."  When you are visiting a site you would like to post to Bookmarks LarryBeth Style, click the button!  (Try it!)
<?php
}
?>

<p class="help">Contact</p>
Please send questions, comments, feature requests, bug reports directly to me (Larry) at <a href="mailto:bookmarks@larrybeth.com?subject=Bookmarks" class="body">my email box</a>.
<p><a href="privacy.php" class="body">Privacy Policy</a></p>
</div>
</div>
</div>
</body>
</html>
