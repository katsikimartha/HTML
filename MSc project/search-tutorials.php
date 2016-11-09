<?php
include_once 'dbconnect.php';
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

<div class="col-12">
<h1 align="center">Search results:</h1>

<div class="col-6">
    <?php

        if(isset($_POST['tsearch'])) {
              $words= mysql_real_escape_string($_POST['keywords']);
             //this POST method (tutorial-menu.php) calls this page, we need the tile from the question the user chose to read, so we retrieve the 
             //value from the form in the 'tutorial-menu' page.
        }
        //echo "$words";
        $res=mysql_query("SELECT * FROM VideoInfo WHERE approved='1' AND metadata LIKE '%$words%' ");//
        
        $count = mysql_num_rows($res);
	$a=0;

        //we count the rows from the table VideoInfo . If there are video/tutorials, then we show the title below
        if($count !=0) {
                   while($row = mysql_fetch_assoc($res)) 
                           {      
                                    echo "<br> ". ++$a. ") ". $row["title"] . "<br>";              
        ?>
<!--this form will contain a button for each row of the table 'VideoInfo' as well as four input attributes (hidden so the users will not see them on the page) but the form will contain the values of the data for each row. If the user clicks the button then the form's action will be activated and the page 
        "tutorial-page.php" will open and will use the data in the input below with the use of the POST method.    -->
       <form action="tutorial-page.php" method=post>
             <input type=hidden name="title" value="<?php echo $row["title"]; ?>">
             <input type=hidden name="description" value="<?php echo $row["description"]; ?>">
             <input type=hidden name="user" value="<?php echo $row["user"]; ?>">
             <input type=hidden name="path" value="<?php echo $row["path"]; ?>">
             <button type="submit" name="btn-answer">See more</button><br>
       </form> 
       <!--Otherwise if the table is empty a message will be shown.-->
       <?php
                   }//end while
        } else {
                    echo "Oops! No results were found.";
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