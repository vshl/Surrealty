<?php

/**
 * This file will handle the ajax request for uploading a profile picture
 */
include "../controllers/ImageController.php";
//include "../classes/Logging.php";
//$logger = new Logging();
//$logger->logToFile("pictureUpload", "info", "picture upload instanced");
// check if files in the post 
if(isset($_GET['files'])) {
    
    $ic = new ImageController();
    $error = false;
    $files = array();
    $uploaddir = '../images/';
    foreach($_FILES as $file) {
		if(move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name'])))
		{
                    //$logger->logToFile("pictureUpload", "info", "move " . $file['tmp_name'] . "to " . $uploaddir . basename($file['name']));
                    $imageID = $ic->uploadPicture(1, basename($file['name']) );
                    //$logger->logToFile("pictureUpload", "info", "hash value is: " . $imageID);
                    $ic->deletePictureByFileName(basename($file['name']));
                    echo $imageID;
		}
		else
		{
		    $error = true;
		}
    }
    unset($ic);
   // unset($logger);
    
}

?>
