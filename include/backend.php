<?php
session_start();
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
        readCommentsForUser($_SESSION['user_id'], $_POST['showOld']);
        break;
    case 'showUserlist':
        showUserlist($_POST['role'], $_POST['order']);
        break;
    case 'deleteUserByID':
        deleteUserByID($_POST['user_id']);
        break;
    case 'deleteBuyerByID':
        deleteBuyerByID($_POST['userID']);
        break;
    case 'giveUnseenCommentsByID':
        giveUnseenCommentsByID($_SESSION['user_id']);
        break;
    case 'switchCommentPublicState':
        switchCommentPublicState($_POST['commentID']);
        break;
    case 'switchCommentHideState':
        switchCommentHideState($_POST['commentID']);
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
 * @param int $showHidden-> 1 show all comments, 0 suppres hidden comments
 */
function readCommentsForUser($userID, $showHidden) {
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
    $bc = new BuyerController();
    
    $disp = "";
    
    //get data from comment
    
    $comments = $cc->listCommentsByUser($userID, intval($showHidden));
    $logger->logToFile("showComments", "info", "got " . count($comments) . "comments from controller ");
    if (is_int($comments)) {
        echo "No unhidden comments found";
        return;
    }
    for ($i=0, $c=count($comments); $i<$c; $i++) {
        $logger->logToFile("showComments", "info", "load data for comment" . $i);
        //load and prepare buyer information
        $buyer = $bc->loadBuyerByID($comments[$i]['created_by']);
        $buyer_name = $buyer->getFirstname() . " " . $buyer->getLastname();
        $buyer_image_path = $ic->displayPicture("SMALL", $buyer->getPictureName());
        
        //load and prepare property information
        $property_images = $pc->giveImageHashesByPropertyID(intval($comments[$i]['property_id']));
        $logger->logToFile("showComments", "info", "Try to load prop image:" . $property_images[0]['image_name']);
        $property_image_path = $ic->displayPicture("MEDIUM", $property_images[0]['image_name']);
        
        $disp .= "<div class=\"row well\">
                    <div class=\"col-xs-6 col-sm-2\">
                        <a class=\"\" href=\"#\">
                            <img class=\"img-circle img-responsive\" src=\"../../" . $property_image_path . "\">
                            <h5><span class=\"badge\">Property ID:" . $comments[$i]['property_id'] ."</span></h5>
                        </a>
                    </div>
                <div class=\"clearfix visible-xs-block\"></div>
                <div class=\"col-xs-6 col-sm-6\">
                    <label><img class=\"img-circle thumbusercomment\" src=\"../../" . $buyer_image_path . "\">&nbsp;" . $buyer_name ." has commented:</label>
                    <p>" . $comments[$i]['comment'] . "</p>
                    <p><b>Answer:</b><br>" . $comments[$i]['answer'] . "</p>
                </div>
                
                <!-- Add the extra clearfix for only the required viewport -->
                <div class=\"clearfix visible-xs-block\"></div>
                <div class=\"col-xs-6 col-sm-4\">
                    <br><br><br> 
                    <div>";
                        if ($comments[$i]['answer'] == "") {
                            $disp .= "<a href=\"#ReplyComment\" data-toggle=\"modal\"><span class=\"badge\"><i class=\"glyphicon glyphicon-send\"></i>Reply&nbsp;</span></a>";
                        }
                        else {
                            $disp .= "&nbsp;";
                        }
        $disp .=        "<a href=\"#\"><span class=\"badge\"><i class=\"glyphicon glyphicon-info-sign\"></i>&nbsp;Show property details</span></a>";
                        if ($comments[$i]['isHidden'] == 1) {
                            $disp .= "<a href=\"#\" onclick=\"switchCommentHideState(" . $comments[$i]['comment_id']. ")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-eye-open\"></i>&nbsp;Unhide</span></a>";
                        }
                        else {
                            $disp .= "<a href=\"#\" onclick=\"switchCommentHideState(" . $comments[$i]['comment_id']. ")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-eye-close\"></i>&nbsp;Hide</span></a>";
                        }
                        if (!$comments[$i]['answer'] == ""){
                            if ($comments[$i]['isPublic'] == 1) {
                                $disp .= "<br><a href=\"#\" onclick=\"switchCommentPublicState(" . $comments[$i]['comment_id']. ")\" alt=\"Make private\"><span class=\"badge\"><i class=\"glyphicon glyphicon-star\"></i>&nbsp;Public</span></a>";
                            }
                            else {
                                $disp .= "<br><a href=\"#\" onclick=\"switchCommentPublicState(" . $comments[$i]['comment_id']. ")\" alt=\"Make public\"><span class=\"badge\"><i class=\"glyphicon glyphicon-star-empty\"></i>&nbsp;Private</span></a>";
                            }
                        }
                        
        $disp .=        "</div>
                </div>
                </div><!--endof row inside tab-->";
    };
    echo $disp;
    
}


function switchCommentPublicState($commentID) {
    //$logger = new Logging();
    //$logger->logToFile("switchCommentPublicState", "info", "Wanna switch for com# " . $commentID) ;
    $commentID = intval($commentID);
    $cc = new CommentController();
    $cc->switchCommentPublic($commentID);
    unset($cc);
}

function switchCommentHideState($commentID) {
    $logger = new Logging();
    $logger->logToFile("switchCommentHideState", "info", "Wanna switch for com# " . $commentID) ;
    $commentID = intval($commentID);
    $cc = new CommentController();
    $cc->switchCommentHideState($commentID);
    unset($cc);
}



function addBuyer() {
    $bc = new BuyerController();
    $buyerID = $bc->addBuyer( $_POST );
    $_SESSION['user_id'] = $buyerID;
    $_SESSION['role'] = BUYER_ROLE_ID;
    print_r($_POST);
}


function showUserlist( $role, $order ) {
    include ('../pathMaker.php');
    require_once($path.'/include/DatabaseComm.php');
 
    $dbComm = new DatabaseComm();
    $query = "SELECT * FROM users;";
    $result = $dbComm->executeQuery($query);

    $userlist = array();
    while ($row = $result->fetch_assoc())  
    {
    
        $user = array ("lname" => $row['lname'], 
                    "fname" => $row['fname'], 
                    "email" => $row['email'], 
                    "phone" => $row['phone'],
                    "address1" => $row['address1'],
                    "adress2" => $row['address2'],
                    "zipcode" => $row['zipcode'],
                    "city" => $row['city'],
                    "state" => $row['state'],
                    "country" => $row['country'],
                    "user_id" => $row['user_id'], 
                    "image_name" => $row['image_name'], 
                    "role" => $row['role'],
                    "enable" => $row['enable'], 
                    "modification_date" => $row['modification_date'],
                    "creation_date" => $row['creation_date']);
            array_push($userlist, $user);
    }

    $userlist = array_orderby($userlist, $order, SORT_ASC, "lname", SORT_ASC, "fname", SORT_ASC);
    
    foreach( $userlist as $user ) {
        print ' 
            <div class="row well"> 
              <div class="col-xs-12 col-sm-1">
                <br><br>
                <a class="" href="#">
                  <img class="img-circle img-responsive" src="./../../../images/images.jpg"  >
                </a>
              </div>
              <div class="col-xs-12 col-sm-3">
                <h6><span class="badge">First Name:</span>&nbsp;' . $user['fname'] . '</h6>
                <h6><span class="badge">Last Name:</span>&nbsp;' . $user['lname'] . '</h6>
                <h6><span class="badge">Role:</span>&nbsp;' . ucwords (strtolower ($user['role']) ) . '</h6>
                <h6>Creation_date: ' . $user['creation_date'] . '</h6>
                <h6>Modification_date: ' . $user['modification_date'] . '</h6>

              </div>
              <div class="col-xs-12 col-sm-3">
                  <h5><span class="badge">Adresse:</span></h5>
                  <p>' . $user["address1"]. $user['adress2'] . ', ' . $user['state'] . ' , ' . $user['zipcode'] . ' ' . $user['city'] . ' ' . $user['country'] . '</p> 

              </div>
              <div class="col-xs-12 col-sm-2">
                  <h5><span class="badge"><i class="glyphicon glyphicon-envelope"></i></span>&nbsp;' . $user['email'] . '</h5>
                  <h5><span class="badge"><i class="glyphicon glyphicon-phone-alt"></i></span>&nbsp;' . $user['phone'] . '</h5>
                  <h5><span class="badge"><i class="glyphicon glyphicon-cog"></i></span>&nbsp;' . ($user['enable'] == 1 ?  'Enabled' : 'Disabled' ) . '</h5>
              </div> 
              <div class="col-xs-12 col-sm-3">
                  <h5><span class="badge">Action:</span></h5>
                  <h5><a class="deleteUser" href="#'.$user['user_id'].'" id="deleteUser"><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a></h5>
                  <div style="display: inline;">'. ($user['enable'] == 0 ? '<a href=""><span class="badge"><i class="glyphicon glyphicon-ok-circle"></i>&nbsp;Enable</span></a>' :
                  '<a href=""><span class="badge"><i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Disable</span></a>').'</div>   
              </div> 
            </div><!--endof row of result inside tab-->

            <hr>';
    }
    
    return $userlist;
}

function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function deleteUserByID( $user_id ) {
    include ('../pathMaker.php');
    require_once($path.'/include/DatabaseComm.php');
   
    $sqlQuery = "DELETE FROM users WHERE user_id = " . $userID . ";";
    $result = $this->dbcomm->executeQuery($sqlQuery);
    
    if ($result != true)
    {
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

function giveUnseenCommentsByID($user_id) {
    $logger = new Logging();
    $user_id = intval($user_id);
    $cc = new CommentController();
    $logger->logToFile("countComments", "info", $cc->giveCountOfUnansweredComments($user_id) );
    echo $cc->giveCountOfUnansweredComments($user_id);
}

?>
