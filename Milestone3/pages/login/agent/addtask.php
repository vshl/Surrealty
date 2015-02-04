<?php
    session_start();
    $servername = "localhost";
    $username = "f14g11";
    $pass = "Group11";
    $dbname = "student_f14g11";
    
    $data = file_get_contents("php://input");

    $objData = json_decode($data);
    $date = $objData->date;
//    $timestamp = strtotime($date);
//    $date2 = date("Y-m-d", $timestamp);
   
//   $data = json_decode(file_get_contents("php://input"));
//   $appointment = mysql_real_escape_string($data->appointment);
//   $date = mysql_real_escape_string($data->date);
  
// Create connection
$conn = new mysqli($servername, $username, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
    //$appointment = $_GET['appointment'];
    //$date = "2015-01-01";
    $status = "0";
    $user = $_SESSION['user_id'];
    //    $user = "50001";
    
$query="INSERT INTO apointment(apointment_with,status,date,time,user_id) VALUES ('$objData->appointment', '$status', '$date','$objData->time', '$user')";
$result = $conn->query($query);
 
$result = $mysqli->affected_rows;
 
echo $json_response = json_encode($result);


?>

