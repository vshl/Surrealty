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
require_once './include/DatabaseComm.php';
require_once './classes/Comment.php';

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
    
    public function setCommentPublic( $commentID, $setPublic ) {
        $comment = new Comment();
        $comment->loadCommentByID($commentID);
        $comment->setShowPublic($setPublic);
        $comment->updateComment();
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
    
}

?>