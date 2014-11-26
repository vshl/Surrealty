<?php

class Logging {
    

public function logToFile($subSystem, $severity="Info", $detail) {
       $data = date("H:i:s") . " " . $subSystem . "-" . $detail. PHP_EOL;
       $file = "../logs/log".date("j.n.Y").".txt";
       file_put_contents($file, $data, FILE_APPEND);
   }
}

 ?>