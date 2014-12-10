<?php

/**
 * Handles requests for the Property Class. Provides method functionalities
 * to respond to these requests.
 *
 * @author Vishal Ravi Shankar <vshankar@mail.sfsu.edu>
 * @author Benjamin Bleichert <benjamin.bleichert@informatik.hs-fulda.de>
 * @version 1.0
 */

//require_once '../classes/Property.php';
require_once '../include/DatabaseComm.php';

class PropertyController {
    
    /**
     * Returns Properties from the Property table
     *
     * @param type $search - search query as a string
     * 
     * @return - associative array of properties
     * 
     */
    public static function searchProperty($search) 
    {
        $dbConn = new DatabaseComm();
        $query = "SELECT * FROM property "
                . "WHERE CONCAT_WS(address1,',',address2,',',zipcode,',',city,',',state,',',country) "
                . "LIKE '%$search%'";
        $result = $dbConn->executeQuery($query);
        $properties = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $properties[] = $row;
            }
        } else {
            return 0;          
        }
        return $properties;
    }
    
    /**
     * Returns the address from the Property table
     *
     * @param property_id from the property row
     * 
     * @return - associative array of the address
     * 
     */
    public static function getAddress($id) {
        $dbConn = new DatabaseComm();
        $query = "SELECT address1, city, zipcode  FROM property "
                . "WHERE property_id = $id";
        $result = $dbConn->executeQuery($query);
        return $result->fetch_assoc();
    }
    
    /**
     * giveImageHashesByPropertyID
     * 
     * return an array with all the image hashes from a given property
     * used in /include/backend.php to display a picture from property
     * 
     * @param int $propertyID
     * @return array with images hashes
     */
    
    public static function giveImageHashesByPropertyID($propertyID) {
        if (!is_int($propertyID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "SELECT image_name FROM property_images WHERE property_id = " . $propertyID .";";
        $result = $db->executeQuery($query);
        $image_array = array();
        while ($row = $result->fetch_assoc()) {
            $image_array[] = $row;
        }
        unset ($db);
        return $image_array;
    }
    
        /**
     * giveImageHashesByPropertyID
     * 
     * sseaches all unproven properties and return
     * it via multi array 
     *
     * @return multi array with all unproven properties
     */    
    public function giveUnprovenProperties() {
        $dbComm = new DatabaseComm();
        $sqlQuery = "SELECT * FROM property WHERE approved = 0 AND delet = 0;";
        $result = $dbComm->executeQuery($sqlQuery);
       
        $properties = array();
        
        while($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
        unset ($dbComm);
        return $properties;
    
    }
    
    public function approvePropertyByID($propertyID) {
        $dbComm = new DatabaseComm();
        $sqlQuery = "UPDATE property SET approved = 1 WHERE property_id = '".$propertyID."';";
        $result = $dbComm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo "<br><b>" . $dbComm->giveError() . "</b>";
        }
        else
        {
            if ($dbComm->affectedRows() == 1) 
            {
                return 1;
            }
            else
            {
                return 0;
            }
            
        }
    }
    
    public function deletePropertyByID($propertyID) {
        $dbComm = new DatabaseComm();
        $sqlQuery = "UPDATE property SET delet = 1 WHERE property_id = '".$propertyID."';";
        $result = $dbComm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo "<br><b>" . $dbComm->giveError() . "</b>";
        }
        else
        {
            if ($dbComm->affectedRows() == 1) 
            {
                return 1;
            }
            else
            {
                return 0;
            }
            
        }
    }
}
?>