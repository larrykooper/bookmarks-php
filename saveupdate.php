<?php
session_start();
require('ckuser.php');
require_once('db_con.php');
$Deleting = 0;
$frmPrivate = "n";
$frmInRotation = "y";
if ($_POST['submit'] == "save")
{
    $Mode = "save";
}
elseif ($_POST['submit'] == "delete")
{
    $Mode = "delete";
    $Deleting = 1;
    $SiteToDelete = $_POST['siteediting'];
}
else
{
    $Mode = "notsave";
}

$frmNewPage = $_POST['redirectURL'];

If ($Deleting)
{
    $myDelStmt1 = "DELETE FROM UserSiteTag WHERE URLID =" . $SiteToDelete . " AND UserID='". $theusername ."'";
    $result6 = mysql_query($myDelStmt1) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt1");
    $myDelStmt2 = "DELETE FROM UserSite WHERE URLID =" . $SiteToDelete . " AND UserID ='" . $theusername ."'";
    $result6 = mysql_query($myDelStmt2) or die (mysql_error()."<br />Couldn't execute query: $myDelStmt2");
}  // end if deleting

// Now save stuff if we need to -- delete this code
if ($Mode == "save")
{
    // Get data from form
    $frmDescr = $_POST['description'];
    $frmDescr = addslashes($frmDescr);
    $frmExtended = $_POST['extended'];
    $frmTagString = $_POST['tags'];
    $frmSiteEditing = $_POST['siteediting'];
    if (array_key_exists('cb_inrotation', $_POST)) {
        $frmInRotation = $_POST['cb_inrotation'];
    } else {
        $frmInRotation = 'n';
    }
    if (array_key_exists('cb_private', $_POST)) {
        $frmPrivate = $_POST['cb_private'];
    } else {
        $frmPrivate = 'n';
    }
    $OldTags = $_POST['oldtagstring'];

    if ($frmInRotation == "y") {
        $dbInro = 1;
    } else {
        $dbInro = 0;
    }
    if ($frmPrivate == "y") {
        $dbPriv = 1;
    } else {
        $dbPriv = 0;
    }
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
    }   // if new tags differ from old tags
} // if mode = save

// End of saving stuff
header('Location: '.$frmNewPage);
die();
?>
