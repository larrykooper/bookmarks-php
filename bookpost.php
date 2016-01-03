<?php
session_start();
require('ckuser.php');
require('const1.php');
//---------------------------------------------------------------------------------------
function TagString ($theResult)
{

    $TString = "";
    $num_results = mysql_num_rows($theResult);
    for ($i=0; $i < $num_results; $i++)
    {
        $myrow = mysql_fetch_array($theResult);
        $aTag = $myrow['Tag'];
        $TString = $TString . $aTag . " ";
    }
    return $TString;
}
//End Function TagString
//---------------------------------------------------------------------------------------
function ac_Get_Title_From_Page($file, $bytes)
     {
     // thanks to Acecool (http://www.acecoolco.com)
        $filename = @fopen("$file", "r");
        $data = @fread($filename, $bytes);
        @fclose($filename);
        preg_match_all ("/<title>(.*?)<\/title>/i", $data, $_Get_Title_From_Page);
        $Get_Title_From_Page = $_Get_Title_From_Page[1][0];
        return $Get_Title_From_Page;
    }

//---------------------------------------------------------------------------------------
function show_header ()
{
global $theusername;
$myheader = <<< End_Of_Header
    <html>
    <head>
    <title>Bookmark Post Page</title>
    <link rel="stylesheet" type="text/css" href="css/bkm.css">
    <link rel="stylesheet" type="text/css" href="css/postSiteForm.css">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    </head>
    <body>
End_Of_Header;
    print $myheader;
    include('headerlogged.inc');
    ?>

    <div class="LBBMain">
<?php
echo '<p class="help"> Welcome, '.$theusername.'.  ';
print '</p>';
}

//---------------------------------------------------------------------------------------
function show_form ($urlstring, $descstring, $extenstring, $tagstring) {

    require "templates/postSiteForm.php";

}  // end function show_form
//---------------------------------------------------------------------------------------
function show_form_fixedurl ($urlstring, $descstring, $extenstring, $tagstodisp, $oldtagstring, $buttontext, $SiteURLID, $siteInRotation, $sitePrivate)
{

?>

<fieldset class="chg">
<legend>Fix a posting:</legend>

<form method="POST" action="bookpost.php">
    <table> <tr><td align="right"><label for="url">URL</label></td><td>
<?php
    print $urlstring;
?>
    </td></tr>
    <tr><td>name</td>
    <td>
<?php
    print "<input type=\"text\" name=\"description\" value=\"";
    print $descstring;
    print "\" size=80>";
?>
    </td></tr><tr><td>extended</td><td>
<?php
    print "<input type=\"text\" name=\"extended\" value=\"";
    print $extenstring;
    print "\" size=80> (optional)";
?>
 </td></tr><tr><td>tags</td><td>
<?php
    print "<input type=\"text\" name=\"tags\" value=\"";
    print $tagstodisp;
    print "\"   size=80> (space separated)";

    if ($siteInRotation)
        $ckdInro = "checked";
    else
        $ckdInro = "";
    if ($sitePrivate)
        $ckdPriv = "checked";
    else
        $ckdPriv = "";
?>
        </td></tr>
        <tr><td></td><td>
<input type="checkbox" <?php echo $ckdInro?>  name="cb_inrotation" value="y">
<label for="cb_inrotation">In Rotation</label> -- Check here if you would like to regularly visit this site<br /><br />
</td></tr>
<tr><td></td>
<td>
<input type="checkbox" <?php echo $ckdPriv?> name="cb_private" value="y">
<label for="cb_private">Private</label> -- Do not display this bookmark to other users<br /><br />
</td></tr>

        <tr><td>
<?php

    print "<input type=submit name=\"submit\" value='";
    print $buttontext;
    print "'>";
    print "<input type=hidden name=\"submit_type\" value='";
    print $buttontext;
    print "'>";

?>
</td><td></td></tr></table>
<?php
    print "<input type=\"hidden\" name=\"oldtagstring\" value=\"";
    print $oldtagstring;
    print "\">";

    print "<input type=\"hidden\" name=\"siteediting\" value=\"";
    print $SiteURLID;
    print "\">";
?>
</form>
</fieldset>
<?php
}  // end function show_form_fixedurl
//---------------------------------------------------------------------------------------
function UserSite_add ($nameofuser, $descrip, $URLident, $Extendy, $tagstr, $inro, $priv)
{
    global $sitename;
    if ($inro == "y")
        $dbInro = 1;
    else
        $dbInro = 0;
    if ($priv == "y")
        $dbPriv = 1;
    else
        $dbPriv = 0;
    $myInsStmt2 = "INSERT INTO UserSite (UserID, SiteDescr, URLID, InRotation, ExtendedDesc, OrigPostingTime, Private) VALUES ('" . $nameofuser . "','" . mysql_real_escape_string($descrip) . "'," . $URLident . ", " . $dbInro . ", '". mysql_real_escape_string($Extendy) . "', NOW()" . ", " . $dbPriv . ")";
    $result5 = mysql_query($myInsStmt2) or die (mysql_error()."<br />Couldn't execute query: $myInsStmt2");
    //  parse out the tags and write them to db
    $MyArray = explode(' ',$tagstr);
    $tagcount = 1;
    foreach ($MyArray as $theTag)
    {
        if (strlen($theTag) > 0)
        {
            $myInsStmt3 = "INSERT INTO UserSiteTag (UserID, URLID, Tag, TagOrder) VALUES ('" . $nameofuser ."',". $URLident . ", '". $theTag . "', ". $tagcount .")";
            $result7 = mysql_query($myInsStmt3) or die (mysql_error()."<br />Couldn't execute query: $myInsStmt3");
            $tagcount = $tagcount + 1;
        } //If tag not zero-length
    } // foreach
// data has been saved
// redirect to user's bookmarks page
$thelocstring = "Location: http://".$sitename."/bookmarks/bookmarks.php?user=". $nameofuser ."&sortkey=postdate";
header ($thelocstring);
exit();
}
//---------------------------------------------------------------------------------------
?>
<?php
// ----------------------------------------------------------------------------------------
// ENTRY POINT
// ----------------------------------------------------------------------------------------

if ($validated)
{
// Get user name

$theusername = $_SESSION['valid_user'];
$Mode = "";

// Examine Querystring

$UrlToPost = $_GET['url'];
$TitleToPost = stripslashes($_GET['title']);

// Examine Form Post Variables

switch($_POST['submit_type'])
{
    case 'save':
        $Mode = "save";
        break;
    case 'save previous':
        $Mode = "save_prevpost";
        break;
    case 'save new':
        $Mode = "save_newpost";
        break;
    default:
        $Mode = "notsave";
        break;
}
if ($_POST['btn_title'] == "get page title")

    $Mode = "get_title";

if (($Mode == "save") or ($Mode == "save_prevpost") or ($Mode == "save_newpost"))
{
    require('db_con.php');
    // If saving, get data from form
    $frmUrl = $_POST['url'];
    // Strip trailing slash if there is one
    $frmUrl = trim($frmUrl);
    $mylen = strlen($frmUrl);
    if ($frmUrl[$mylen-1] == '/')
        $frmUrl = substr($frmUrl, 0, $mylen-1);
    // Done stripping trailing slash
    // Check for http
    $strbeg = substr($frmUrl, 0, 7);
    if (($strbeg <> 'http://') && ($strbeg <> 'https:/'))
        $frmUrl = 'http://'.$frmUrl;
    // Done checking for http
    // We use htmlspecialchars to prevent XSS
    $frmUrl = htmlspecialchars($frmUrl, ENT_QUOTES, 'UTF-8');
    $frmDescr = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $frmDescr = ltrim($frmDescr);
    $frmTagString = htmlspecialchars($_POST['tags'], ENT_QUOTES, 'UTF-8');
    $frmExtended = htmlspecialchars($_POST['extended'], ENT_QUOTES, 'UTF-8');
    $frmInRotation = $_POST['cb_inrotation'];
    $frmPrivate = $_POST['cb_private'];
}
// ----------------------------------------------------------------------------------------
// Now save stuff if we need to
// If user has previously posted this URL, put both up

if ($Mode == "save")
{
    // First see if this user has posted this URL before
    $queryURL = "SELECT URLID FROM URL WHERE URL = '" . $frmUrl . "'";
    $resultd =  mysql_query($queryURL) or die (mysql_error()."<br />Couldn't execute query: $queryURL");
    $num_results = mysql_num_rows($resultd);
    if ($num_results == 0)
    {
        // No one has ever posted this URL
        // Add it to table URL
        $myInsStmt1 = "INSERT INTO URL (URL) VALUES ('" . $frmUrl . "')";
        $result7 = mysql_query($myInsStmt1) or die (mysql_error()."<br />Couldn't execute query: $myInsStmt1");
        $url_id = mysql_insert_id();

        // This user has not posted this URL
        UserSite_add ($theusername, $frmDescr, $url_id, $frmExtended, $frmTagString, $frmInRotation, $frmPrivate);

    } // if num_results is 0
    else
    {  // Someone has posted this URL
        // Now see if this user has
        $rowd = mysql_fetch_array($resultd);
        $myURLID = $rowd['URLID'];
        $querySiteInfo = "SELECT UserSiteID, SiteDescr, URLID, ExtendedDesc, InRotation, Private FROM UserSite WHERE URLID=" . $myURLID . " AND UserID='". $theusername ."'";
        $resultg = mysql_query($querySiteInfo) or die (mysql_error()."<br />Couldn't execute query: $querySiteInfo");
        $thenum = mysql_num_rows($resultg);
        if ($thenum == 0)
        {
            // This user has not posted this URL before
            UserSite_add ($theusername, $frmDescr, $myURLID, $frmExtended, $frmTagString,$frmInRotation, $frmPrivate);
        }
        else
        {
            // this user has posted this URL before

            show_header();
            print "You have posted this URL before.<br>";
            print "Instructions: Make whatever changes you would like in EITHER your previous post or your new post.";
            print "Then click either Save Previous or Save New.";
            print "<br>Here is your previous post:<br>";
            $row = mysql_fetch_array($resultg);
            $siteSiteName = $row['SiteDescr'];
            $siteExtended = $row['ExtendedDesc'];
            $siteInRotation = $row['InRotation'];
            $sitePrivate = $row['Private'];
            $querySTags =  "SELECT Tag FROM UserSiteTag WHERE URLID=" . $myURLID . " AND UserID='". $theusername ."'";
            $result4 = mysql_query($querySTags) or die (mysql_error()."<br />Couldn't execute query: $querySTags");
            $theTagString = TagString($result4);
            show_form_fixedurl($frmUrl, $siteSiteName, $siteExtended, $theTagString, $theTagString, "save previous", $myURLID, $siteInRotation, $sitePrivate);
            print "<br><br>Here is your new post:<br>";
            show_form_fixedurl($frmUrl, $frmDescr, $frmExtended, $frmTagString, $theTagString, "save new", $myURLID, $frmInRotation, $frmPrivate);
            print "</div>";
        }
    }
} // if mode = save
// ----------------------------------------------------------------------------------------
if (($Mode == "save_prevpost") or ($Mode == "save_newpost"))
{
// Save when we have put up two choices

    $frmSiteURLID = $_POST['siteediting'];

    $OldTags = $_POST['oldtagstring'];
    if ($Mode == "save_prevpost") {
        $myUpStmt = "UPDATE UserSite SET SiteDescr = '$frmDescr', ExtendedDesc = '$frmExtended', InRotation = '$dbInro', Private = '$dbPriv' WHERE UserID = '$theusername' AND URLID = $frmSiteURLID";
    } else {
        $myUpStmt = "UPDATE UserSite SET SiteDescr = '$frmDescr', ExtendedDesc = '$frmExtended', InRotation = '$dbInro', Private = '$dbPriv', OrigPostingTime = NOW() WHERE UserID = '$theusername' AND URLID = $frmSiteURLID";
    }
    $result5 = mysql_query($myUpStmt) or die (mysql_error()."<br />Couldn't execute query: $myUpStmt");
    //print "data has been updated";
    if ($frmTagString <> $OldTags)
    {
        $myDelStmt = "DELETE FROM UserSiteTag WHERE URLID =" . $frmSiteURLID . " AND UserID='". $theusername ."'";
        $result6 = mysql_query($myDelStmt) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt");
        //  parse out the tags and write them to db
        $MyArray = explode(' ',$frmTagString);
        foreach ($MyArray as $theTag)
        {
            If (strlen($theTag) > 0)
            {
                $myInsStmt = "INSERT INTO UserSiteTag (UserID, URLID, Tag) VALUES ('" . $theusername ."',". $frmSiteURLID ." , '". $theTag . "')";
                $result7 = mysql_query($myInsStmt) or die (mysql_error()."<br />Couldn't execute query: $myInsStmt");
            }
        }
    }
// redirect
$thelocstring = "Location: http://".$sitename."/bookmarks/bookmarks.php?user=". $nameofuser ."&sortkey=postdate";
header ($thelocstring);
exit();
} // if mode = save_prevpost or save_newpost
// ----------------------------------------------------------------------------------------
// End of saving stuff
// ----------------------------------------------------------------------------------------

if ($Mode == "get_title")
{
    $frmURL = $_POST['url'];
    $Title_Of_Page = ac_Get_Title_From_Page($frmURL, "2048");
    $UrlToPost = $frmURL;
    $TitleToPost = $Title_Of_Page;
    $Mode = "notsave";
}
// end of mode = get_title
?>
<?php
// Just show the form
if ($Mode == "notsave")
{
    show_header();
    show_form($UrlToPost, $TitleToPost,"","");
    print "</div>";
}
// ----------------------------------------------------------------------------------------
// This is what happens if the username is not recognized
}
else
{
    require('bkbottom.php');
}
?>
<script type="text/javascript" src="js/bookpost.js"></script>
</body>
</html>
