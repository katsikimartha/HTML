<?php
session_start();
include_once 'dbconnect.php';

//The admin is the only one who has access to this page. He checks the videos, submitted by users, and he can either approve them or 
//delete them from the database. If the comments have been approved then it will be shown in the page. They weren't visible before.

//if the user hasn't logged in, the index page will be opened so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

//if the admin clicks the button 'Delete', then this method is called.
if(isset($_POST['delete-video']))
{
      //retrieve values from form
      $name = mysql_real_escape_string($_POST['user']);
      $title = mysql_real_escape_string($_POST['title']);
      $description = mysql_real_escape_string($_POST['description']);

      //delete the row of the database which includes all the info for this video/tutorial.
      mysql_query("DELETE FROM VideoInfo WHERE VideoInfo.title = '$title' AND VideoInfo.description='$description'");
}

//if the comment has been approved, then the method 'approve-comment' is called
if(isset($_POST['approve-video']))
{
      //retrieve values from form
      $name = mysql_real_escape_string($_POST['user']);
      $title = mysql_real_escape_string($_POST['title']);
      $description = mysql_real_escape_string($_POST['description']);

      //in order to show that a video has been approved, we need to change the column "approved" from 0 to 1. Then it will be displayed in the menu page.
      mysql_query("UPDATE VideoInfo SET VideoInfo.approved = 1 WHERE VideoInfo.title = '$title' AND VideoInfo.description='$description' ");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome </title>
<link rel="stylesheet" href="/hstyle.css" type="text/css" />
</head>
<body>
<div class="row">
<div class="header">
</div>
<ul class="topnav">
  <li><a class="active" href="admin-home.php">Home</a></li>
  <li><a href="users.php">Users</a></li>
  <li><a href="tutorials.php">Tutorials</a></li>
  <li><a href="questions.php">Questions</a></li>
  <li><a href="comments.php">Comments</a></li>
  <li><a href="tutorial-comments.php">Video Comments</a></li>
  <li><a href="logout.php?logout">Sign Out</a></li>
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

<div class="col-4">
    <?php
        //since we have been connected to the database, we can get the data
        $query = "SELECT * FROM VideoInfo";
	$result = mysql_query($query);
        $a=0;
	
	//we count the query results and check if the table is empty
        if(mysql_num_rows($result)>0) {
                  // output data of each row
                   while($row = mysql_fetch_assoc($result)) {
                            //output data from table VideoInfo.  The video which will be displayed are only those that haven't been approved yet.
                            if ($row["approved"] != "1" ) {
                                   echo "<br> ". 	++$a. ") Title: ". $row["title"]. " User: " . $row["user"]. "  Description: " . $row["description"].  " <br> ";
                                   
                                   echo "<video width='100' height='120' controls><source src='". $row["path"]."' type='video/mp4'> </video>";
       ?>
	<!--this form will contain the selected user's data and the "delete" button, since the admin can delete any of the users, but also the 'approve' button, so he can approve the video he thinks is appropriate and can be displayed in the site.-->
       <form method=post>
             <!--input type=hidden name="vpath" value="<?php echo $row["path"]; ?>"-->
             <input type=hidden name="user" value="<?php echo $row["user"]; ?>">
             <input type=hidden name="title" value="<?php echo $row["title"]; ?>">
             <input type=hidden name="description" value="<?php echo $row["description"]; ?>">
             <button type="submit" name="approve-video">Approve</button>&nbsp;
             <button type="submit" name="delete-video">Delete</button><br>
       </form> 
       <?php
                            }// end - if -> aprroved
                   }//end - while
        } //end - if >0
    ?>
</div>

</div>
</div>
</body>
</html>