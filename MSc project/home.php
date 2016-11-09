<?php
session_start();
include_once 'dbconnect.php';

//if the user hasn't logged in, the index page will be opened so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link rel="stylesheet" href="/hstyle.css" type="text/css" />
</head>
<body>
<div class="row">
<div class="header">
</div>
<ul class="topnav">
  <li><a class="active" href="/check.php">Home</a></li>
  <li><a href="submit-question.php">New Question</a></li>
  <li><a href="submit-new-clothing-tutorial.php">New Tutorial</a></li>
  <li><a href="tutorial-menu.php">Tutorials</a></li>
  <li><a href="questions-menu.php">Questions</a></li>
  <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><img border="0" alt="menu" src="/menu.png" width="15" height="5"></a>
  </li>
</ul>

<!--When the size of the page is getting smaller, not all the categories (from the ul list above) will be shown. Instead an image appears which has a link. When clicked it calls the function below which will open the navigation as a drop-down-->
<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>

<!--When the user has logged in, a message appears saying 'hello' and the link to the page where he will log out when clicked('logout.php') -->
<div class="col-3">
   <div id="left">
       &nbsp;&nbsp;Hello <?php echo $userRow['username']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
    </div>
</div>
<div class="col-12">
<h1 align="center">"Make your own" clothing tutorials</h1>

<!--The home page for users (only if they have logged in, it will open) has two links which lead to the other pages, depending on the user chooses. He can submit a request or a new tutorial-->
    <h2 align="center">Submit your tutorial!</h2>
    <div align="center">
         <a href="submit-new-clothing-tutorial.php" >Click Here</a>
    </div>
    <h2 align="center">Submit a new question!</h2>
    <div align="center">
          <a href="submit-question.php" >Click Here</a>
    </div>

<!--video width="200" controls>
  <source src="" type="video/mov"-->
</video>
</div>
</div>

<!--the footer includes the links to the social media-->
<div class=col-12">
<div class="footer2" id="ftr">
    <ul class="footr">
        <li><img border="0" alt="fb" align="middle" src="/img/facebook.png" width="15" height="15" hspace="12"></li>
        <li><img border="0" alt="tw" align="middle" src="/img/twitter.png" width="15" height="15" hspace="12"></li>
        <li><img border="0" alt="tw" align="middle" src="/img/instagram.png" width="15" height="15" hspace="12"></li>
        <li><img border="0" alt="tw" align="middle" src="/img/pinterest.png" width="15" height="15" hspace="12"></li>
        <li><img border="0" alt="tw" align="middle" src="/img/snapchat.png" width="15" height="15" hspace="12"></li>
        <li><img border="0" alt="tw" align="middle" src="/img/rss.png" width="15" height="15" hspace="12"></li>
    </ul>
</div>
</div>

</body>
</html>