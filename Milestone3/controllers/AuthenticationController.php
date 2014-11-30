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
require_once '../include/DatabaseComm.php';
require_once '../classes/Logging.php';

class AuthenticationController {
    
    private $dbcomm;
    private $logger;
      
    public function __construct() {
        $this->dbcomm = new DatabaseComm();
        $this->logger = new Logging();
    }
    
    public function __destruct() {
        unset ($this->dbcomm);
    }

    public function logonWithEmail( $email, $password ) {
        $sqlQuery = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . $password . "';";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
               
        
        while( $row = mysqli_fetch_assoc($result) ) 
        {            
            //session_start();
            $_SESSION['fname']   = $row['fname'];
            $_SESSION['lname']   = $row['lname'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];
            $this->logger->logToFile("AuthController", "Info", "User: " . $row['user_id'] . "has logged on. Role Type: " . $row['role'] . "from ip:" . $_SERVER['REMOTE_ADDR']);
            
            return 1;
        }        
        
        return 0;
    }
    

    public function resetPassword( $email ) {
        $sqlQuery = "INSERT INTO users (reset_code, reset_date) VALUES ('" . $this->getRandomString( 32 ) . "', NOW()) WHERE email = '" . $email . "';";
        
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