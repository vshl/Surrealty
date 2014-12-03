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
    
    public function loadCommentByCommentID($commentID) {
        $comment_id = intval($commentID);
        $comment = new Comment();
        $result = $comment->loadCommentByID($comment_id);
        if ($result == 0) {
            return 0;
        }
        return $comment;
    }
    /**
     * switch the public status of a given comment
     * @param type $commentID
     */
    public function switchCommentPublic($commentID, $userRole ) {
        $logger = new Logging();
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        $logger->logToFile("switchCommentPublic", "info", $comment->getCommendID());
        if ($userRole == "AGENT") {
            $comment->setCommentPublic(!$comment->isCommentPublic());
        }
        $comment->updateComment();
        unset ($logger);
        unset ($comment);
    }
    
    public function switchCommentHideState($commentID, $userRole) {
        $logger = new Logging();
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        if ($userRole == "AGENT") {
            $comment->setAgentHideComment(!$comment->isAgentHideComment());
        }
        if ($userRole == "BUYER") {
            $comment->setBuyerHideComment(!$comment->isBuyerHideComment());
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
        $comment->setAgentRepliedComment(TRUE);
        $comment->setBuyerNotReadAnswer(TRUE);
        $result = $comment->saveAnswerToComment();
        unset ($comment);
        return $result;
    }
    
    /**
     * This function return an array with all comments belongs to one agent
     * @param type $agentID
     * @param int $showHidden -> show hidden comments too [1 = show hidden comments; 0 = suppres hidden comments]
     * @return array [comment_id,property_id,comment,creation_date,created_by,answered_by,answer,answer_date,isSeen]
     */
    
    public function listCommentsByAgent($agentID, $showHidden = 1) {
        $logger = new Logging();
        if (!is_int($agentID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $agentID .";";
        $logger->logToFile("listCommentByAgent", "info", $query);
        $result = $db->executeQuery($query);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($showHidden == 1) {
                    $comments[] = $row;
                }
                else {
                    if (!$this->isFlagSet($row['flags'], 8)) {
                        $comments[] = $row;
                    }
                }
            }
        } 
        else {
            return 0;          
        }
        return $comments;
    }
    
   
    
    /**
     * This function returns the count of unanswered Comments for a given agent
     * 
     * @param type $agentID
     * @return int
     */
    
    public function giveCountOfUnansweredCommentForAgent($agentID) {
        $logger = new Logging();
        if (!is_int($agentID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "Select com.flags FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $agentID . " ;";
        $result = $db->executeQuery($query);
        $comments = array();
        $logger->logToFile("count unansered comment", "info", "number of rows" .$result->num_rows);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ( ($row['flags'] == 0) OR ($row['flags'] == 2) ) {
                    //$logger->logToFile("count unanswered comment", "info", "found unanswered com: " . $row['comment'] ." with flag " . $row['flags']);
                    $comments = $row;
                }
            }
            return count($comments);
        }
        else {
            return 0;
        }
    }
    
    /** 
     * this function return the count of unreaded replied comments for
     * a give buyer
     * 
     * @param int $buyerID
     * @return int Number of comments
     */
    
    public function giveCountOfUnreadRepliesForBuyer($buyerID) {
        if (!is_int($buyerID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "Select com.flags FROM comments com, property prop WHERE com.property_id = prop.property_id AND com.created_by = " . $buyerID . " ;";
        $result = $db->executeQuery($query);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ( ($row['flags'] == 0) OR ($row['flags'] == 2) ) {
                    $comments = $row;
                }
            }
            return count($comments);
        }
        else {
            return 0;
        }
    }
    
    
   
    
    public function isFlagSet($input, $flag)
    {
      return (($input & $flag) == $flag);
    }
    
       
}

?>