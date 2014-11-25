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
require_once './classes/Person.php';

class Buyer extends Person {
    
    private $enabled;
    private $address1;
    private $address2;
    private $zipCode;
    private $dbcomm;

    public function __construct() {
        $args = func_get_args();
        array_push( $args , "0" );      // add 1 to the array for the agent role
        parent::__construct( $args  );
        $this->dbcomm = new DatabaseComm();
    }
    
    public function __destruct() {
        unset( $this->dbcomm ); 
    }
    
    /**
     * Create a new buyer in database
     * uses information from 
     */
    public function saveBuyer() {
        $sqlQuery = "INSERT INTO user ( lname, fname, image_name, password, email, phone, enable, creation_date, address1, address2, zipcode, role) VALUES ('" .
                    parent::getLastname() . "', '" . parent::getFirstname() . "', '" . 
                    parent::getPictureName() . "', '" . parent::getPassword() . "', '" . 
                    parent::getEmail() . "', '" . parent::getPhone() . "', '" .
                    $this->enabled . "', NOW(), '". $this->address1 ."', '".
                    $this->address2 ."', '". $this->zipCode ."', '" . parent::getRole() . "');";
        $result = $this->dbcomm->executeQuery($sqlQuery);
    
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at buyer saving");
        }
        else
        {
            return 1;
        }
    }
    
    
    /**
     * loadBuyerByID
     * Loads buyer data from Database and build an buyer object
     * @param type $buyerID ID of buyer
     */
    public function loadBuyerByID( $userID ) {
        $sqlQuery = "SELECT * FROM user WHERE user_id = " . $userID . ";";
        $result = $this->dbcomm->executeQuery($sqlQuery);

        if ($this->dbcomm->affectedRows() == 1) 
        {
                $row = mysqli_fetch_assoc($result);
                // Copy data from database into buyer object
                $this->enable    = $row['enable'];
                $this->address1 = $row['address1'];
                $this->address2 = $row['address2'];
                $this->zipCode  = $row['zipcode'];
                parent::__construct($row['lname'], $row['fname'], $row['email'], $row['password'], $row['phone'], $row['image_name'], $row['role']);
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
     * @param int $buyerID ID of buyer which has to be removed
     * @return int Statuscode ( 1 > buyer deleted, 0 > No Data for ID found ) 
     */
    public function deleteBuyerByID( $userID ){
        $sqlQuery = "DELETE FROM user WHERE user_id = " . $userID . ";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at buyer delete");
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
     * Updates database entry for loaded buyer
     * @return int Statuscode ( 1 > buyer updated, 0 > No Data for ID found )
     */
    public function updateBuyer() {
        $sqlQuery = "UPDATE buyer SET "
                    . "fname='" . parent::getFirstname() . "', "
                    . "lname='" . parent::getLastname() . "', "
                    . "image_name='" . parent::getPictureName() . "', "
                    . "email='" . parent::getEmail() . "', "
                    . "enable=" . $this->enabled . ", "
                    . "address1='" . $this->address1 ."', "
                    . "address2='" . $this->address2 ."', "
                    . "zipcode='" . $this->zipcode."', "
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
            die("Error at buyer saving");
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
    
     public function giveArray() {
        $array = array(
            "fistname" => $this->getFirstname(),
            "lastname" => $this->getLastname(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "user_id" => $this->getID(),
            "image" => $this->getPictureName(),
            "phone" => $this->getPhone(),
            "enabled" => $this->enabled,
            "role" => $this->getRole(),
        );
        return $array;  
    }
}


?>