<?php
session_start();
include_once 'dbconnect.php';

//The admin is the only one who has access to this page. He checks the users who have signed up and he can delete them from the database.

//if the user hasn't logged in, the index page will be opened so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

//if the admin clicks the button 'Delete', then this method is called.
if(isset($_POST['delete-user']))
{
      $name = mysql_real_escape_string($_POST['username']);
      $id = mysql_real_escape_string($_POST['id']);
      $email = mysql_real_escape_string($_POST['email']);

      //if the command DELETE is successful, then we change the id for every row with id>del_id as we mentioned above.
      if(mysql_query("DELETE FROM Users WHERE Users.username = '$name'")) {
                  
            mysql_query("UPDATE Users SET Users.user_id = user_id - 1 WHERE Users.user_id  > '$id'");
                   
      }//end - if
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
        $query = "SELECT * FROM Users ORDER BY Users.user_id ASC";
	$result = mysql_query($query);
        $a = 0;
	
	//we count the query results and check if the table is empty
        if(mysql_num_rows($result)>0) {
                  // output data of each row
                   while($row = mysql_fetch_assoc($result)) {
                            //only the users will be shown, the administrator can delete any of the users from the list.
                            if ($row["username"] != "Admin" ) {
                                   echo "<br> ". ++$a. ") Username: ". $row["username"]. " Email: " . $row["email"]. "  ";
       ?>
	<!--this form will  contain the selected user's data and the "delete" button, since the admin can delete any of the users.-->
       <form method=post>
             <input type=hidden name="id" value="<?php echo $row["user_id"]; ?>">
             <input type=hidden name="username" value="<?php echo $row["username"]; ?>">
             <input type=hidden name="email" value="<?php echo $row["email"]; ?>">
             <button type="submit" name="delete-user">Delete</button><br>
       </form> 
       <?php
                            }//end-if - admin
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