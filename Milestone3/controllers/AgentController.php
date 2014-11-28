<?php

/**
 * AgentController class
 * 
 * This class will handle / serve all operations related to all or one agent.
 * 
 * Every function is commented. Please avoid using the Agent class directly.
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * 
 * please comment every change in following CHANGELOG
 * CHANGELOG:
 * 09NOV2014 - F.HAHNER
 *  redesign class for usage of new 'users' table
 */
include ('../pathMaker.php');

require_once $path.'/include/DatabaseComm.php';
require_once $path.'/classes/Agent.php';

class AgentController {
    
    private $allAgents;
    
    public function __construct() {
        
    }
    
    public function __destruct() {
        
    }
    
    /**
     * Reads out all the agents from DB and return them as array
     * 
     * Agents are sorted by lastname
     * 
     * Agents are usertype = 1
     * 
     * @param $sortDirection Set the direction of sorting. 
     *                       Possible values [ASC|DESC]
     *                       Default ASC
     *
     * @param $sortField Set the database field to sort
     *                       Default lname
     *  
     * @return array 2-dim array which all agents included
     *         array[x][y]
     *         x = incremental counter in array
     *         y = field or attribute of agent
     */
    
    public function listAllAgents($sortDirection = 'ASC', $sortField = 'lname') {
        $dbComm = new DatabaseComm();
        $sqlQuery = "SELECT * FROM users ORDER BY $sortField $sortDirection WHERE role = ". AGENT_ROLE_ID . ";";
        $result = $dbComm->executeQuery($sqlQuery);
        echo $dbComm->giveError();
        $agent_array = array();
        while($row = $result->fetch_assoc()) {
            $agent_array[] = $row;
        }
        unset ($dbComm);
        return $agent_array;
    }
    
    /**
     * loadAgentByPropertyID
     * 
     * loads an agent by a given property id
     * 
     * @param int $propertyID
     * @return array with agent data
     */
      
    public function loadAgentByPropertyID( $propertyID ) {
        $db = new DatabaseComm();
        //get the agent ID from the property table
        $query = "SELECT agent_id FROM property WHERE property_id = $propertyID;";
        $result = $db->executeQuery($query);
        $row = $result->fetch_assoc();
        if ($row != NULL) // found a fitting property
        {
            $agent_id = $row['agent_id'];
        }
        else {
            return 0;
        }
        $result->free();
        $query = "SELECT * from user WHERE agent_id = $agent_id";
        $result = $db->executeQuery($query);
        $row = $result->fetch_assoc();
        if ($row != NULL){ // found a fitting agent
            return $row;
        }
        else {
            return 0;
        }
    }
    
    /**
     *  loadAgentByID
     * 
     * load an Agent by his ID
     * @param type $agentID
     * 
     * @return requested Agent as object. If agent not found return 0
     */
    
    public function loadAgentByID( $agentID ) {
      $agent = new Agent();
      if ($agent->loadAgentByID($agentID)){
          return $agent;
      }
      else{
          return 0;
      }
    }
    
    /**
     * enableAgentById 
     * 
     * Set the enabled status of an agent specified by its id
     * 
     * @param type $agentID => The ID of the agent
     * @param type $enabled => enabled status 0=disabled, 1=enabled
     * @return int statuscode => 0=error, 1=success
     * 
     */
    
    public function enableAgentByID( $agentID, $enabled ) {
    {
        if ($enabled == 0 || $enabled == 1){
            $agent = new Agent();
            if ($agent->loadAgentByID($agentid)){
                $agent->setEnabled($enabled);
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
      * deleteAgentByID
      * 
      * deletes an agent by its ID
      * 
      * @param type $agentID
      * 
      * @return int statuscode(inherit from parent function) 0=error, 1=success
      */
    
    public function deleteAgentByID( $agentID ) {
        
        if ( $agentID >= 0) {       // check if ID is integer GEt zero
           $agent = new Agent(); 
           return $agent->deleteAgentByID($agentID);
        }
        else { 
            return 0;
        }
    }
    
}


?>