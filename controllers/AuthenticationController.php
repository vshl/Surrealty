<?php
/**
 * Controler Class for Comment objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */
require_once './include/DatabaseComm.php';

class AuthenticationController {
    
    private $dbcomm;
      
    public function __construct() {
        $this->dbcomm = new DatabaseComm();
    }
    
    public function __destruct() {
        unset ($this->dbcomm);
    }

    public function logonWithEmail( $email, $password ) {
        $sqlQuery = "SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . $password . "';";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
          
        while( $row = mysqli_fetch_assoc($result) ) 
        {            
            $_SESSION['fname']   = $row['fname'];
            $_SESSION['lname']   = $row['lname'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];
            
            return 1;
        }        
        
        return 0;
    }
    

    public function resetPassword( $email ) {
        $sqlQuery = "INSERT INTO user (reset_code, reset_date) VALUES ('" . $this->getRandomString( 32 ) . "', NOW()) WHERE email = '" . $email . "';";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at reset pwd");
        }
        else
        {
            return 1;
        }
          
    }
    
    private function getRandomString($iLength = 32, $sCharacters = null) {   
        if($sCharacters == null) {
            $aCharacters = array_merge(range('A', 'Z'), range('a', 'z'), range(0,9));
        } else {
            $aCharacters = str_split($sCharacters);
        }
        
        for ($sRandomString = '', $i = 0; $i < $iLength; $i++) {
            $sRandomString.= $aCharacters[array_rand($aCharacters)];
        }
    
        return $sRandomString;
    }
    
}


?>