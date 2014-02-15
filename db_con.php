<?php
// Open connection to MYSQL database 

$file = 'dbsettings.ini';

if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

$dbh=mysql_connect ($settings['database']['host'], $settings['database']['username'], $settings['database']['password']) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db($settings['database']['database']);

?>