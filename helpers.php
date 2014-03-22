<?php
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
?>