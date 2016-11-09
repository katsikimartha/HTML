<?php
        //this page will show the information for a specific request. Users can submit a comment or upload tutorials as an answer to the request only if they have
        //registered/logged in. But anyone can see the previous comments posted.
        include_once 'dbconnect.php';
        session_start();

//checking if the user has logged in. If not, then it opens the page 'index.php' so he can log in
//in order to sumbit a tutorial the user must log in to the page.
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}

if(isset($_POST['comments']))
{
     
     //taking the data from input
     $rtitle = mysql_real_escape_string($_POST['title']);
     $tcomments = mysql_real_escape_string($_POST['respond_textarea']);
     
     //the news comments, which will be added to the database by the user, must be approved by the administrator before are shown on the
     //website. So we set the column "approved" to be 0 at the beginning. When the administrator reads the comments and decides that they can
     //be posted, he will change the value from 0 to 1. Those comments will be posted, otherwise they will be deleted from the database. 
  
     //insert values from <input> into the database
     if(mysql_query("INSERT INTO Comments(title,comment,approved) VALUES('$rtitle','$tcomments ','0')"))
     {
     
                        //if the submission is successful then we add data to the other columns as well
                        //for every new entry we increase the id by 1
                        mysql_query("UPDATE Comments SET id =id + 1");

                        //and we insert the username of the person who submitted this comment
                        mysql_query("UPDATE Comments,Users SET Comments.user=Users.username WHERE Comments.comment='$tcomments' AND Users.user_id=".$_SESSION['user']);
                        //when it is complete we transfer to the home page
                        ?>
                        <script>alert('successfully submitted');</script>
                        <?php
                                header("Location: home.php");
    }
    else
    {
      //in case the if-insert query does not work, this function returns the text of the error message from the  previous MySQL operation
      die(mysql_error());
      ?>
                        <!--in case of failure to insert data, a message appears-->
                        <script>alert('error while submitting your request...');</script>
                        <?php
                                //header("Location: questions-menu.php");
    } 
     
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Make your own clothing tutorials></title>
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
	var valuerep = _('reply').value;
	var met = _('metadata');
	var valuem = _('metadata').value;
	var file = _("file1").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file1", file);
	formdata.append("respond_textarea", value);
	formdata.append("title", valuet);
	formdata.append("user", valueu);
	formdata.append("reply", valuerep);
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

<!--When the size of the page is getting smaller, not all the categories (from the ul list above) will be shown. Instead an image appears which has a link. When clicked it calls the function below which will open the navigation as a drop-down-->
<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>

<div class="col-12">
<!-- The logo of the company will be shown. With the use of CSS, it will be at right of the page/body.-->
<!--div id="logo">
     <div class="col-3">
            <img border="0" alt="logo" align="middle" src="/img/logo.jpg"  style="float:center" width="100" height="100">
     </div>
</div-->


<div align="center">
<!-- Checking the post method from the page 'questions-menu.php'. If it is set then we take the values from the input in the form.-->
        <?php
              if(isset($_POST['btn-answer']))
              {
                     //$test = htmlspecialchars($_POST['title']);
	             $title = mysql_real_escape_string($_POST['title']);
                     $info  = mysql_real_escape_string($_POST['info']);
                     $user  = mysql_real_escape_string($_POST['user']);
              }
        ?>
         
        <!-- We use the values taken from the previous page.-->
        <h3 align="center"><?php echo $title; ?></h3> 
        <br>
              <textarea rows="4" cols="50" readonly><?php echo $info; ?></textarea>
              <br><br><?php echo $user; ?>
        <br><br>
        <h4 align="center">Comments</h4> 
        <br>

         <!-- The user can submit a comment. The form below will keep the value (title) from above in a hidden input. There is a textarea where the user will      write what he wants and the button which, when clicked, it will call the method post (see the php code above).-->
             <!-- Users can not only submit comments but also upload files (tutorials) as an answer to the request. This form will call the page upload.php just like we did in the page 'submit-new-clothing-tutorial.php' . -->
             <!-- The user can choose if he wants to submit a video and not just a comment, but it's not mandatory. In the question below ("Do you want to upload video?"), if he clicks 'No' then he will just submit a comment (which will be waiting to be approved by the user), otherwise the method UploadFile() will be called in order to submit the video which will be stored on the server but its information (title, description,path etc) will be inserted into the database.  -->
        <!--div align="center"-->
              <form id="upload_form" enctype="multipart/form-data" method="post">
                 <br>
                 <input type=hidden name="title" id="title" value="<?php echo $title; ?>">
                 <br>
                 <textarea rows="4" cols="50" name="respond_textarea" id="respond_textarea" maxlength="150" required></textarea><br><br><br>
                 <input type=hidden name="user" id="user" value="<?php echo $user; ?>">
                 <input type=hidden name="reply" id="reply" value="1">
                 <br><br><br>
                 <input type="file" name="file1" id="file1"><br><br>
                 <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                 <br><br>
                 <h4 align="center">Keywords:</h4>&nbsp;&nbsp;<input type="text" name="metadata" id="metadata"><br><p>e.g. tshirt,bag,fabric etc</p><br><br>
                 <h3 align="center">Upload your files:</h3>
                 <h4 align="center">Do you want to upload video?</h4>
                 <input type="button" value="Yes" onclick="uploadFile()">&nbsp;
                 <button type="submit" name="comments">No</button>
                 <br><br>
                 <h3 id="status"></h3>
                 <p id="loaded_n_total"></p>
              </form>
        <!--/div-->


<!-- Here the previous comments submitted by users will be shown. We select only the comments which have been approved by the admin.-->

    <div class="col-4">
              <?php
                        if(isset($_POST['btn-answer']))
                        {
	                        $title = mysql_real_escape_string($_POST['title']);
                                //this POST method (questions-menu.php) calls this page, we need the title from the question the user chose to read, so we retrieve the 
                                //value from the form in the 'questions-menu' page.
                        }
                       
                       $res=mysql_query("SELECT * FROM Comments WHERE approved='1' AND title='$title'");
                       
                       $count = mysql_num_rows($res);
                       
                       //we count the rows from the table Comments. If there are comments, then we show the title below and the columns 'comment' and 'user'
                       if($count !=0) {
              ?>
              <h4 align="center">Previous Comments</h4> 
              <?php  
                       }   
                           while($row = mysql_fetch_assoc($res)) 
                           {      
                                    echo "<br> ". $row["comment"]. " - ".$row["user"]. "<br>";
                           }
              ?>
    </div>

    <div class="col-4">
              <?php
                        
                        //we do the same for the video which users uploaded as an answer to the question ( reply='1') and have been approved by the admin 
                        //(approved='1'). If there are video, then they will be displayed as well as the username and the description.
                        if(isset($_POST['btn-answer']))
                        {
	                        $title = mysql_real_escape_string($_POST['title']);
              
                        }
                       
                       $res=mysql_query("SELECT * FROM VideoInfo WHERE approved='1' AND title='$title' AND reply='1'");
                       
                       $count = mysql_num_rows($res); 
                         
                       if($count !=0) {
              ?>
              <h4 align="center">Video - Reply</h4> 
              <?php  
                       }   
                           while($row = mysql_fetch_assoc($res)) 
                           {      
                                    echo "<br> ". $row["description"]. " - ".$row["user"]. "<br>";
                                    echo "<video width='100' height='120' controls><source src='". $row["path"]."' type='video/mp4'> </video>";
                           }
              ?>
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