<?php
DEFINE ("LOG_ENABLE", TRUE);

class Logging {
    

public function logToFile($subSystem, $severity="Info", $detail) {
       include('../pathMaker.php');
       $data = date("H:i:s") . " " . $subSystem . "-" . $detail. PHP_EOL;
       $file = $path."/logs/log".date("j.n.Y").".txt";
       if (LOG_ENABLE) {
       file_put_contents($file, $data, FILE_APPEND);
       }
   }
}

 ?>