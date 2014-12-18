<?php
/**
 * Controler Class for Comment objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
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
        $logger = new Logging();
        $sqlQuery = "SELECT * FROM comments WHERE property_id = ".$propertyID.";";
        $logger->logToFile("loadPuvlicComments", "inf", $sqlQuery);
        $result = $this->dbcomm->executeQuery($sqlQuery);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($this->isFlagSet($row['flags'], Comment::FLAG_COMMENT_IS_PUBLIC)) {
                    
                    $comments[] = $row;
                    $logger->logToFile("loadPublicComment", "info", "one hit" .$row['comment_id']);
                }
            }
            $logger->logToFile("loadPublicComment", "info", "counted comments: ". count($comments));
            if (count($comments) > 0) {
            return $comments;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
    
    /**
     * this function loads a comment by its id
     * @param type $commentID the id of the comment
     * @return the comment object or int(0) by failure
     */
    
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
    
    /**
     * this function will switch the hidden state for a given comment relating to userRole
     * @param type $commentID
     * @param type $userRole
     */
    public function switchCommentHideState($commentID, $userRole) {
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        if ($userRole == "AGENT") {
            $comment->setAgentHideComment(!$comment->isAgentHideComment());
        }
        if ($userRole == "BUYER") {
            $comment->setBuyerHideComment(!$comment->isBuyerHideComment());
        }
        $comment->updateComment();
        unset ($comment);
    }
    
    /**
     * this function add a new command to database
     * @param type $userID the user id from logged in user
     * @param type $propertyID the id, for which property the comment is for
     * @param type $commentText the comment text
     * @return type forward return value from called function
     */
    public function addComment( $userID, $propertyID, $commentText ) {
        $comment = new Comment();
        $comment->addDataToComment($propertyID, $userID, $commentText );
        $result = $comment->saveNewComment();
        unset ($comment);
        return $result;
       
    }
    
    /**
     * this function delete a comment by a given id
     * 
     * @param type $commentID
     */
    
    public function deleteCommentByID( $commentID ) {
        $comment = new Comment();
        $comment->deleteComment( $commentID );
        unset ($comment);
    }
    
    /**
     * this function save the reply for an existing comment
     * @param type $commentID 
     * @param type $agentID the agent whos replieing
     * @param type $answerText the answer text string
     * @return type
     */
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
     * this function let an agent or an user modify a given comment
     * @param type $commentID
     * @param type $buyerID
     * @param type $commentText
     * @return int
     */
    public function setModifiedComment($commentID, $buyerID, $commentText) {
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        //check transmitted buyerID with saved buyerID in database
        if ($buyerID != $comment->getUserID()) {
            return 0; // something wrong, maybe security breach
        }
        $comment->setCommentText($commentText);
        return $comment->updateComment();
    }
    
    /**
     * This function return an array with all comments belongs to one agent
     * @param type $agentID
     * @param int $showHidden -> show hidden comments too [1 = show hidden comments; 0 = suppres hidden comments]
     * @return array [comment_id,property_id,comment,creation_date,created_by,answered_by,answer,answer_date,isSeen]
     */
    
    public function listCommentsByAgent($agentID, $showHidden = 1) {
        //$logger = new Logging();
        if (!is_int($agentID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $comments = array();
        $noCommentsAvailable = true;
        
        // we first want to display all the unanswered comments and add them to array
        $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $agentID ." AND com.flags < 3;";
        //$logger->logToFile("listCommentByAgent", "info", $query);
        $result = $db->executeQuery($query);
        if ($result->num_rows > 0) {
            $noCommentsAvailable = false;
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
        // after that we fetch the remaining comment ordered by their creation_date
        $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND prop.agent_id = " . $agentID ." AND com.flags > 3 ORDER BY com.creation_date;";
        //$logger->logToFile("listCommentByAgent", "info", $query);
        $result = $db->executeQuery($query);
        if ($result->num_rows > 0) {
            $noCommentsAvailable = false;
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
        // if the is no comment to display, we return a 0;
        if ($noCommentsAvailable) {
            return 0;          
        }
        return $comments;
    }
    
    /**
     * This function returns an array with all comments written by a given user
     * 
     * @author Florian Hahner <florian.hahner@informtik.hs-fulda.de>
     *      * 
     * @param type $buyerID
     * @param type $showHidden
     * @return int(0) if error, array of comments if success
     */
     public function listCommentsByBuyer($buyerID, $showHidden = 1) {
        //$logger = new Logging();
        if (!is_int($buyerID)) {
            return 0;
        }
        $db = new DatabaseComm();
        $query = "Select com.* FROM comments com, property prop WHERE com.property_id = prop.property_id AND com.created_by = " . $buyerID .";";
        //$logger->logToFile("listCommentByBuyer", "info", $query);
        $result = $db->executeQuery($query);
        $comments = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($showHidden == 1) {
                    $comments[] = $row;
                }
                else {
                    if (!$this->isFlagSet($row['flags'], Comment::FLAG_BUYER_HIDE_COMMENT)) {
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
     * 
     * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
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
                if ( ($this->isFlagSet($row['flags'], Comment::FLAG_BUYER_HIDE_COMMENT)) OR ($row['flags'] == 0) ) {
                    $logger->logToFile("count unanswered comment", "info", "found unanswered com with flag " . $row['flags']);
                    $comments[] = $row;
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
     * 
     * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
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
                if ( $this->isFlagSet($row['flags'], Comment::FLAG_BUYER_NOT_READ_ANSWER) ) {
                    
                    $comments[] = $row;
                }
            }
            return count($comments);
        }
        else {
            return 0;
        }
    }
     
    public function isFlagSet($input, $flag) {
      return (($input & $flag) == $flag);
    }
 }

?>