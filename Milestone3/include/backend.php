<?php

/**
 * This is the ajax backend for the frontend.
 * We use one common backend for all the dashboards.
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @author Benjamin Bleichert <benjamin.bleichert@informatik.hs-fulda.de>
 * @version 0.2
 * 
 */

require_once '../controllers/AgentController.php';
require_once '../controllers/BuyerController.php';
//require_once 'AdminControler.php';
require_once '../controllers/ImageController.php';
require_once '../controllers/CommentController.php';
require_once '../classes/Logging.php';
require_once '../controllers/AuthenticationController.php';
require_once '../controllers/PropertyController.php';



/**
 * This Section received the request from ajax frontend.
 *
 */

//read the choosen action from POST variable 'action'
if (!isset($_POST['action'])) {
    echo "Fehler";
    return;
}
$functionChoice = $_POST['action'];


// WE NEED TO CHECK SESION FOR THE RIGHTS THE USER HAVE!!!!
// CAUSE WE CAN SIMPLY MANIPULATE THE ACTION DATA!!

switch ($functionChoice) {
    // part for agent related functions
    case 'listAllAgentsAsTable':
        listAllAgentsAsTable();
        break;
    case 'enableAgentByID':
        enableAgentByID();
        break;
    case 'loadBuyerByID':
        loadBuyerByID($_POST['buyerID']);
        break;
    case 'loginByEMail':
        loginByEMail();
        break;
    case 'addBuyer': 
        addBuyer();
        break;
    case 'loginAndRedirect':
        loginAndRedirect();
        break;
    case 'listAllBuyersAsTable':
        listAllBuyersAsTable();
        break;
    case 'readCommentsForUser':
        readCommentsForUser($_POST['userID'], $_POST['showOld']);
        break;
    case 'deleteBuyerByID':
        deleteBuyerByID($_POST['userID']);
        break;
    default:
        echo "<b>Error at switch-case<b><br>";
        print_r($_POST);
        print_r($_FILES);
        break;
    
}

function listAllBuyersAsTable(){
    $bc = new BuyerController();
    $ic = new ImageController();
    $buyer_array = $bc->listAllBuyers();
    $result = '<table class="buyerListTable">';
    $i=0;
    while($i < count($buyer_array))
    {
    //prepare string
    $status = '<font color="red">disabled</font>';
    if ($buyer_array[$i]['enable'] == 1 ){
        $status = '<font color="green">enabled</font>';
    }
    $result .= '<tr class="buyerListTableRow"><td class="buyerListTablePicture">';
    $result .= '<img src="' . $ic->displayPicture("SMALL", $buyer_array[$i]['image_name']). '" width="80px" height="80px">';
    $result .= '</td><td>' . $buyer_array[$i]['fname'] . " " . $buyer_array[$i]['lname'] 
            . '<br>'
            . $buyer_array[$i]['address1']
            . '<br>'
            . $buyer_array[$i]['zipcode'] . $buyer_array[$i]['city']
            . '</td><td>Buyer is ' . $status . '<br>'
            . '<a href="#" onmousedown="javascript:askBeforeDelete(\'' 
            . $buyer_array[$i]['fname']
            . ' \',\''
            . $buyer_array[$i]['lname']
            . '\','
            . $buyer_array[$i]['user_id']
            . ');">delete buyer</a>'
            . '</td>'
            . '</tr>';
    $i++;
    }
    $result .= '</table>';
    unset ($bc);
    unset ($ic);
    echo $result;
  
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

function loadBuyerByID($user_id){
    
    $bc = new BuyerController();
    echo("load user" . $user_id);
    $buyer = $bc->loadBuyerByID($user_id);
    
    if ($buyer != 0) {
        echo ($buyer->getFirstname() ." - " . $buyer->getLastname());
    }
    else {
        echo ("Kein User gefunden");
    }  
}

function deleteBuyerByID($userID) {
    $bc = new BuyerController();
    $result = $bc->deleteBuyerByID($userID);
    unset ($bc);
    echo $result;
    
}

function loginByEMail() {
    print_r($_POST);
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $ac = new AuthenticationController();
    $ac->logonWithEmail($email, $password);
    loadBuyerByID($_SESSION['user_id']);
    echo "Angemeldete ID ist" . $_SESSION['user_id'];
}

function loginAndRedirect() {
    // strip_tags removes all html and php tags from string
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']); 
    
    $ac = new AuthenticationController();
    $result = $ac->logonWithEmail($email, $password);
    $logger = new Logging();
    $logger->logToFile("backend_loginAndRedirect", "Info", "Result is: " . $result);
    if ($result === 0) { // User not found, or data is wrong
        echo 0;
        return;
    }
    $logger->logToFile("backend_loginAndRedirect", "Info", "User Role: " . $_SESSION['role']);
     
    switch ($_SESSION['role']) {
        case 'ADMIN':
            echo "../pages/login/admin/adminDashboard.php";
            break;
        case 'AGENT':
            echo "../pages/login/agent/agentDashboard.php";
            break;
        case 'BUYER':
            echo "../pages/login/buyer/buyerDashboard.php";
            break;
        default :
            echo 0;
    }
    
    
}

/**
 * This function will load all comments belonging to a given user.
 * @param int $userID -> the given user id (mostly agent)
 * @param int $showOld -> 1 show already seen comments, 0 show only unseen comments
 */
function readCommentsForUser($userID, $showOld) {
    $logger = new Logging();
    $userID = intval($userID);
    //$showOld = intval($showOld);
    
//    if ($showOld != 0 OR $showOld != 1) {
//        echo "0";
//        $logger->logToFile("readCommentsForUser", "info", "showOld isn't 1 or 0 but " . $showOld);
//        return;
//    }
//    if (!is_int($userID)) {
//        echo "0";
//        $logger->logToFile("readCommentsForUser", "info", "userID isn't INT");
//        return;
//    }
    
    $cc = new CommentController();
    $ic = new ImageController();
    $pc = new PropertyController();
    
    //get data from comment
    $comments = $cc->listCommentsByUser($userID);
    for ($i=0, $c=count($comments); $i<$c-1; $i++) {
        echo "PropertyID:" . $comments[$i]['property_id'] . "<br>Comment Text:". $comments[$i]['comment']."<br><hr>";
    }
    
    
}




function addBuyer() {
    $bc = new BuyerController();
    $buyerID = $bc->addBuyer( $_POST );
    $_SESSION['user_id'] = $buyerID;
    $_SESSION['role'] = BUYER_ROLE_ID;
    print_r($_POST);
}



?>
