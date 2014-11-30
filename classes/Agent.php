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

 
 
require_once '../include/DatabaseComm.php';
require_once 'Person.php';

class Agent extends Person {
       
    private $enabled;
    private $dbcomm;
   
    
    public function __construct() {
        $args = func_get_args();
        array_push( $args , AGENT_ROLE_ID );      // add 1 to the array for the agent role
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
        $sqlQuery = "INSERT INTO users ( lname, fname, image_name, password, email, phone, enable, creation_date, address1, address2, zipcode, state, country, city, role) VALUES ('" .
                    parent::getLastname() . "', '" . 
                    parent::getFirstname() . "', '" . 
                    parent::getPictureName() . "', '" . 
                    parent::getPassword() . "', '" . 
                    parent::getEmail() . "', '" . 
                    parent::getPhone() . "', '" .
                    $this->enabled . "', NOW(), '". 
                    parent::getAddress1() ."', '".
                    parent::getAddress2() ."', '".   
                    parent::getZipcode() ."', '" . 
                    parent::getState() ."', '" . 
                    parent::getCountry() ."', '" . 
                    parent::getCity() ."', '" . 
                    AGENT_ROLE_ID . "');";
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
     * @param type $userID ID of agent
     */
    public function loadAgentByID( $userID ) {
        
        $sqlQuery = "SELECT * FROM users WHERE user_id = $userID AND role = " . AGENT_ROLE_ID . ";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($this->dbcomm->affectedRows() == 1) 
            {
                $row = mysqli_fetch_assoc($result);
                // Copy data from database into agent object
                $this->enabled = $row['enable'];
                parent::__construct($row['lname'], $row['fname'], $row['email'], $row['password'], $row['phone'], $row['image_name'], $row['role'], $row['address1'], $row['address2'], $row['zipcode'], $row['city'], $row['state'], $row['country']);
                parent::setID($row['user_id']);
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
        $sqlQuery = "DELETE FROM users WHERE user_id = $agentID;";
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
        $sqlQuery = "UPDATE users SET "
                    . "fname='"         . parent::getFirstname() .  "', "
                    . "lname='"         . parent::getLastname() .   "', "
                    . "image_name='"    . parent::getPictureName() ."', "
                    . "email='"         . parent::getEmail() .      "', "
                    . "enable="         . $this->enabled .          ", "
                    . "address1='"      . parent::getAddress1() .   "', "
                    . "address2='"      . parent::getAddress2() .   "', "
                    . "zipcode='"       . parent::getZipcode() .    "', "
                    . "phone='"         . parent::getPhone() .      "', "
                    . "city='"          . parent::getCity() .       "', "
                    . "state='"         . parent::getState() .      "', "
                    . "country='"       . parent::getCountry() .    "', "
                    . "modification_date=now()" .                   ", "
                    . "password='"      . parent::getPassword() 
                    . "' WHERE user_id = " . parent::getID() .      ";";
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
        $array = array(
            "fistname"  => $this->getFirstname(),
            "lastname"  => $this->getLastname(),
            "email"     => $this->getEmail(),
            "password"  => $this->getPassword(),
            "user_id"   => $this->getID(),
            "image"     => $this->getPictureName(),
            "phone"     => $this->getPhone(),
            "country"   => $this->getCountry(),
            "address1"  => $this->getAddress1(),
            "address2"  => $this->getAddress2(),
            "city"      => $this->getCity(),
            "state"     => $this->getState(),
            "enabled" => $this->enabled,
            "role" => $this->getRole(),
        );
        return $array;  
    }
    
}
?>
