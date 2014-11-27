<?php
include ('../pathMaker.php');
require_once($path . '/classes/Logging.php');
/*
 * This file will be included on every page. It checks the current session on user role and redirect to special site
 */

session_start();


/**
 * This function check if session[role] is sufficent for this site, if not redirect to given page
 * 
 * @param string $roleArray An array with all allowed user rules
 * @param string $newSite URL for redirection if user role is not sufficent
 */

function checkUserRoleAndRedirect($roleArray, $newSite) {
    $logMan = new Logging();
    if ( isset($_SESSION['role'])) {
        $currentUserRole = $_SESSION['role'];
        $logMan->logToFile('checkUser', 'Info', 'Try Session ' . $currentUserRole . " with necccesary " . $roleArray[0]);
        if (!in_array($currentUserRole, $roleArray)) {
            header('Location:' . $newSite);
        }
    }
    else {
        header('Location:' . $newSite);
    }
        
        
}
