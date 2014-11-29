<?php
/**
 * Controler Class for Comment objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */
require_once '../include/DatabaseComm.php';
require_once '../classes/Comment.php';
require_once '../classes/Logging.php';

class CommentController {
   
    
    public function __construct() {
        $this->dbcomm = new DatabaseComm();
        
    }
    
    public function __destruct() {
       
        unset ($this->dbcomm); 
    }
    
    /**
     * load all comments which belong to a propertyID
     * 
     * @param int $propertyID property of which the comments will be loaded
     * @return int
     */
    public function loadAllCommentsByProperty($propertyID) {
        $list = array();
        
        $sqlQuery = "SELECT * FROM comments WHERE property_id = ".$propertyID.";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        while ($row = $result->fetch_assoc())  
        {
                $comment = new Comment();
                // Copy data from database into comment object
                $comment->addDataToComment($row['property_id'], $row['created_by'], $row['comment'] );
                $comment->setCommentID( $row['comment_id'] );
                $comment->setCreationDate($row['creation_date']);
                $comment->setAnswerText($row['answer']); 
                array_push ($list, $comment);
                unset ($comment);
        }
        
        return $list;
    }
    
    /**
     * 
     * ÜBERFLÜSSIG ??????? HAHNER, 28Nov 2014
     * 
     * load all comments which belogsn to an agentID
     * 
     * @param String $agentID
     * @return Comment array 
     */
       
    public function loadAllCommentsByAgentID($agentID) {
        $list = array();
        
        $sqlQuery = "SELECT * FROM comments WHERE answered_by = ".$agentID.";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        while ($row = $result->fetch_assoc())  
        {
                $comment = new Comment();
                // Copy data from database into comment object
                $comment->addDataToComment($row['property_id'], $row['created_by'], $row['comment'] );
                $comment->setCommentID($row['comment_id']);
                $comment->setCreationDate($row['creation_date']);
                $comment->setAnswerText($row['answer']); 
                $comment->setAgentID($row['answered_by']);
                array_push ($list, $comment);
                unset ($comment);
        }
        
        return $list;

    }
    /**
     * switch the public status of a given comment
     * @param type $commentID
     */
    public function switchCommentPublic( $commentID ) {
        $logger = new Logging();
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        $logger->logToFile("switchCommentPublic", "info", $comment->getCommendID());
        $cur_state = intval($comment->getIsPublic());
        if ($cur_state == 1) {   
            $comment->setIsPublic(0);
        }
        else {
            $comment->setIsPublic(1);
        }
            
        $comment->updateComment();
        unset ($logger);
        unset ($comment);
    }
    
    public function switchCommentHideState( $commentID) {
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        $cur_state = intval($comment->getIsHidden());
        if ($cur_state == 1) {   
            $comment->setIsHidden(0);
        }
        else {
            $comment->setIsHidden(1);
        }
            
        $comment->updateComment();
        unset ($logger);
        unset ($comment);
    }
    
    public function addComment( $userID, $propertyID, $commentText ) {
        $comment = new Comment();
        $comment->addDataToComment($propertyID, $userID, $commentText );
        $comment->saveComment();
        unset ($comment);
    }
    
    public function deleteCommentByID( $commentID ) {
        $comment = new Comment();
        $comment->deleteComment( $commentID );
        unset ($comment);
    }
    
    public function setAnwser( $commentID, $agentID, $answerText  ) {
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        $comment->setAgentID($agentID);
        $comment->setAnswerText($answerText);
        $comment->updateComment();
        unset ($comment);
    }
    
    /**
     * This function return an array with all comments belongs to one agent / user
     * @param type $userID
     * @param int $showHidden -> show hidden comments too [1 = show hidden comments; 0 = suppres hidden comments]
     * @return array [comment_id,property_id,comment,creation_date,created_by,answered_by,answer,answer_date,isSeen]
     */
    
    public function listCommentsByUser($userID, $showHidden = 1) {
        if (!is_int($userID)) {
            return 0;
        }
        $db = new DatabaseComm();
        if ($showHidden == 1) {
            $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $userID .";";
        }
        else {
            $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $userID ." AND com.isHidden = 0;"; 
        }
        $result = $db->executeQuery($query);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        } else {
            return 0;          
        }
        return $comments;
    }
    
    /**
     * return the unseen comments for a give $userID
     * 
     * @param int $userID
     * @return int -> Number of unseen Comments
     */
    
    public function giveCountOfUnansweredComments($userID) {
        if (!is_int($userID)) {
            return 20;
        }
        $db = new DatabaseComm();
        $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $userID ." AND com.answer = \"\";";
        $result = $db->executeQuery($query);
        return $result->num_rows;
    }
    
       
}

?>