<?php
   
    $servername = "localhost";
    $username = "f14g11";
    $pass = "Group11";
    $dbname = "student_f14g11";
    
    $data = file_get_contents("php://input");

    $objData = json_decode($data);
   

// Create connection
$conn = new mysqli($servername, $username, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
    
    
$query="update apointment set status='1' where id='$objData->appid'";
$result = $conn->query($query);
 
$result = $mysqli->affected_rows;
 
echo $json_response = json_encode($result);


?>

