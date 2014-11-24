<?php
require('../controllers/PropertyController.php');
require('../APIs/geocoder.php');

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$searchQuery = filter_input(INPUT_GET, 'search');
$properties = PropertyController::searchProperty($searchQuery);

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

foreach ($properties as $property) {
  $address = implode(', ', PropertyController::getAddress($property['property_id']));
  $coords = geocoder::getLocation($address);
  $lat = $coords['lat'];
  $lng = $coords['lng'];
  $price = $property['price'];
  $property_id = $property['property_id'];

  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("property_id", $property_id);
  $newnode->setAttribute("address",$address);
  $newnode->setAttribute("lat", $lat);
  $newnode->setAttribute("lng", $lng);
  $newnode->setAttribute("price", $price);  
}

echo $dom->saveXML();

?>