<?php

class Maps {

    /**
    * @param list $properties
    * @return void
    */
    private $properties;
    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    /**
    * @param none
    * @return xml
    */
    public function genXML()
    {
        ob_start();
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        header("Content-type: text/xml");

        // Iterate through the rows, adding XML nodes for each

        foreach ($this->properties as $property) {
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
        ob_end_clean();
        $dom->save('../others/maps.xml');

    }
}

?>