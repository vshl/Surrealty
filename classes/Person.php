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
define ("BUYER_ROLE_ID", "BUYER");
define ("AGENT_ROLE_ID", "AGENT");
define ("ADMIN_ROLE_ID", "ADMIN");


class Person {
    
    private $lastname;
    private $firstname;
    private $password;
    private $email;
    private $pictureName;
    private $phone;
    private $role;
    private $id;
    private $address1;
    private $address2;
    private $city;
    private $zipcode;
    private $state;
    private $country;
    
    
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
        if( func_num_args() == 13  ) {
            call_user_func_array( array( $this, '__construct2' ), $args );
        }
        //call from a child
       elseif( count($args[0]) ==  13  ) {
            call_user_func_array( array( $this, '__construct2' ), $args[0] );
        }
        
    }
    
    /**
     * 
     * @param type $lastname
     * @param type $firstname
     * @param type $email
     * @param type $password
     * @param type $phone
     * @param type $pictureName
     * @param type $role
     * @param type $address1
     * @param type $address2
     * @param type $zipcode
     * @param type $city
     * @param type $state
     * @param type $country
     */
    
    public function __construct2( $lastname, $firstname, $email, $password, $phone, $pictureName, $role, $address1, $address2, $zipcode, $city, $state, $country ) {
        $this->lastname     = $lastname;
        $this->firstname    = $firstname;
        $this->email        = $email;
        $this->password     = $password;
        $this->phone        = $phone;
        $this->pictureName  = $pictureName;
        $this->role         = $role;
        $this->address1     = $address1;
        $this->address2     = $address2;
        $this->city         = $city;
        $this->zipcode      = $zipcode;
        $this->state        = $state;
        $this->country      = $country;
                
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
    
    public function getAddress1() {
        return $this->address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getState() {
        return $this->state;
    }

    public function setAddress1($address1) {
        $this->address1 = $address1;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setState($state) {
        $this->state = $state;
    }
    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }




}


?>