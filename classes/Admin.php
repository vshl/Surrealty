<?php
/**
 * Model Class for Agent objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */


require_once './include/DatabaseComm.php';
require_once 'Person.php';

class Admin extends Person {
       
    private $enabled;
    private $dbcomm;
    
    public function __construct() {
        $args = func_get_args();
        array_push( $args , ADMIN_ROLE_ID );      // add 1 to the array for the agent role
        parent::__construct( $args  );
        $this->dbcomm = new DatabaseComm();
    }
        
    public function __destruct() {
        unset ($this->dbcomm); 
    }
 
    /**
     * Create a new ADmin in database
     * uses information from 
     */
    public function saveAdmin() {
        $sqlQuery = "INSERT INTO users (fname, lname, image_name, password, email, phone, enable, creation_date, role) VALUES (" . "'" .
                parent::getLastname() . "', '" . parent::getFirstname() . "', '" . 
                parent::getPictureName() . "', '" . parent::getPassword() . "', '" . 
                parent::getEmail() . "', '" . parent::getPhone() . "', '" .
                $this->enabled . "', NOW(), '" . ADMIN_ROLE_ID . "');";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at agent saving");
        }
        else
        {
            return 1;
        }
    }
    
    /**
     * loadAdminByID
     * Loads Admin data from Database and build an admin object
     * @param type $adminid ID of admin
     */
    public function loadAdminByID( $userID ) {
        
        $sqlQuery = "SELECT * FROM users WHERE user_id = " . $userID . " and role = ". ADMIN_ROLE_ID . ";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        if ($this->dbcomm->affectedRows() == 1) 
            {
                $row = mysqli_fetch_assoc($result);
                // Copy data from database into agent object
                $this->enabled = $row['enable'];
                parent::__construct($row['lname'], $row['fname'], $row['email'], $row['password'], $row['phone'], $row['user_id'], $row['image_name'], $row['role']);
                return 1;
            }
            else
            {
                return 0;
            }
       
    }   
    
    /**
     * 
     * @param int $userID ID of admin which has to be removed
     * @return int Statuscode ( 1 > admin deleted, 0 > No Data for ID found ) 
     */
    public function deleteAdminByID( $userID ){
        $sqlQuery = "DELETE FROM users WHERE user_id = " . $userID . ";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at agent delete");
        }
        else
        {
            if ($this->dbcomm->affectedRows() == 1) 
            {
                return 1;
            }
            else
            {
                return 0;
            }
            
        }
    }
                
    /**
     * Updates database entry for loaded Admin
     * @return int Statuscode ( 1 > Admin updated, 0 > No Data for ID found )
     */
    public function updateAdmin() {
        $sqlQuery = "UPDATE users SET "
                    . "fname='" . parent::getFirstname() . "', "
                    . "lname='" . parent::getLastname() . "', "
                    . "image_name='" . parent::getPictureName() . "', "
                    . "email='" . parent::getEmail() . "', "
                    . "enable=" . $this->enabled . ", "
                    . "phone='" . parent::getPhone() . "', "                 
                    . "modification_date=now()" . ", "
                    . "password='" . parent::getPassword() 
                    . "' WHERE user_id = " . parent::getID() .";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo "<br><b>" . $sqlQuery . "</b>";
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at agent saving");
        }
        else
        {
            return 1;
        }
    }
    /**
     * Set the enabled status
     * @param integer $enabled 1 enabled, 0 disabled
     */
    public function setEnabled( $enabled ){
        $this->enabled = $enabled;
    }
    
    /**
     * Returns array which contains all data from 
     * agent object
     */
    
    public function giveArray() {
        $array = array (
            "fistname" => $this->getFirstname(),
            "lastname" => $this->getLastname(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "agent_id" => $this->getID(),
            "image_name" => $this->getPictureName(),
            "phone"     => $this->getPhone(), 
            "enabled" => $this->enabled,
            "role" => $this->getRole(),
        );
        return $array;  
    }
    
}
?>