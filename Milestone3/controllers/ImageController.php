<?php
/**
 * Model Class for ImageController objects
 * 
 * Image controller will manage access, storage and convert of pictures. 
 * It'll return a unique hash for every uploaded picture. 
 * 
 * It also provide four different sizes for images
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */

include_once '../classes/Logging.php';

define ("PICTURE_DIR", "../images/");
define ("MAX_FILESIZE", "2097152");      // bytes

class ImageController {
    
    public function __construct() {
    }
    
    public function __destruct() {
    }
    
    /**
     * uploadPicture and convert
     * 
     * @param int $type type of picture (1 = user, 2 = property)
     * @param string $picture array from multipart-form
     * @return string name of the uploaded picture 
     */  
    public function uploadPicture( $type, $picture ) {

        $finfo = finfo_file( finfo_open( FILEINFO_MIME_TYPE), PICTURE_DIR . $picture);
        if( strpos( $finfo, "image/jpeg") === false ) {
            return "error";
            die( "Wrong file type. Accepted file extensions are jpg/jpeg" );
        }

        if( ( filesize(PICTURE_DIR . $picture) > MAX_FILESIZE ) ) { 
            return "error2";
            die( "File is too big. Maximum filesize is ".( MAX_FILESIZE/1024/1024) );
            
        }           

        $pictureID = md5_file( PICTURE_DIR . $picture );
        
        // 1 = userpicture, 2 = property picture
        if( $type == 1 ) {
            $this->convertPicture( "_SMALL", 48, 48, PICTURE_DIR . $picture );
            $this->convertPicture( "_MEDIUM", 200, 200, PICTURE_DIR . $picture );
        } else {
            $this->convertPicture( "_LARGE", 400, 400, PICTURE_DIR . $picture );
            $this->convertPicture( "_XLARGE", 1024, 1024, PICTURE_DIR . $picture );
        }
        
       return $pictureID;
    }
    
    
    /**
     * delete picture by filename
     * 
     * @param string $filename name/hash of the picture which has to be removed
     * @return int Statuscode ( 1 = picture deleted, 0 = No Data for ID found ) 
     */ 
    public function deletePictureByFileName ($filename) {
        $matches = 0;
        
        foreach (glob (PICTURE_DIR . $filename . "*.jpg" ) as $filename2) 
        {
            unlink ($filename2);
            $matches++;
        }
   

        return ($matches > 0) ;
    }

    /**
     * display a picture by id
     * 
     * @param string $type type/size of the picture
     *                  Use: [SMALL|MEDIUM|LARGE|XLARGE]
     * @param string $pictureHash of the picture
     * @return string path to the picture
     */ 
    public function displayPicture($type, $pictureHash) {
        
        $logger = new Logging();
         $logger->logToFile("loadPicture", "info", "run" . $pictureHash);
        if ($pictureHash == NULL) {
            return "../images/placeholder.jpg";
        }
        
        $filename = PICTURE_DIR . $pictureHash;
       
        
        switch ($type) 
        {
            case "SMALL":   $filename .= "_SMALL.jpg"; 
                break;
            case "MEDIUM":  $filename .= "_MEDIUM.jpg"; 
                break;
            case "LARGE":   $filename .= "_LARGE.jpg"; 
                break;
            case "XLARGE":  $filename .= "_XLARGE.jpg"; 
                break;
        }
        $logger->logToFile("loadPicture", "info", "try to load image:" . $filename);
        if (file_exists($filename)){
            return $filename;
        }
        else {
            return "../images/file_missing.png";
        }
    }
    
 
    /**
     * converts picture into a other dimension
     * 
     * @param String $postfix postfix for the new picture 
     * @param type $width maximum width of the new picture
     * @param type $height maximum height of the new picture
     * @param type $filename pathe where the pictre is currently stored
     */
    private function convertPicture( $postfix, $width, $height, $filename ) {

        list ($width_orig, $height_orig) = getimagesize ($filename);

        $ratio_orig = $width_orig / $height_orig;

        if ($width/$height > $ratio_orig) 
        {
           $width = $height * $ratio_orig;
        } 
        else 
        {
           $height = $width / $ratio_orig;
        }
        
        $picture_p    = imagecreatetruecolor ($width, $height);
        $picture      = imagecreatefromjpeg ($filename);
        imagecopyresampled ($picture_p, $picture, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        $newfilename = PICTURE_DIR . md5_file ($filename) . $postfix . ".jpg";
               
        imagejpeg ($picture_p, $newfilename, 100);
    }

    /**
    * reduces image size
    *
    * @param source image file (supported image formats: jpeg, png, gif)
    * @param percentage of resize of the image, default: source image size
    */
    public static function compressImage($image, $size=100)
    {
        $percentage = $size / 100;
        $size = getimagesize($image);
        $img_width = $size[0];
        $img_height = $size[1];
        $img_mime = $size['mime'];

        $new_width = $img_width * $percentage;
        $new_height = $img_width * $percentage;

        // Create a new true color image  
        $rendered_image = @imagecreatetruecolor($new_width, $new_height) or 
            die('Cannot Initialize new GD image stream');
        // Create new image from source
        switch ($img_mime):
        case 'image/jpeg':
            $img_source = imagecreatefromjpeg($image);
        break;
        case 'image/png':
            $img_source = imagecreatefrompng($image);
        break;
        case 'image/gif':
            $img_source = imagecreatefromgif($image);
        break;
        default:
            $img_source = imagecreatefromjpeg($image);
        break;
        endswitch;

        imagecopyresampled($rendered_image, $img_source, 0, 0, 0, 0, $new_width, $new_height, 
            $img_width, $img_height);
        ob_start();
        imagejpeg($rendered_image, NULL, 75);
        $image_binary = ob_get_contents();
        ob_end_clean();
        echo "<img src='data:image/jpeg;base64," . base64_encode( $image_binary ) . "' />";
    }
}

?>