<?php

include_once 'dbconnect.php';

$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true

//retrieve data from method uploadFile() when it's called (it is used in multiple pages)
$AnswerText = $_POST['respond_textarea']; //define answer text from incoming POST variable 
$title= $_POST['title']; //define a title for the tutorial
$user= $_POST['user']; //keep the name of the user who uploads the video
$metdt= $_POST['metadata']; //keep metadata -> uploaded video
$r = $_POST['reply']; //define if tutorial is a reply to a question: 1 if it is, otherwise 0

$allowed_extensions = ("mp4"); //define video type
$file_size_max = 2147483648; //define max video size to 2Mb
$pattern = implode ($allowed_extensions, "|");

$videoUrl = "../uploads/" .   $_FILES["file1"]["name"];

    if (!empty($fileName)) { //check a file is recieved	
	
        if ($fileSize < $file_size_max) { //check file size against max file size
			
            if ($fileType == "video/mp4") { //check file type is mp4 format
				
                if ($_FILES['file1']['error'] > 0) {
					
                    echo "Unexpected error occured, please try again later.";
					
                } else {
					
                    if (file_exists("../uploads/".$fileName)) { //check if video exists in the upload folder
						
                        echo $fileName." already exists!!<br>Please rename the file or choose a different video file!";
						echo'<br>';
						
                    } else if(move_uploaded_file($_FILES["file1"]["tmp_name"], "../uploads/" .   $_FILES["file1"]["name"])) {
						
						    echo "$fileName upload is complete"; //if the file has been uploaded, then we insert into the database the the video's info.
							
		                                    mysql_query("INSERT INTO VideoInfo(path,title,description,user,approved,reply,metadata) VALUES ('$videoUrl', '$title', '$AnswerText','$user','0','$r','$metdt')");
		                                   
						} else {
							
							echo "move_uploaded_file function failed";
							exit;
						        }
                	}
				
            } else {
				
                echo "Invalid video format. Video must be in mp4 format!";
				echo'<br>';
				
            }
			
        }else{
			
            echo "Please ensure video file size is no bigger than 2Mb";
			echo'<br>';
			
        }
		
    } else { //end check file is recieved
	}
?>