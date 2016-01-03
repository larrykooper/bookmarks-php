<?php
session_start();
require('ckuser.php');
require('helpers.php');
require_once('db_con.php');
$newPage = '';
foreach ($_GET as $k => $v)
{
    switch($k)
    {
        case 'editsite':
            $SiteToEdit = $v;
            break;
        case 'redirectUrl':
            $newPage = $v;
            break;
    }
}

// Display editing form

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

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bkm.css">
</head>
<body>
<?php
include('headerlogged.inc');
?>
    <fieldset class="chg">
    <legend>Edit this bookmark</legend>
    <form method="POST" action="saveupdate.php" id="form">
    <input type="hidden" name="redirectURL" value="<?php echo $newPage ?>">
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
    print stripslashes($siteSiteName);
    print "\" size=80>";
?>
</td></tr>

<tr><td align="right"><label for="extended">Extended:</label></td>
<td>
<?php
    print "<input type=\"text\" name=\"extended\" value=\"";
    print stripslashes($siteExtended);
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
    print "\"   size=80><nobr> (space separated)</nobr>";
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
<td>or
<input type=submit name="submit" value='delete'>
</td></tr>
</table>
</form>
</fieldset>
</body>
</html>
