<?php
session_start();
include_once 'dbconnect.php';
//The admin is the only one who has access to this page. He checks the comments, submitted by users, for every question and he can either approve them or //delete them from the database. If the comments are approved then it will be shown in the page.They weren't visible before.
//if the user hasn't logged in, the index page will be opened so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

//if the admin clicks the button 'Delete', then this method is called.
if(isset($_POST['delete-comment']))
{
      //retrieve values from form
      $name = mysql_real_escape_string($_POST['user']);
      $id = mysql_real_escape_string($_POST['id']);
      $title = mysql_real_escape_string($_POST['title']);
      $comment = mysql_real_escape_string($_POST['comment']);

      //when we delete a row, we also need to check that the id from the remaining rows will change as well. For example, if the table comments has 7 rows           //and we delete row 5, then the rows 6 & 7 will change to 5 & 6.
      $c = mysql_query("SELECT id FROM Comments WHERE Comments.id  > '$id' ORDER BY Comments.id DESC");
      $t = $id;//this variable will keep the id from the comment which the admin deletes.

      //if the command DELETE is successful, then we change the id for every row with id>del_id as we mentioned above.
      if(mysql_query("DELETE FROM Comments WHERE Comments.title = '$title' AND Comments.comment='$comment'")){
            
            $count = mysql_num_rows($c); 

            for($i=0; $i<$count; $i++){
                   
                   mysql_query("UPDATE Comments SET Comments.id =". $t++ . " WHERE Comments.id  > '$id' ORDER BY Comments.id DESC");
                   
            }
      }
}

//if the comment has been approved, then the method 'approve-comment' is called
if(isset($_POST['approve-comment']))
{
      $name = mysql_real_escape_string($_POST['user']);
      $id = mysql_real_escape_string($_POST['id']);
      $title = mysql_real_escape_string($_POST['title']);
      $comment = mysql_real_escape_string($_POST['comment']);

      //in order to show a comment has been approved, we need to change the column "approved" from 0 to 1. Then it will displayed in the question's page.
      mysql_query("UPDATE Comments SET Comments.approved = 1 WHERE Comments.title = '$title' AND Comments.comment='$comment' ");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome</title>
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

<div class="col-12">
    <?php
        //since we have been connected to the database, we can get the data
        $query = "SELECT * FROM Comments ORDER BY Comments.id ASC";
	$result = mysql_query($query);
        $a=0;//will be used as a Pre-increment operator
	
	//we count the query results and check if the table is empty
        if(mysql_num_rows($result)>0) {
                  // output data of each row
                   while($row = mysql_fetch_assoc($result)) {
                            //output data from table Comments. The comments which will be displayed are only those that haven't been approved yet.
                            if ($row["approved"] != "1" ) {
                                   echo "<br> ". 	++$a. ") Title: ". $row["title"]. " User: " . $row["user"]. "  Comment: " . $row["comment"].  " ";
       ?>
	<!--this form will  contain the selected user's data and the "delete" button, since the admin can delete any of the users, but also the 'approve' button, so he can approve the comment he thinks is appropriate and can be displayed in the site.-->
       <form method=post>
             <input type=hidden name="id" value="<?php echo $row["id"]; ?>">
             <input type=hidden name="user" value="<?php echo $row["user"]; ?>">
             <input type=hidden name="title" value="<?php echo $row["title"]; ?>">
             <input type=hidden name="comment" value="<?php echo $row["comment"]; ?>">
             <button type="submit" name="approve-comment">Approve</button>&nbsp;
             <button type="submit" name="delete-comment">Delete</button><br>
       </form> 
       <?php
                            }// end - if -> aprroved
                   }//end - while
        } //end - if >0
    ?>
</div>
<!--
<div class="col-6"></div>
-->
</div>
</div>
</body>
</html>