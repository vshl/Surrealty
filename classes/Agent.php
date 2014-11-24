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

define ("AGENT_ROLE_ID", 1);
 
 
require_once './include/DatabaseComm.php';
require_once 'Person.php';

class Agent extends Person {
       
    private $enabled;
    private $dbcomm;
   
    
    public function __construct() {
        $args = func_get_args();
        array_push( $args , "1" );      // add 1 to the array for the agent role
        parent::__construct( $args  );
        $this->dbcomm = new DatabaseComm();
    }
        
    public function __destruct() {
        unset ($this->dbcomm); 
    }
 
    /**
     * Create a new Agent in database
     * uses information from 
     */
    public function saveAgent() {
        $sqlQuery = "INSERT INTO user (fname, lname, image_name, password, email, phone, enable, creation_date, role) VALUES (" . "'" .
                parent::getLastname() . "', '" . parent::getFirstname() . "', '" . 
                parent::getPictureName() . "', '" . parent::getPassword() . "', '" . 
                parent::getEmail() . "', '" . parent::getPhone() . "', '" .
                $this->enabled . "', NOW(), " . AGENT_ROLE_ID .");";
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
     * loadAgentByID
     * Loads Agent data from Database and build an agent object
     * @param type $agentid ID of agent
     */
    public function loadAgentByID( $userID ) {
        
        $sqlQuery = "SELECT * FROM user WHERE agent_id = $agentid AND role = " . AGENT_ROLE_ID . ";";
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
     * @param int $agentID ID of Agent which has to be removed
     * @return int Statuscode ( 1 > Agent deleted, 0 > No Data for ID found ) 
     */
    public function deleteAgentByID( $agentID ){
        $sqlQuery = "DELETE FROM user WHERE agent_id = $agentID;";
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
     * Updates database entry for loaded agent
     * @return int Statuscode ( 1 > Agent updated, 0 > No Data for ID found )
     */
    public function updateAgent() {
        $sqlQuery = "UPDATE user SET "
                    . "fname='" . parent::getFirstname() . "', "
                    . "lname='" . parent::getLastname() . "', "
                    . "image_name='" . parent::getPictureName() . "', "
                    . "email='" . parent::getEmail() . "', "
                    . "enable=" . $this->enabled . ", "
                    . "phone='" . parent::getPhone() . "', "
                    . "role='" . parent::getRole() . "', "
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
