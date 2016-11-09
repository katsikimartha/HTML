<?php
//connection to the database
session_start();
include_once 'dbconnect.php';

//checking if the user has logged in. If not, then it opens the page 'index.php' so he can log in
//in order to sumbit a tutorial the user must log in to the page
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

<script>
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	
	var description = _('respond_textarea');
	var value = _('respond_textarea').value;
	var titlet = _('title');
	var valuet = _('title').value;
	var useri = _('user');
	var valueu = _('user').value;
	var rep = _('reply');
	var valuer = _('reply').value;
	var met = _('metadata');
	var valuem = _('metadata').value;
	var file = _("file1").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file1", file);
	formdata.append("respond_textarea", value);
	formdata.append("title", valuet);
	formdata.append("user", valueu);
	formdata.append("reply", valuer);
	formdata.append("metadata", valuem);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "upload.php");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}
</script>

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

<!--When the size of the page is getting smaller, not all the categories will be shown. Instead an image appears which has a link. When clicked it calls the function below which will open the navigation as a drop-down-->
<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>

<!--When the user has logged in, a message appears saying 'hello' and the link to the page where he will log out when clicked('logout.php') -->
<div class="col-1>
   <div id="right">
       &nbsp;&nbsp;Hello <?php echo $userRow['username']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
    </div>
</div>

<div class="col-12">
    <h1 align="center">Submit your tutorial!</h1>
<!--in the form the user chooses a title, description and uploads his files. We also use hidden inputs to retrieve the username and define that this tutorial is not a reply to a question. When he clicks the submit button, then the upload page will open where it will store in the database the title, the description and the path of the files because the files will be stored on the server not in the database.-->
<div align="center">
          <form id="upload_form" enctype="multipart/form-data" method="post">
               <br>
               <h3 align="center">Choose a title:</h3>
               <input type="text" name="title" id="title">
               <br><br>
               <h4 align="center">Description:</h4><br>
               <textarea rows="4" cols="50" name="respond_textarea" id="respond_textarea" maxlength="150" required></textarea> <!--answer question input-->
               <input type=hidden name="user" id="user" value="<?php echo $userRow['username']; ?>">
               <input type=hidden name="reply" id="reply" value="0">
               <br><br>
               <h4 align="center">Keywords:</h4>&nbsp;&nbsp;<input type="text" name="metadata" id="metadata"><br><p>e.g. tshirt,bag,fabric etc</p>
               <br><br><br>
               <input type="file" name="file1" id="file1"><br><br>
               <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
               <br><br>
               <h3 align="center">Upload your files:</h3>
               <input type="button" value="Upload File" onclick="uploadFile()">
               <br><br>
               <h3 id="status"></h3>
               <p id="loaded_n_total"></p>
          </form>
</div>
</div>
</div>


</div>

<!--the footer includes the links to the social media-->
<div class="col-12">
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