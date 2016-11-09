<?php
//connection - database
session_start();
include_once 'dbconnect.php';

//checking if the user has logged in. If not, then it opens the page 'index.php' so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

//submit question when this method is called.
if(isset($_POST['rsubmit']))
{
        //get data - form/method post
	$rtitle = mysql_real_escape_string($_POST['title']);
	$tarea = mysql_real_escape_string($_POST['description']);
	
	//check if request exists or not
        //we check if there is the same title as the one submitted
	$query = "SELECT title FROM Requests WHERE title='$rtitle'";
	$result = mysql_query($query);

	$count = mysql_num_rows($result); // if request not found then submit (count==0)
        
        if($count == 0){
		//insert values from <input> into the database, set approved column '0' for this row since the admin hasn't approved the question yet.
		if(mysql_query("INSERT INTO Requests(title,info,approved) VALUES('$rtitle','$tarea','0')"))
		{
                        //if the submission is successful then we add data to the other columns as well
                        
                        //and we insert the username of the person who submitted this request
                        mysql_query("UPDATE Requests,Users SET Requests.user=Users.username WHERE Requests.title='$rtitle' AND Users.user_id=".$_SESSION['user']);
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
		}		
	}
	else{
			?>
                        //if count !=0 then this means that a request with the same title already exists
			<script>alert('Sorry, this request already exists...');</script>
			<?php
	}
}
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

<!--When the size of the page is getting smaller, not all the categories will be shown. Instead an image appears which has a link. When clicked it calls the function below which will open the navigation as a drop-down-->
<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>

<!--When the user has logged in, a message appears saying 'hello' and the link to the page where he will log out when clicked('logout.php') -->
<div class="col-2">
   <div id="left">
       &nbsp;&nbsp;Hello <?php echo $userRow['username']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
    </div>
</div>
<div class="col-12">
<h1 align="center">Submit your question!</h1>
<!--The user will write down the title and description about his question in the form below and when he clicks the button the data will be stored in the database. This form calls the method 'rsubmit' when the button is clicked.-->
<div align = "center">
          <form method="post">
                 <h3 align="center">Choose a title:</h3>
                 <input type="text" name="title" id="title">
                 <br><br>
                 <br>
                 <h3 align="center">Description:</h3>
                 <br>
                 <textarea rows="4" cols="50" name="description" maxlength="150" required></textarea><br><br><br>
                 <button type="submit" name="rsubmit">Submit</button>
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