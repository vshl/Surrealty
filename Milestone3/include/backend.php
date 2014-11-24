<?php

/**
 * This is the ajax backend for the frontend.
 * We use one common backend for all the dashboards.
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 0.1
 * 
 */

require_once '../controllers/AgentController.php';
require_once '../controllers/BuyerController.php';
//require_once 'AdminControler.php';
require_once '../controllers/ImageController.php';
require_once '../controllers/AuthenticationController.php';



/**
 * This Section received the request from ajax frontend.
 *
 */

//read the choosen action from POST variable 'action'
$functionChoice = $_POST['action'];

switch ($functionChoice) {
    // part for agent related functions
    case 'listAllAgentsAsTable':
        listAllAgentsAsTable();
        break;
    case 'enableAgentByID':
        enableAgentByID();
        break;
}

/**
 * listAllAgentsAsTable
 * 
 * Will read out all Agents from Database and 
 * build a table which has ability to modify and disable
 * agent
 */

function listAllAgentsAsTable(){
    //$sortDirection = $_POST['sortDirection'];
    //$sortFilter = $_POST['sortFilter'];
    $ac = new AgentController();
    $agent_array = $ac->listAllAgents();
    //print the head for table
    echo '<table id="allAgentTable" class="tablesorter"><thead><tr><th>Last Name</th><th>First Name</th><th>EMail</th></tr></thead><tbody>';
    $i = 0;
    while($i < count($agent_array))
    {
       echo "<tr><td>" . $agent_array[$i]['lname'] . "</td><td>". $agent_array[$i]['fname'] . "</td><td>" . $agent_array[$i]['email'] . "</td>";
       $i++;
    }
    echo "</tbody></table>";
}

function listAgentByPropertyID(){
    $propertyID = $_POST['propertyID'];
    $ac = new AgentController();
    $agent = $ac->loadAgentByPropertyID($propertyID);
    echo $agent['lname'];
}


?>
