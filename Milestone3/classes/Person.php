<?php

/*
 *
 * mehrere constructs zum automatischen bef�llen ?
 * wenn ja wie viele.. : 
 
        $a = func_get_args(); 
        $n = func_num_args(); 
        if( method_exists( $this, $f='__construct'.$n ) )  
                    
 *
 * 
 *
 */

class Person {
    
    private $lastname;
    private $firstname;
    private $password;
    private $email;
    private $pictureName;
    private $phone;
    private $role;
    private $id;
    
    
    /**
     * Constructor for Person class
     * 
     * @param string $lastname Lastname of person
     * @param string $firstname Firstname of person
     * @param string $email eMail Address of person
     * @param string $password Password of person
     * @param string $pictureID Image ID of person
     * @param string $phone Phone Number as String of Person
     */
    
    public function __construct() {
        $args = func_get_args() ;
        
        //direct call
        if( func_num_args() == 7  ) {
            call_user_func_array( array( $this, '__construct2' ), $args );
        }
        //call from a child
       elseif( count($args[0]) ==  7  ) {
            call_user_func_array( array( $this, '__construct2' ), $args[0] );
        }
        
    }
    
    public function __construct2( $lastname, $firstname, $email, $password, $phone, $pictureName, $role ) {
        $this->lastname     = $lastname;
        $this->firstname    = $firstname;
        $this->email        = $email;
        $this->password     = $password;
        $this->phone        = $phone;
        $this->pictureName  = $pictureName;
        $this->role         = $role;
    }
    
    public function __destruct() {
        
    }
    
    public function setLastname( $lastname ) {
        $this->lastname = $lastname;
    }
    
    public function setFirstname( $firstname ) {
        $this->firstname = $firstname;
    }
    
    public function setPassword( $password ) {
        $this->password = $password;
    }
    
    public function setEmail( $email ) {
        $this->email = $email;
    }
    
    public function setID( $id ) {
        $this->id = $id;
    }
    
    public function setPhone( $phone ) {
        $this->phone = $phone;
    }
        
    public function setPictureName( $pictureName ){
        $this->pictureName = $pictureName;
    }
    
    public function setRole( $role ) {
        $this->role = $role;
    }
    
    public function getLastname() {
        return $this->lastname;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getID() {
        return $this->id;
    }
    
    public function getPhone() {
        return $this->phone;
    }
    
    public function getPictureName(){
        return $this->pictureName;
    }
    
    public function getRole() {
        return $this->role;
    }

}


?>