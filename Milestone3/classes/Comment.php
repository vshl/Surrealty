<?php
/**
 * Model Class for comment objects
 * Class should be only used by appropiate controller classes
 * 
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 * 
 */

require_once '../classes/Logging.php';

class Comment {
    
    CONST FLAG_BUYER_NOT_READ_ANSWER    = 1;    // Buyer hasn't seen the answer yet
    CONST FLAG_BUYER_HIDE_COMMENT       = 2;    // Buyer hides this comment
    CONST FLAG_AGENT_REPLIED_COMMENT    = 4;    // Agent has replied this comment
    CONST FLAG_AGENT_HIDE_COMMENT       = 8;    // Agent hides this comment
    CONST FLAG_COMMENT_IS_PUBLIC        = 16;   // This comment is public
    
    private $commentID;
    private $propertyID;
    private $commentText;
    private $creationDate;
    private $createdByUserID;
    private $answeredByAgentID;
    private $answerText;
    private $answer_date;
    private $dbcomm;
    private $flags;                             // Saves the flags for this comment
    
    
    
    public function __construct() {
        $this->isPublic             = false;
        $this->isHidden             = false;
        $this->dbcomm               = new DatabaseComm();
        $this->answerText           = null;
        $this->answeredByAgentID    = null;
        $this->flags                = 0;
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
        $logger = new Logging();
        $sqlQuery = "SELECT * FROM comments WHERE comment_id = ".$commentID.";";
        //$logger->logToFile("Comment, loadCommentByID)", "info", "SQL Query: " . $sqlQuery);
        $result = $this->dbcomm->executeQuery($sqlQuery);
        if ($this->dbcomm->affectedRows() == 1) {
                $row = mysqli_fetch_assoc($result);
                // Copy data from database into comment object
                $this->commentID = $row['comment_id'];
                $this->propertyID = $row['property_id'];
                $this->commentText = $row['comment'];
                $this->creationDate = $row['creation_date'];
                $this->createdByUserID = $row['created_by'];
                $this->answeredByAgentID = $row['answered_by'];
                $this->answerText = $row['answer'];
                $this->answer_date  =$row['answer_date'];
                $this->flags = $row['flags'];
                $logger->logToFile("Comment, loadCommentByID", "info", "Loaded Comment: " . $this->getCommendID() . " with text " . $this->getCommentText() . " and flags: " . $this->flags);

                return 1;        
        }
        else {
            return 0;
        }
    }
    
    /**
     * creates a new comment in the database
     * uses private attributes
     * @return int Statuscode ( 1 > comment saved, 0 > error while saving ) 
     */
    public function saveNewComment() {
        $sqlQuery = "INSERT INTO comments (property_id, comment, creation_date, created_by, flags) VALUES ('" .
                $this->propertyID   . "', '" . 
                $this->commentText  . "', 
                             now() , '" . 
                $this->createdByUserID . "', '" . 
                //$this->answerText . "', '" .              // these two fields should be empty when comment is created
                //$this->answeredByAgentID . "', '" .
                $this->flags . "');";
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true) {
            return 0;
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at comment saving");
        }
        else {
            return 1;
        }
    }
  
    /**
     * This function should be used, if a comment or an answer has been modified. Not to use for answering
     * @return int
     */
    
    public function updateComment() {
        $logger = new Logging();
        $sqlQuery = "UPDATE comments SET " .
                    "property_id='" . $this->propertyID     . "', " . 
                    "comment='" . $this->commentText        . "', " . 
                    "creation_date='" . $this->creationDate . "', " .
                    "created_by='" . $this->createdByUserID . "', " .
                    "answer='" . $this->answerText          . "', ";
                    
                    if ($this->answeredByAgentID == "") {
                        $sqlQuery .= "answered_by = NULL, ";
                        }
                    else {
                        $sqlQuery .= "answered_by= '" . $this->answeredByAgentID . "', ";
                    }
                
        $sqlQuery .="flags= '" . $this->flags . "' " .
                    "WHERE comment_id = " . $this->commentID . ";";
        
        $logger->logToFile("Comment, updateComment", "info", "try to update with " .$sqlQuery);
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true) {
            return 0;
        }
        else {
            return 1;
        }   
    }
    /**
     * Use this function after you set the answer string within the class.
     * The function will only save the modifications belong the answer
     * @return int
     */
    
    public function saveAnswerToComment() {
        $logger = new Logging();
        
        $sqlQuery = "UPDATE comments SET " .
                    "answer='" . $this->answerText                  . "', " .
                    "answer_date = now(), "                         .
                    "answered_by = '" . $this->answeredByAgentID    . "', " .
                    "flags = '" . $this->flags                      . "' "  .
                    "WHERE comment_id = " . $this->commentID        . ";";
             
        $logger->logToFile("Comment, answerComment", "info", "try to update with " .$sqlQuery);
        $result = $this->dbcomm->executeQuery($sqlQuery);
        
        if ($result != true) {
            return 0;
        }
        else {
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
        
        if ($result != true) {
            echo $sqlQuery;
            echo "<br><b>" . $this->dbcomm->giveError() . "</b>";
            die("Error at delete comment");
        }
        else {
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
     
    public function getAnswerText() {
        return $this->answerText;
    }
    
    public function isBuyerNotReadAnswer(){
        return $this->isFlagSet(self::FLAG_BUYER_NOT_READ_ANSWER);
    }
    
    /**
     * Set the flag BUYER_NOT_READ_ANSWER
     * 
     * this flag shows if the buyer already read the answer from agent
     * 
     * @param boolean $value 
     */
    public function setBuyerNotReadAnswer($value) {
        $this->setFlag(self::FLAG_BUYER_NOT_READ_ANSWER, $value);
    }
    
    public function isCommentPublic() {
        return $this->isFlagSet(self::FLAG_COMMENT_IS_PUBLIC);
    }
    
    /**
     * This function marks the comment as public
     * 
     * @param boolean $value
     */
    
    public function setCommentPublic($value) {
        $this->setFlag(self::FLAG_COMMENT_IS_PUBLIC, $value);
    }
    
    public function isBuyerHideComment(){
        return $this->isFlagSet(self::FLAG_BUYER_HIDE_COMMENT);
    }
    
    /**
     * This function marks the comment as hidden for the buyer
     * 
     * @param type $value
     */
    
    public function setBuyerHideComment($value){
        $this->setFlag(self::FLAG_BUYER_HIDE_COMMENT, $value);
    }
    
    public function hasAgentRepliedComment(){
        return $this->isFlagSet(self::FLAG_AGENT_REPLIED_COMMENT);
    }
    
    /**
     * This function flag the command as replied from agent
     * 
     * @param type $value
     * 
     */
    
    public function setAgentRepliedComment($value){
        $this->setFlag(self::FLAG_AGENT_REPLIED_COMMENT, $value);
    }
    
    public function isAgentHideComment(){
        return $this->isFlagSet(self::FLAG_AGENT_HIDE_COMMENT);
    }
    
    /**
     * This function marks the comment as hidden for the agent
     * 
     * @param type $value
     */
            
    public function setAgentHideComment($value) {
        $this->setFlag(self::FLAG_AGENT_HIDE_COMMENT, $value);
    }
    
    
    
    private function isFlagSet($flag)
    {
      return (($this->flags & $flag) == $flag);
    }

    private function setFlag($flag, $value)
    {
      if($value) {
        $this->flags |= $flag;
      }
      else {
        $this->flags &= ~$flag;
      }
    }
}
?>
