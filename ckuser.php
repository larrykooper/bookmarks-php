<?php
session_start();
error_log("I am in ckuser");
$validated = 0;
if (array_key_exists('valid_user', $_SESSION)) {
    $validated = 1;
    error_log("ckuser: user found in session");
}
else
// username is not in the session
// check cookie
{
    error_log("ckuser: User not in session");
    $ckun = $_COOKIE['uu'];
    $ckpw = $_COOKIE['pp'];  
    require_once('db_con.php'); 
    $UNquery = "SELECT UserID, Password FROM User WHERE UserID='$ckun' and Password=PASSWORD('$ckpw')";
    $UNresult = mysql_query($UNquery) or die (mysql_error()."<br />Couldn't execute query: $UNquery");
    if (mysql_num_rows($UNresult) > 0 )
    {
        // If user is found in database, register the user id   
        error_log("ckuser: User found in database");
        $validated = 1; 
        $_SESSION['valid_user'] = $ckun;
    }   
}
if ($validated)
{
    $theusername = $_SESSION['valid_user'];
} 
