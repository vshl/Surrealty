<?php


/**
 * BuyerController class
 * 
 * This class will handle / serve all operations related to all or one buyer.
 * 
 * Every function is commented. Please avoid using the Buyer class directly!
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * 
 * please comment every change in following CHANGELOG
 * CHANGELOG:
 * 09NOV2014 - F.HAHNER
 *  redesign class for usage of new 'users' table
 */

define ("BUYER_ROLE_ID", 0);

require_once './include/DatabaseComm.php';
require_once './classes/Buyer.php';

class BuyerController {
   
    public function __construct() {

    }
    
    public function __destruct() {
        
    }
    
    /**
     * Not yet implemented
     */
    
    public function addUser() {
        
    }
    
   /**
     *  loadBuyerByID
     * 
     * load an Buyer by his ID
     * @param type $buyerID
     * 
     * @return requested buyer as object. If buyer not found return 0
     */
    
    public function loadBuyerByID( $buyerID ) {
      $buyer = new Buyer();
      if ($buyer->loadAgentByID($buyerID)){
          return $buyer;
      }
      else{
          return 0;
      }
    }
    
    /**
     * Not yet implemented
     * @return string
     */
    
    
    public function saveUserByID() {
        return "int";
    }
    
    
    /**
     * Reads out all the buyers from DB and return them as array
     * 
     * Buyers are sorted by lastname
     * 
     * Buyers are usertype = 0
     * 
     * @param $sortDirection Set the direction of sorting. 
     *                       Possible values [ASC|DESC]
     *                       Default ASC
     *
     * @param $sortField Set the database field to sort
     *                       Default lname
     *  
     * @return array 2-dim array which all buyers included
     *         array[x][y]
     *         x = incremental counter in array
     *         y = field or attribute of buyer
     */
    
    public function listAllBuyers($sortDirection = 'ASC', $sortField = 'lname') {
        $dbComm = new DatabaseComm();
        $sqlQuery = "SELECT * FROM users ORDER BY $sortField $sortDirection WHERE role = " . BUYER_ROLE_ID . ";";
        $result = $dbComm->executeQuery($sqlQuery);
        echo $dbComm->giveError();
        $buyer_array = array();
        while($row = $result->fetch_assoc()) {
            $buyer_array[] = $row;
        }
        unset ($dbComm);
        return $buyer_array;
    }
    
    
    /**
     * enableBuyerById 
     * 
     * Set the enabled status of a buyer specified by its id
     * 
     * @param type $agentID => The ID of the buyer
     * @param type $enabled => enabled status 0=disabled, 1=enabled
     * @return int statuscode => 0=error, 1=success
     * 
     */
    
    public function enableBuyerByID( $buyerID, $enabled ) {
    {
        if ($enabled == 0 || $enabled == 1){
            $buyer = new Buyer();
            if ($buyer->loadBuyerByID($buyerID)){
                $buyer->setEnabled($enabled);
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
        }
    }
    
    /**
      * deleteBuyerByID
      * 
      * deletes a buyer by its ID
      * 
      * @param type $buyerID
      * 
      * @return int statuscode(inherit from parent function) 0=error, 1=success
      */
    
    public function deleteAgentByID( $buyerID ) {
        
        if ( $buyerID >= 0) {       // check if ID is integer GEt zero
           $buyer = new Buyer(); 
           return $buyer->deletBuyerByID($buyerID);
        }
        else { 
            return 0;
        }
    }
    
}


?>