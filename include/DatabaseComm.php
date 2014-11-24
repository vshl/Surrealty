<?php
/**
 * Database Communicator Class
 * 
 * This will establish a connection when its instantiate 
 * and disconnect from database when object is destroyed
 * 
 * @author Benjamin Bleicher <benjamin.bleichert@informatik.hs-fulda.de>
 * @author Florian Hahner <florian.hahner@informatik.hs-fulda.de>
 * @version 1.0
 */
class DatabaseComm {
    
    private $username = "f14g11";
    private $password = "Group11";
    private $dbName = "student_f14g11";
    private $dbHost = "localhost";
    private $dbConn;
  
    
    /**
     * Constructor for DatabaseComm
     * No special parameters required
     * Please unset() Object after usage
     */
    public function __construct() {
        $this->dbConn = new mysqli( $this->dbHost, $this->username, $this->password, $this->dbName );
        
        if ($this->dbConn->connect_error) {
            die("Connection failed: " . $this->dbConn->connect_error);
        }
    }
    
    public function __destruct() {
        $this->dbConn->close();
    }
    
    /**
     * Function for exucuting queries on the connected database
     * @param strig $query this is query as string
     * @return mysqli_result object is query was successful or FALSE on failure
     */
    
    public function executeQuery( $query ) {
        return $this->dbConn->query( $query ); 
        //error_log($this->dbConn->error, 3, "c:\xampp\sql_error.log");
    }
    
    public function affectedRows()
    {
        return $this->dbConn->affected_rows;
    }
    /**
     * 
     * @return string Last MySQL Error
     */
    public function giveError(){
        return $this->dbConn->error;
    }
    
    
        
}
?>