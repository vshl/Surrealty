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

    
    /**
     * login with a given email&password combination
     * 
     * @param String $email email for the logiin
     * @param type $password for the login
     * 
     * @return int success = 1, failed  = 0
     * 
     */
    public function logonWithEmail( $email, $password ) {
        $sqlQuery = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" .  hash("sha256", $password) . "' AND enable = 1 AND delet = 0;";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
               
        
        while( $row = mysqli_fetch_assoc($result) ) 
        {            
            $_SESSION['fname']   = $row['fname'];
            $_SESSION['lname']   = $row['lname'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];
            $this->logger->logToFile("AuthController", "Info", "User: " . $row['user_id'] . "has logged on. Role Type: " . $row['role'] . "from ip:" . $_SERVER['REMOTE_ADDR']);
            
            return 1;
        }        
        
        return 0;
    }
    
    /**
     *  prepare database for the reset progress - insert resetcode in the database 
     * 
     * @param String $email email from the user who wants to reset the password
     * @return String $code returns the resetcode which is set in the database for the progress
     */
    

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
    
    /**
     * resets the password for the user to a random string
     * 
     * @param String $email email from the user which password will be reseted
     * @param String $code resetcode from the mail for the resetprogress
     * 
     * @return String returns the new password fpr the user which is identified per mail
     * 
     */
    
    
    public function resetPassword($email, $code) {
        $newPassword = $this->getRandomString(10);
        
        // 10minutes to reset the pwd
        $sqlQuery = "SELECT * FROM users WHERE email = '". $email ."' AND reset_code = '". hash("sha256", $code) ."' AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(reset_date) < 600;";
        
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($this->dbcomm->affectedRows() == 1) 
        {
            $row = mysqli_fetch_assoc($result);

            $sqlQuery = "UPDATE users SET password = '".  hash("sha256", $newPassword) ."', reset_code = '' WHERE user_id = '".$row['user_id']."';";
            
            $result = $this->dbcomm->executeQuery($sqlQuery);
            
            if ($this->dbcomm->affectedRows() == 1) 
            {
                return $newPassword;
            } 
            else 
            {
                return $this->dbcomm->giveError();
            }
        }
        else 
        {
            return 0;
        }
    }
    
    /**
     * generates a random string 
     * 
     * @param Integer $length length of the random string (default 32)
     * @param Array $name Descriptionparam $characters that will be used (default a-zA-Z0-9)
     * 
     * @return String random string generated with the characters and length given
     */
    private function getRandomString($length = 32, $characters = null) {   
        if($characters == null) 
        {
            $aCharacters = array_merge(range('A', 'Z'), range('a', 'z'), range(0,9));
        } else {
            $aCharacters = str_split($characters);
        }
        
        for ($randomString = '', $i = 0; $i < $length; $i++) 
        {
            $randomString.= $aCharacters[array_rand($aCharacters)];
        }
    
        return $randomString;
    }
    
    
    
    /**
     * register a new user as buyer
     * 
     * @param $user array with user information form register formular
     * 
     * @return int Statuscode ( 1 = buyer created, 0 = no buyer created)  
    **/
    public function registerNewUser($user) {
        
        // check if email exists
        $sqlQuery = "SELECT * FROM users WHERE users.email = '" . $user['email'] . "';";
        $result = $this->dbcomm->executeQuery($sqlQuery);       
       
       if ($result->num_rows == 0)
       {
    
             $_SESSION['fname'] = $user['fname'];
             $_SESSION['lname'] = $user['lname'];
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