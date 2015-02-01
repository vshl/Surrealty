<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if( isset($_GET['search'])) {
    
    define ("PROPERTY_DIR", "../images/property_images");
    define ("IMAGE_DIR", "../images");

    require_once './../APIs/geocoder.php';
    require_once './../controllers/PropertyController.php';
    require_once './../controllers/ImageController.php';
    
    $address = filter_input(INPUT_GET, 'search');
    if ($address == NULL )
    {
        $address = "San Francisco";    
    }   
    
    $order = filter_input(INPUT_POST, "order");
    $sortField = 'property_id';
    $sortOrder = 'ASC';
    
    if ($order)
    {
        $sort = explode(' ', $order);
        $sortField = $sort[0];
        $sortOrder = $sort[1];
    }
    
    list($properties, $total_properties) = PropertyController::searchProperty
        ($address, $sortField, $sortOrder, 0, 100);
    
    $pc = new PropertyController();
    $ic = new ImageController();
    
    
    for($i = 0; $i < count($properties); $i++) { 
        $url = "http://sfsuswe.com/~bbleic/pages/";
        $hash = $pc->giveImageHashesByPropertyID($properties[$i]['property_id']);
        
        if($hash != 0 ) {
            $image = $url.$ic->displayPicture("LARGE", $hash);
        } else {
            $image = PROPERTY_DIR .'/'. $properties[$i]['property_id'] .'.jpg';

            if( !file_exists($image) ) {
                $image = "-1";
            } else {
                $image = $url.$image;
            }
        }
        $properties[$i]['image'] = $image;
    }
    echo json_encode(array("result"=>$properties));
} 
?>