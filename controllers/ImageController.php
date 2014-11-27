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

        $finfo = finfo_file( finfo_open( FILEINFO_MIME_TYPE), $picture["imgfile"]["tmp_name"] );
        
        if( strpos( $finfo, "image/jpeg") === false ) {
            die( "Wrong file type. Accepted file extensions are jpg/jpeg" );
        }

        if( ( $picture["imgfile"]["size"] > MAX_FILESIZE ) ) { 
            die( "File is too big. Maximum filesize is ".( MAX_FILESIZE/1024/1024) );
        }           

        $pictureID = md5_file( $picture["imgfile"]["tmp_name"] );
        
        // 1 = userpicture, 2 = property picture
        if( $type == 1 ) {
            $this->convertPicture( "_SMALL", 48, 48, $picture["imgfile"]["tmp_name"] );
            $this->convertPicture( "_MEDIUM", 200, 200, $picture["imgfile"]["tmp_name"] );
        } else {
            $this->convertPicture( "_LARGE", 400, 400, $picture["imgfile"]["tmp_name"] );
            $this->convertPicture( "_XLARGE", 1024, 1024, $picture["imgfile"]["tmp_name"] );
        }
        
       return $pictureID;
    }
    
    
    /**
     * delete picture by id
     * 
     * @param string $pictureHash name/hash of the picture which has to be removed
     * @return int Statuscode ( 1 = picture deleted, 0 = No Data for ID found ) 
     */ 
    public function deletePictureByID ($pictureHash) {
        $matches = 0;
        
        foreach (glob (PICTURE_DIR . $pictureHash . "_*.jpeg" ) as $filename) 
        {
            unlink ($filename);
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
        
        if ($pictureHash == NULL) {
            return "../images/placeholder.jpg";
        }
        
        $filename = PICTURE_DIR . $pictureHash;
       
        
        switch ($type) 
        {
            case "SMALL":   $filename .= "_SMALL.jpg"; 
                break;
            case "MEDIUM":  $filename .= "_MEIDUM.jpg"; 
                break;
            case "LARGE":   $filename .= "_LARGE.jpg"; 
                break;
            case "XLARGE":  $filename .= "_XLARGE.jpg"; 
                break;
        }
        
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

        $newfilename = PICTURE_DIR . md5_file ($filename) . $postfix . ".jpeg";
               
        imagejpeg ($picture_p, $newfilename, 100);
    }
        
 }

?>