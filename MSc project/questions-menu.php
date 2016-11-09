<?php
        //this page will show the requests which have been submitted by users (and approved by the admin) and they are stored in the database. The user will read only the titles and if he 
        //is interested in any of them, he will click the button 'Read More' which will open the page that includes all the information about the specific request.
        //first we connect to the database.
        include_once 'dbconnect.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Make your own clothing tutorials></title>
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

<!-- The logo of the company will be shown. With the use of CSS, it will be at right of the page/body.-->
<div class="col-12">

<div align="center">
<!--In case someone wants to submit a question that he hasn't found on the list, this link will open the page where he can submit his question-->
    <h2 align="center">Submit your question!&nbsp;<a href="submit-question.php" >Click Here</a></h2>
    <?php
        //since we have been connected to the database, we can take the data sorted in ascending order by the id column, 
       //so the request, which will be at the top, will be the newest one.
       
       //the questions which will be displayed are those which have been approved (approved='1')
        $query = "SELECT * FROM Requests WHERE approved='1' ";
	$result = mysql_query($query);
	$a=0;//will be used as a Pre-increment operator
	
	//we count the query results and check if the table is empty, if it isn't then we show the title for each question
        if(mysql_num_rows($result)>0) {
                  // output data of each row
                   while($row = mysql_fetch_assoc($result)) {
                             //printf ("%s (%s)\n",$row["id"],$row["title"]);
                             echo "<br> ". ++$a. ") ". $row["title"]. "<br><br>";
       ?>
	<!--this form will contain a button for each row of the table 'Requests' as well as three input attributes (hidden so the users will not see them on the page) but the form will contain the values of the data for each row. If the user clicks the button then the form's action will be activated and the page   "question.php" will open and will use the data in the input below with the use of the POST method.    -->
       <form action="question.php" method=post>
             <input type=hidden name="title" value="<?php echo $row["title"]; ?>">
             <input type=hidden name="info" value="<?php echo $row["info"]; ?>">
             <input type=hidden name="user" value="<?php echo $row["user"]; ?>">
             <button type="submit" name="btn-answer">Read more</button><br>
       </form> 
       <!--Otherwise if the table is empty a message will be shown.-->
       <?php
                   }
        } else {
                    echo "There no questions at the moment.";
        }
    ?>
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