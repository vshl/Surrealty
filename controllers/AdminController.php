<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include ('../pathMaker.php');

require_once $path.'/include/DatabaseComm.php';
require_once $path.'/classes/Admin.php';

class AdminController {
    

    public function __construct() {
        
    }
    
    public function __destruct() {
        
    }
    
    
    /**
     *  loadAdminByID
     * 
     * load an admin by his ID
     * @param type $adminID
     * 
     * @return requested Agent as object. If agent not found return 0
     */
    
    public function loadAdminByID( $adminID ) {
      $admin = new Admin();
      if ($admin->loadadminByID($adminID)){
          return $admin;
      }
      else{
          return 0;
      }
    }
    
    /**
     * enableAminById 
     * 
     * Set the enabled status of an admin specified by its id
     * 
     * @param type $adminID => The ID of the agent
     * @param type $enabled => enabled status 0=disabled, 1=enabled
     * @return int statuscode => 0=error, 1=success
     * 
     */
    
    public function enableAdminByID( $adminID, $enabled ) {
    {
        if ($enabled == 0 || $enabled == 1){
            $admin = new Admin();
            if ($admin->loadAdminByID($adminID)){
                $admin->setEnabled($enabled);
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
        
    }
     /**
      * deleteAdminByID
      * 
      * deletes an agent by its ID
      * 
      * @param type $adminID
      * 
      * @return int statuscode(inherit from parent function) 0=error, 1=success
      */
    
    public function deleteAdminByID( $adminID ) {
        
        if ( $adminID >= 0) {       // check if ID is integer GEt zero
           $admin = new Admin(); 
           return $admin->deleteAdminByID($adminID);
        }
        else { 
            return 0;
        }
    }
    
}