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
     * @return array($properties, $count[0])
     * 
     */
    public static function searchProperty($search,
        $sortField = 'property_id',
        $sortOrder = 'ASC',
        $offset,
        $limit) 
    {
        $dbConn = new DatabaseComm();
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM property "
                . "WHERE CONCAT_WS"
                . "(address1,',',address2,',',zipcode,',',city,',',state,',',country) "
                . "LIKE '%$search%' "
                . "ORDER BY $sortField $sortOrder "
                . "LIMIT $offset, $limit";
        $result = $dbConn->executeQuery($query);
        $properties = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $properties[] = $row;
            }
        } else {
            return 0;          
        }
        $count_query = 'SELECT FOUND_ROWS()';
        $count_result = $dbConn->executeQuery($count_query);
        $count = $count_result->fetch_row();
        return array($properties, $count[0]);
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
     * @return array with images hashes, or int(0) if error occurs or no pictures available
     */
    
    public static function giveImageHashesByPropertyID($propertyID) {
        if (!is_int($propertyID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "SELECT image_name FROM property_images WHERE property_id = " . $propertyID .";";
        $result = $db->executeQuery($query);
        $image_array = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image_array[] = $row;
            }
        }
        else {
            unset ($db);
            return 0;
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
    
    public function addProperty($title,$address1,$address2,$zipcode,
            $neighborhood,$city,$state,$country,$description, $balcon,
            $pool,$bath,$bed,$area,$price, $image) {
            $sqlQuery = "INSERT INTO property ( title, address1, address2, zipcode, neighborhood, city, state, country, description, beds, baths, pool, ".
                    "balcony, area, price, status, created_by, creation_date, modification_date, approved, agent_id, delet) VALUES ('" .
                    $title . "', '" . 
                    $address1 . "', '" . 
                    $address2 . "', '" . 
                    $zipcode . "', '" . 
                    $neighborhood . "', '" . 
                    $city . "', '" .
                    $state . "', '". 
                    $country ."', '".
                    $description ."', '".   
                    $bed ."', '" . 
                    $bath."', '" . 
                    $pool ."', '" . 
                    $balcon ."', '" . 
                    $area."', '" . 
                    $price ."', '" .
                    "0', '" . 
                    $_SESSION['user_id'] ."', " . 
                    "NOW(), " . 
                    "NOW(), '" .
                    "0', '" . 
                    $_SESSION['user_id']."', '" . 
                    "0');";
        $dbcomm = new DatabaseComm();
        $result = $dbcomm->executeQuery($sqlQuery);
        
        $id = $dbcomm->giveID();
        
        $sqlQuery =  "INSERT INTO property_images ( property_id, image_name, created_by, creation_date) VALUES ".
                "( (SELECT property_id FROM property WHERE property_id='". $id ."'), '".$image."', (SELECT user_id FROM users WHERE user_id='".$_SESSION['user_id']."'), NOW() );";
        
        $result = $dbcomm->executeQuery($sqlQuery);
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $dbcomm->giveError() . "</b>";

            die("Error at agent saving");
        }
        else
        {
            return 1;
        }
    }
}
?>