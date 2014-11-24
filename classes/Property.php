<?php

/**
 * Property class
 * This class houses the attributes of Properties
 * @author vishal
 */
class Property {
    
    private $title;
    private $address1;
    private $address2;
    private $zipcode;
    private $neighborhood;
    private $city;
    private $state;
    private $country;
    private $lng;
    private $lat;
    
    
    public function __construct( $title,$address1,$address2,$zipcode,
            $neighborhood,$city,$state,$country,$lng,$lat,$description,
            $beds,$baths,$pool,$balcony,$area,$status,$created_by,
            $modification_date,$approved,$agent_id) {
        
        $this->title        =   $title;
        $this->address1     =   $address1;
        $this->address2     =   $address2;
        $this->zipcode      =   $zipcode;
        $this->neighborhood =   $neighborhood;
        $this->city         =   $city;
        $this->state        =   $state;
        $this->country      =   $country;
        $this->lng          =   $lng;
        $this->lat          =   $lat;
        $this->description  =   $description;
        $this->beds         =   $beds;
        $this->baths        =   $baths;
        $this->pool         =   $pool;
        $this->balcony      =   $balcony;
        $this->area         =   $area;
        $this->status       =   $status;
        $this->created_by   =   $created_by;
        $this->modification_date = $modification_date;
        $this->approved     =   $approved;
        $this->agent_id     =   $agent_id;
    }
    
    public function __destruct() {
        
    }
    
    public function getTitle() {
        return $this->title;
    } 
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getAddress1() {
        return $this->address1;
    }
    
    public function setAddress1($address1) {
        $this->address1 = $address1;
    }
    
    public function getAddress2() {
        return $this->address2;
    }
    
    public function setAddress2($address2) {
        $this->address2 = $address2;
    }
    
    public function getZipcode() {
        return $this->zipcode;
    }
    
    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }
    
    public function getNeigborhood() {
        return $this->neighborhood;
    }
    
    public function setNeighborhood($neighborhood) {
        $this->neighborhood = $neighborhood;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setCity($city) {
        $this->city = $city;
    }
    
    public function getState() {
        return $this->state;
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
    
    public function getCoords() {
        return $this->lat . "," . $this->lng;
    }
    
    public function setCoords($lat, $lng) {
        $this->lat = $lat;
        $this->lng = $lng;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getBeds() {
        return $this->beds;
    }
    
    public function setBeds($beds) {
        $this->beds = $beds;
    }
    
    public function getBaths() {
        return $this->baths;
    }
    
    public function setBaths($baths) {
        $this->baths = $baths;
    }
    
    public function getPool() {
        return $this->pool;
    }
    
    public function setPool($pool) {
        $this->pool = $pool;
    }
    
    public function getBalcony() {
        return $this->balcony;
    }
    
    public function setBalcony($balcony) {
        $this->balcony = $balcony;
    }
    
    public function getArea() {
        return $this->area;
    }
    
    public function setArea($area) {
        $this->area = $area;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus($status) {
        $this->area = $status;
    }
    
    public function getCreatedBy() {
        return $this->created_by;
    }
    
    public function setCreatedBy($created_by) {
        $this->created_by = $created_by;
    }
    
    public function getApproved() {
        return $this->approved;
    }
    
    public function setApproved($approved) {
        $this->approved = $approved;
    }
    
    public function getAgentId() {
        return $this->agent_id;
    }
    
    public function setAgentId($agent_id) {
        $this->agent_id = $agent_id;
    }
}
