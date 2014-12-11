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
        $sqlQuery = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" .  hash("sha256", $password) . "' AND enable = 1 AND delet = 0;";
        
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
    

    public function sentResetCode( $email ) {
        $code = $this->getRandomString( 32 ) ;
        
        $sqlQuery = "UPDATE users SET reset_code = '" . hash("sha256",$code) . "', ".
                    "reset_date = NOW() WHERE email = '" . $email . "';";
        
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($this->dbcomm->affectedRows() == 1)
        {
            return $code;
        }
        else
        {
           return 0;
        }
          
    }
    
    
    public function resetPassword($email, $code) {
        $newPassword = $this->getRandomString(10);
        
        // 10minutes to reset the pwd
        $sqlQuery = "SELECT * FROM users WHERE email = '". $email ."' AND reset_code = '". hash("sha256", $code) ."' AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(reset_date) < 600;";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
       if ($this->dbcomm->affectedRows() == 1) {
            $row = mysqli_fetch_assoc($result);

            $sqlQuery = "UPDATE users SET password = '".  hash("sha256", $newPassword) ."', reset_code = '' WHERE user_id = '".$row['user_id']."';";
            
            $result = $this->dbcomm->executeQuery($sqlQuery);
            
            if ($this->dbcomm->affectedRows() == 1) {
                return $newPassword;
            } else {
                return $this->dbcomm->giveError();
            }
        }
        else {
            return 0;
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
    
    
    public function registerNewUser($user) {
        
        // check if email exists
        $sqlQuery = "SELECT * FROM users WHERE users.email = '" . $user['email'] . "';";
        $result = $this->dbcomm->executeQuery($sqlQuery);       
         //  $row = mysqli_affected_rows($result);   
       
       if ($result->num_rows == 0)
       {
    
             $_SESSION['fname'] = $user['fname'];
             $_SESSION['role'] = "BUYER";          
             $buyer = new Buyer();
             
             $user_id = $buyer->saveBuyer($user);
             if (is_int($user_id)) {
                 $_SESSION['user_id'] = $user_id;
                 return 1;
             }
             else {
                 return 0;
             }

        }   
        else 
        { 
            return 0;
        }

    }
    
}


?>