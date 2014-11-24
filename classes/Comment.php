<?php
/**
 * Model Class for comment objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */
class Comment {
    
    private $commentID;
    private $propertyID;
    private $commentText;
    private $creationDate;
    private $createdByUserID;
    private $answeredByAgentID;
    private $showPublic;
    private $answerText;
    private $dbcomm;
    
    
    public function __construct() {
        $this->showPublic = false;
        $this->dbcomm = new DatabaseComm();
        $this->answerText = null;
        $this->answeredByAgentID = null;
    }
    
    public function __destruct() {
         unset ($this->dbcomm); 
    }
    
    /**
     * load a comment by ID
     * @param type $commentID
     * @return int Statuscode ( 1 > comment loaded, 0 > No Data for ID found ) 
     */
    public function loadCommentByID($commentID) {
        $sqlQuery = "SELECT * FROM comments WHERE comment_id = ".$commentID.";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        if ($this->dbcomm->affectedRows() == 1) 
            {
                $row = mysqli_fetch_assoc($result);
                // Copy data from database into comment object
                $this->commentID = $row['comment_id'];
                $this->propertyID = $row['property_id'];
                $this->commentText = $row['comment'];
                $this->creationDate = $row['creation_date'];
                $this->createdByUserID = $row['created_by'];
                $this->answeredByAgentID = $row['answered_by'];
                $this->answerText = $row['answer'];  // to be renamed in mysql
                
                return 1;
            }
            else
            {
                return 0;
            }
    }
    
    /**
     * creates a new comment in the database
     * uses private attributes
     * @return int Statuscode ( 1 > comment saved, 0 > error while saving ) 
     */
    public function saveComment() {
        $sqlQuery = "INSERT INTO comments (property_id, comment, creation_date, created_by, answer, answered_by) VALUES ('" .
                $this->propertyID . "', '" . $this->commentText . "', 
                now() , '" . $this->createdByUserID . "', '" . 
                $this->answerText . "', '" . $this->answeredByAgentID . "');";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at comment saving");
        }
        else
        {
            return 1;
        }
    }
  
    function updateComment() {
        $sqlQuery = "UPDATE comments SET " .
                "property_id='" . $this->propertyID . "', " . 
                "comment='" . $this->commentText . "', " . 
                "creation_date='" . $this->creationDate . "', " .
                "created_by='" . $this->createdByUserID . "', " .
                "answer='" . $this->answerText . "', " .
                "answered_by='" . $this->answeredByAgentID . "' " . 
                "WHERE comment_id = " . $this->commentID . ";";
             
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at comment update");
        }
        else
        {
            return 1;
        }   
    }
    /**
     * @param int $commentID of comment which has to be removed
     * @return int Statuscode ( 1 > comment deleted, 0 > No Data for ID found ) 
     */
    public function deleteComment($commentID) {
        $sqlQuery = "DELETE FROM comments WHERE comment_id = ".$commentID.";";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true)
        {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at delete comment");
        }
        else
        {
            return 1;
        }
    }
    
    
    /**
     * @param int $propertyID ID of the property
     * @param int $userID ID of the user
     * @param String $comment text of the comment
     */
    public function addDataToComment( $propertyID, $userID, $comment ) {
        $this->propertyID = $propertyID;
        $this->createdByUserID = $userID;
        $this->commentText = $comment;
    }
    
   
    
    public function setCommentID($commentID) {
        $this->commentID = $commentID;
    }
    
    public function setPropertyID($propertyID) {
        $this->propertyID = $propertyID;
    }
    
    public function setCommentText($commentText) {
        $this->commentText = $commentText;
    }
    
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
    public function setUserID($userID) {
        $this->createdByUserID = $userID;
    }
    
    public function setShowPublic($showPublic) {
        $this->showPublic = $showPublic;
    }
    
    public function setAnswerText($answerText) {
        $this->answerText = $answerText;
    }
    
    public function setAgentID($agentID) {
        $this->answeredByAgentID = $agentID;
    }
    
    public function getAgentID() {
        return $this->answeredByAgentID;
    }
    
    public function getCommendID() {
        return $this->commentID;
    }
    
    public function getPropertyID() {
        return $this->propertyID;
    }
    
    public function getCommentText() {
        return $this->commentText;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function getUserID() {
        return $this->createdByUserID;
    }
    
    public function getShowPublic() {
        return $this->showPublic;
    }
    
    public function getAnswerText() {
        return $this->answerText;
    }
}
?>
