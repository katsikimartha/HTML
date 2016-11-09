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

//The admin is the only one who has access to this page. He can read the question, submitted by users, and either delete them or approve them.
//if he chooses to delete them, then the method below is called and deletes the question by removing the row from the database.
//In  addition, the id from the row above the deleted one, reduce their id by 1. 
if(isset($_POST['delete-question']))
{
      $name = mysql_real_escape_string($_POST['user']);
      $id = mysql_real_escape_string($_POST['id']);
      $title = mysql_real_escape_string($_POST['title']);
      $info = mysql_real_escape_string($_POST['info']);

      $c = mysql_query("SELECT id FROM Requests WHERE Requests.id  > '$id' ORDER BY Requests.id DESC");
      $t = $id;

      if(mysql_query("DELETE FROM Requests WHERE Requests.title = '$title' AND Requests.info='$info'")) {
      
            $count = mysql_num_rows($c); 

            for($i=0; $i<$count; $i++){
                   
                   mysql_query("UPDATE Requests SET Requests.id =". $t++ . " WHERE Requests.id  > '$id' ORDER BY Requests.id DESC");
                   
            }
      }
      
}

//if the admin approves the question then the column approved changes from 0 to 1 for this row.
if(isset($_POST['approve-question']))
{
      $name = mysql_real_escape_string($_POST['user']);
      $id = mysql_real_escape_string($_POST['id']);
      $title = mysql_real_escape_string($_POST['title']);
      $info = mysql_real_escape_string($_POST['info']);

      mysql_query("UPDATE Requests SET Requests.approved = 1 WHERE Requests.title = '$title' AND Requests.info='$info' ");
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
        $query = "SELECT * FROM Requests ORDER BY Requests.id ASC";
	$result = mysql_query($query);
        $a=0;
	
	//we count the query results and check if the table is empty
        if(mysql_num_rows($result)>0) {
                  // output data of each row. The question that haven't been approved will be displayed here.
                   while($row = mysql_fetch_assoc($result)) {
                            //output data 
                            if ($row["approved"] != "1" ) {
                                   echo "<br> ". ++$a. ") Title: ". $row["title"]. " User: " . $row["user"]. "  Description: " . $row["info"].  " ";
       ?>
	<!--this form will contain the selected question's data and the "delete" button, since the admin can delete any question, but also the 'Approve' button if he chooses to approve the question.-->
       <form method=post>
             <input type=hidden name="id" value="<?php echo $row["id"]; ?>">
             <input type=hidden name="user" value="<?php echo $row["user"]; ?>">
             <input type=hidden name="title" value="<?php echo $row["title"]; ?>">
             <input type=hidden name="info" value="<?php echo $row["info"]; ?>">
             <button type="submit" name="approve-question">Approve</button>&nbsp;
             <button type="submit" name="delete-question">Delete</button><br>
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