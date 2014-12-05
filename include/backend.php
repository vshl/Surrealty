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

require_once '../controllers/AdminController.php';
require_once '../controllers/AgentController.php';
require_once '../controllers/BuyerController.php';

//require_once 'AdminControler.php';
require_once '../controllers/ImageController.php';
require_once '../controllers/CommentController.php';
require_once '../classes/Logging.php';
require_once '../controllers/AuthenticationController.php';
require_once '../controllers/PropertyController.php';

//useful consts

CONST FLAG_BUYER_NOT_READ_ANSWER    = 1;    // Buyer hasn't seen the answer yet
CONST FLAG_BUYER_HIDE_COMMENT       = 2;    // Buyer hides this comment
CONST FLAG_AGENT_REPLIED_COMMENT    = 4;    // Agent has replied this comment
CONST FLAG_AGENT_HIDE_COMMENT       = 8;    // Agent hides this comment
CONST FLAG_COMMENT_IS_PUBLIC        = 16;   // This comment is public



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
  case 'RegisterAndRedirect':
        RegisterAndRedirect();
        break;
  case 'sentResetCode':
        sentResetCode($_POST['email']);
        break;
    case 'listAllBuyersAsTable':
        listAllBuyersAsTable();
        break;
    case 'readCommentsForUser':
        if ($_SESSION['role'] == "AGENT") {
           readCommentsForAgent($_SESSION['user_id'], $_POST['showOld']); 
        }
               
        break;
    case 'showUserlist':
        showUserlist($_POST['role'], $_POST['order'], $_POST['ascdesc']);
        break;
    case 'showUnprovenProperties':
        showUnprovenProperties($_POST['order'], $_POST['ascdesc']);
        break;
    case 'deleteUserByID':
        deleteUserByID($_POST['userID'], $_POST['role']);
        break;
    case 'enableUserByID': 
        enableUserByID($_POST['userID'], $_POST['role'], $_POST['enable']);
        break;
 case 'deletePropertyByID':
        deletePropertyByID($_POST['propertyID']);
        break;
    case 'approvePropertyByID':
        approvePropertyByID($_POST['propertyID']);
        break;
    case 'loadUserInformation':
        loadUserInformationByID( $_SESSION['user_id'], $_SESSION['role'] );
        break;
    case 'giveUnseenCommentsByAgentID':
        giveUnseenCommentsByAgentID($_SESSION['user_id']);
        break;
    case 'switchCommentPublicState':
        switchCommentPublicState($_POST['commentID']);
        break;
    case 'switchCommentHideState':
        switchCommentHideState($_POST['commentID']);
        break;
    case 'returnAnswerToComment':
        returnAnswerToComment($_POST['commentID'], $_POST['answerText']);
        break;
    case 'removeComment':
        removeComment($_POST['commentID'], $_SESSION['user_id']);
        break;
    case 'readPublicCommentsForProperty':
        readPublicCommentsForProperty($_POST['propertyID']);
        break;
    case 'sellProperty':
        sellProperty($_POST['message']);
        break;
    case 'createCommentByListingID':
        sendCommentByPropertyID($_SESSION['user_id'], $_POST['listingID'], $_POST['comment']);
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


// maybe deletet ? unsued ?
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
    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password'])); 
    
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

function RegisterAndRedirect() {
     // strip_tags removes all html and php tags from string
    
    $fname = strip_tags($_POST['fname']);
    $lname = strip_tags($_POST['lname']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $phone = strip_tags($_POST['phone']);
    $image_name = strip_tags($_POST['image_name']);
    $address1 = strip_tags($_POST['address1']);
    $address2 = strip_tags($_POST['address2']);
    $zipcode = strip_tags($_POST['zipcode']);
    $city = strip_tags($_POST['city']);
    $state = strip_tags($_POST['state']);
    $country = strip_tags($_POST['country']);
      $user= array( 
       fname => $fname ,
       lname => $lname ,
       email => $email ,
       password => trim($password) , 
       phone => $phone ,
       image_name => $image_name ,
       address1 => $address1 ,
       address2 => $address2 ,  
       zipcode => $zipcode , 
       city => $city ,
       state => $state ,
       country => $country        
          
      );
           
    $ac = new AuthenticationController();
    $res = $ac->registerNewUser($user);

}
/** 
  *
 *  @param int $showHidden-> 1 show all comments, 0 suppres hidden comments
 */
function readCommentsForAgent($agentID, $showHidden) {
    $logger = new Logging();
    $agentID = intval($agentID);
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
    
    $comments = $cc->listCommentsByAgent($agentID, intval($showHidden));
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
        $buyer_address = $buyer->getAddress1(). ", " . $buyer->getZipCode(). ", " . $buyer->getCity();
        $buyer_phone = $buyer->getPhone();
        
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
                    <label><img id=\"comment_".$comments[$i]['comment_id']."_userimage\" class=\"img-circle thumbusercomment\" src=\"../../" . $buyer_image_path . "\">&nbsp;<span id=\"comment_".$comments[$i]['comment_id']."_username\">" . $buyer_name ."</span> has commented:</label>
                    <span id=\"comment_".$comments[$i]['comment_id']."_address\" style=\"display:none\">" . $buyer_address . "</span>
                    <span id=\"comment_".$comments[$i]['comment_id']."_phone\" style=\"display:none\">" . $buyer_phone . "</span>    
                    <p id=\"comment_".$comments[$i]['comment_id']."_comment\">" . $comments[$i]['comment'] . "</p>
                    <p id=\"comment_".$comments[$i]['comment_id']."_answer\"><b>Answer:</b><br>" . $comments[$i]['answer'] . "</p>
                </div>
                
                <!-- Add the extra clearfix for only the required viewport -->
                <div class=\"clearfix visible-xs-block\"></div>
                <div class=\"col-xs-6 col-sm-4\">
                    <br><br><br> 
                    <div>";
                        if ($comments[$i]['answer'] == "") {
                            $disp .= "<a href=\"#ReplyComment\" data-toggle=\"modal\" onClick=\"transferCommentDataToReplyModal(".$comments[$i]['comment_id'].")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-send\"></i>Reply&nbsp;</span></a>";
                        }
                        else {
                            $disp .= "<a href=\"#ReplyComment\" data-toggle=\"modal\" onClick=\"transferCommentDataToReplyModal(".$comments[$i]['comment_id'].")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-pencil\"></i>Modify&nbsp;</span></a>";
                        }
        $disp .=        "<a href=\"#\"><span class=\"badge\"><i class=\"glyphicon glyphicon-info-sign\"></i>&nbsp;Show property details</span></a>";
                        if ($cc->isFlagSet($comments[$i]['flags'], FLAG_AGENT_HIDE_COMMENT)) {
                            $disp .= "<a href=\"#\" onclick=\"switchCommentHideState(" . $comments[$i]['comment_id']. ")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-eye-open\"></i>&nbsp;Unhide</span></a>";
                        }
                        else {
                            $disp .= "<a href=\"#\" onclick=\"switchCommentHideState(" . $comments[$i]['comment_id']. ")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-eye-close\"></i>&nbsp;Hide</span></a>";
                        }
                        if (!$comments[$i]['answer'] == ""){
                            if ($cc->isFlagSet($comments[$i]['flags'], FLAG_COMMENT_IS_PUBLIC)) {
                                $disp .= "<br><a href=\"#\" onclick=\"switchCommentPublicState(" . $comments[$i]['comment_id']. ")\" alt=\"Make private\"><span class=\"badge\"><i class=\"glyphicon glyphicon-star\"></i>&nbsp;Public</span></a>";
                            }
                            else {
                                $disp .= "<br><a href=\"#\" onclick=\"switchCommentPublicState(" . $comments[$i]['comment_id']. ")\" alt=\"Make public\"><span class=\"badge\"><i class=\"glyphicon glyphicon-star-empty\"></i>&nbsp;Private</span></a>";
                            }
                        }
        $disp .=        "<a href=\"#\" onclick=\"removeComment(" . $comments[$i]['comment_id']. ")\"><span class=\"badge\"><i class=\"glyphicon glyphicon-trash\"></i>&nbsp;Remove</span></a>";                
                        
        $disp .=        "</div>
                </div>
                </div><!--endof row inside tab-->";
    };
    echo $disp;
    
}

function readPublicCommentsForProperty($propertyID) {
    $propertyID = intval($propertyID);
    // load a array with the matching comments
    $cc = new CommentController();
    $bc = new BuyerController();
    $ac = new AgentController();
    
    $comments = $cc->loadAllCommentsByProperty($propertyID);
    if (is_int($comments)) {
        $disp = "<div class=\"row well\"><h4>No commets for this property avaiable</h4></div>";
    }
    else {
        $disp = "";
        for ($i=0, $c=count($comments); $i<$c; $i++) {
            $buyer = $bc->loadBuyerByID($comments[$i]['created_by']);
            $agent = $ac->loadAgentByID($comments[$i]['answered_by']);
            
            $disp .=    "<div class=\"row well\"> " .
                        "<b>" .$buyer->getFirstname() . " " . $buyer->getLastname() . "</b> asked: " . $comments[$i]['comment'];
            $disp .=    "<br>".
                        "<b>" . $agent->getFirstname() . " " . $agent->getLastname() . "</b> replied: " . $comments[$i]['answer'];
            $disp .=    "</div>";
            
           
            }
    }
    echo $disp;
}


function switchCommentPublicState($commentID) {
    //$logger = new Logging();
    //$logger->logToFile("switchCommentPublicState", "info", "Wanna switch for com# " . $commentID) ;
    
    $commentID = intval($commentID);
    $cc = new CommentController();
    $cc->switchCommentPublic($commentID, $_SESSION['role']);
    unset($cc);
}

function switchCommentHideState($commentID) {
    
    //$logger = new Logging();
    //$logger->logToFile("switchCommentHideState", "info", "Wanna switch for com# " . $commentID) ;
    $commentID = intval($commentID);
    $cc = new CommentController();
    $cc->switchCommentHideState($commentID, $_SESSION['role']);
    unset($cc);
    
//unset($logger);
}

function returnAnswerToComment($commentID, $answerText) {
    //$logger = new Logging();
    $commentID = intval($commentID);
    $cc = new CommentController();
    //$logger->logToFile("answerComment", "info", "update comment with: " . $commentID . " " . $_SESSION['user_id']. " " . $answerText);
    $result = $cc->setAnwser($commentID, $_SESSION['user_id'], $answerText);
    echo $result;
    unset($cc);
    //unset($logger);
    
}

function removeComment($commentID, $userID) {
    $userID = intval($userID);
    $commentID = intval($commentID);
    $cc = new CommentController();
    $comment = $cc->loadCommentByCommentID($commentID);
    if (is_int($comment)) {
        echo 0;
    }
    // a short check if userID is allowed to delete comment.
    if ($comment->getAgentID() == $userID) {
        $cc->deleteCommentByID($commentID);
        echo 1;
    }
    else {
        echo 0;
    }
}


function addBuyer() {
    $bc = new BuyerController();
    $buyerID = $bc->addBuyer( $_POST );
    $_SESSION['user_id'] = $buyerID;
    $_SESSION['role'] = BUYER_ROLE_ID;
    print_r($_POST);
}


function showUserlist( $role, $order, $ascdesc ) {
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
                    "delet" => $row['delet'],
                    "modification_date" => $row['modification_date'],
                    "creation_date" => $row['creation_date']);
       if( $user['delet'] == 1)
            continue;
  
        if( strtoupper($role) == $user['role'] || $role == 'all' ) {
            array_push($userlist, $user);
        } else {
            unset($user);
            continue;
        }
    }
    
    if( $ascdesc == "asc") {
        $userlist = array_orderby($userlist, $order, SORT_ASC, "lname", SORT_ASC);
    } else {
        $userlist = array_orderby($userlist, $order, SORT_DESC, "lname", SORT_DESC );
    }
      
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
                  <h5><a href="" onclick="javascript:deleteUserByID(\''. $user['user_id'] .'\', \''. $user['role'] .'\');" ><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a></h5>
                  <div style="display: inline;">'. ($user['enable'] == 0 ? '<a href="" onclick="javascript:enableUser(\''. $user['user_id'] .'\', \''. $user['role'] .'\', 1);"><span class="badge"><i class="glyphicon glyphicon-ok-circle"></i>&nbsp;Enable</span></a>' :
                  '<a href="" onclick="javascript:enableUser(\''. $user['user_id'] .'\', \''. $user['role'] .'\', 0);"><span class="badge"><i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Disable</span></a>').'</div>   
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
                $tmp[$key] = strtolower($row[$field]);
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function deleteUserByID( $userID, $role ) {
    switch ( $role ) {
        case 'ADMIN':
            $ac = new AdminController();
            $ac->deleteAdminByID($userID);
            unset($ac);
            break;
        case 'AGENT':
            $ac = new AgentController();
            $ac->deleteAgentByID($userID);
            unset($ac);
            break;
        case 'BUYER':
            $bc = new BuyerController();
            $bc->deleteBuyerByID($userID);
            unset($bc);
            break;
        default :
            echo 0;
    }
    
}

function enableUserByID($userID, $role, $enable) {
    switch ( $role ) {
        case 'ADMIN':
            $ac = new AdminController();
            echo $ac->enableAdminByID($userID, $enable);
            break;
        case 'AGENT':
            $ac = new AgentController();
            echo $ac->enableAgentByID($userID, $enable);
            break;
        case 'BUYER':
            $bc = new BuyerController();
            echo $bc->enableBuyerByID($userID, $enable);
            break;
        default :
            echo "0";
    }   
}

function giveUnseenCommentsByAgentID($agentID) {
    $logger = new Logging();
    $agentID = intval($agentID);
    $cc = new CommentController();
    $logger->logToFile("countComments", "info", $cc->giveCountOfUnansweredCommentForAgent($agentID) );
    echo $cc->giveCountOfUnansweredCommentForAgent($agentID);
}


function loadUserInformationByID($userID, $role) {
    switch ( $role ) {
        case 'ADMIN':
            $ac = new AdminController();
            $user = $ac->loadAdminByID($userID);
            $info = $user->giveArray();
            break;
        case 'AGENT':
            $ac = new AgentController();
            $user = $ac->loadAgentByID($userID);
            $info = $user->giveArray();
            break;
        case 'BUYER':
            $bc = new BuyerController();
            $user = $bc->loadBuyerByID($userID);
            $info = $user->giveArray();
            break;
        default :
            return "0";
    }   

        print '
              <form action="" methode="">


                      <div class="input-group" title="firstname">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" name="firstname" id="" type="" placeholder="your first name" value="'.$info["fistname"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="lastname">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" name="lastname" id="" type="" placeholder="your last name" value="'.$info["lastname"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="email">
                        <span class="input-group-addon">@</span>
                        <input class="form-control" name="email" id="" type="" placeholder="your e-mail" value="'.$info["email"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="Password">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control" name="password" id="password" type="password" placeholder="your password" disabled="disabled">
                      </div>

                      <div class="input-group" title="phone">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                        <input class="form-control" name="phone" id="" type="" placeholder="your phone number" value="'.$info["phone"].'" disabled="disabled">
                      </div>



                      <div class="input-group" title="addr1">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control" name="addr1" id="" type="" placeholder="your first adresse" value="'.$info["address1"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="addr2">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input class="form-control" name="addr2" id="" type="" placeholder="your seconde adresse" value="'.$info["address2"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="zip">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                        <input class="form-control" name="zip" id="" type="" placeholder="your zip code" value="'.$info["zipcode"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="city">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                        <input class="form-control" name="city" id="" type="" placeholder="your city name" value="'.$info["city"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="state">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                        <input class="form-control" name="state" id="" type="" placeholder="your state name" value="'.$info["state"].'" disabled="disabled">
                      </div>

                      <div class="input-group" title="image">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                        <span class="btn btn-default btn-file"><input type="file" data-filename-placement="inside" name="image" title="Search for a file to add" disabled="disabled"></span>
                      </div>

                  <a href="#UpdateProfile" class="modal-toggle" data-toggle="modal">
                    <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-wrench"></i> Modify</button>
                  </a>



         </form>';
}

function showUnprovenProperties($oder, $ascdesc) {
    $pc =  new PropertyController();
    $properties = $pc->giveUnprovenProperties();
   

    foreach( $properties as $property ) {
        $ac = new AgentController();
        $agent = $ac->loadAgentByID($property['created_by']);
        
      print '
                    <div class="row well">

                        <div class="col-xs-12 col-sm-2">
                                <a class="" href="#">
                                  <img class="img-circle img-responsive" src="./../../../images/house2.jpg"  >
                                </a>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                                <h5><span class="badge">Property ID:'.$property['property_id'].'</span></h5>
                                  <h6>Creation-date: '.$property['creation_date'].'</h6>
                                  <h6>Modification-date: '.$property['modification_date'].'</h6>
                                  <h6>Created_by: '.$agent->getFirstname().' '.$agent->getLastname().'</h6>
                                  <h6>Price: '.$property['price'].'$</h6>
                                  <br>

                                                           
                        </div>
                        <div class="col-xs-12 col-sm-3">
                                  <h5><span class="badge">Adresse:</span></h5>
                                  <p><br>203 East 50th St., Suite 1157 New York, NY 10022 '.$property['country'].'</p> 
                        </div>
                        <div class="col-xs-12 col-sm-2">
                                  <h5><span class="badge">Facts:</span></h5>
                                  <h6>Baths: '.$property['baths'].'</h6>
                                   <h6>Beds: '.$property['beds'].'</h6>
                                  <h6>Surface: '.$property['area'].' m&sup2;</h6>
                                  <h6>Pool: '.$property['pool'].'</h6>
                                  <h6>Balcon: '.$property['balcony'].'</h6>
                        </div> 
                        <div class="col-xs-12 col-sm-2">
                                  <h5><span class="badge">Action:</span></h5>
                                  <h5><a href="" onclick="javascript:deletePropertyByID(\''. $property['property_id'] .'\');"><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a></h5>
                                  <h5><a href="" onclick="javascript:approvePropertyByID(\''. $property['property_id'] .'\');"><span class="badge"><i class="glyphicon glyphicon-ok-circle"></i>&nbsp;Approve</span></a></h5>
                                  
                        </div> 

                </div><!--endof row of result inside tab-->';
    }
    
}

function deletePropertyByID($propertyID) {
    $pc = new PropertyController();
    echo $pc->deletePropertyByID($propertyID);
}

function approvePropertyByID($propertyID) {
    $pc = new PropertyController();
    echo $pc->approvePropertyByID($propertyID);
}

function sendCommentByPropertyID($userID, $propertyID, $comment) {
    $cc = new CommentController();
    $result = $cc->addComment($userID, $propertyID, $comment);
    echo $result;
    
}

function sellProperty($message) {
    $result = sendMail("fhahner@sfsuswe.com", "Person want to sell property", $message);
    if ($result) {
        echo 1;
    }
    else {
        echo 0;
    }
}

function sendMail($to,$subject,$message) {
    $message = wordwrap($message);
    return mail($to,$subject,$message);
}
function sentResetCode($email) {
    $ac = new AuthenticationController();
    $code = $ac->sentResetCode($email);

    $success =  mail($email, "Password Reset", "Please follow the link to reset your Password.\nhttp://sfsuswe.com/~bbleic/pages/home.php?code=".$code."&email=".$email);
   
    if( $code !== "0" && $success) {
        return 1;
    } else {
        return 0;
    }
}
?>
