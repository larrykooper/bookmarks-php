<?php
session_start();
require('ckuser.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="bkm.css">
<title>LarryBeth Bookmarks Privacy Policy</title>
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
?>
<div class="LBBRight"><div class='LBBRightTitle'></div></div>
<div class="LBBMain">
		
	<?php	
If ($validated) 
{
	echo '<p class="hello">Welcome, '.$theusername.' </p>';		
}
?>
		

<p class="help">Bookmarks LarryBeth Style Privacy Policy</p>
<ul>
<li>Bookmarks, LarryBeth Style, does not rent, sell, or share personal information about you with other people or companies.</li>  

<li>You can browse the site without telling us who you are or revealing any personal information about yourself.</li> 

</ul>

<p class="help">Information We Collect</p>
<ul>
<li>When you register on  Bookmarks LarryBeth Style, we ask you for your 
name and your email address.</li> 

<li>Bookmarks LarryBeth Style allows you to save a list of your favorite web sites.</li> 
<li>When you visit bookmark links that you have set up on Bookmarks LarryBeth Style, Bookmarks LarryBeth Style records the site you have visited and the time you visited.   We do this so that you can keep track of which sites you visit and when you visit them.</li>
<li>Bookmarks LarryBeth Style uses information we collect to improve our services, and to email you your password at your request.</li>

</ul>



<p class="help">Cookies</p>

<ul>	
<li>Bookmarks LarryBeth Style may set and access cookies on your computer.  We do this to allow you to visit the site without logging in each time you visit.</li>

</ul>

<p class="help">Your Ability to Edit and Delete Your Account Information</p>
<ul>
<li>You can <a class="body" href="editprofile.php">edit</a> your LarryBeth Profile at any time.</li>
<li>You can delete your Bookmarks LarryBeth Style account by visiting our <a class="body" href="deregister.php">Account Deletion</a> page. </li></ul>

If you have questions or suggestions, please <a href="mailto:bookmarks-comments@larrybeth.com?subject=Bookmarks" class="body"> email us</a>.

</div>
</div>
</div>
</body>
</html>
