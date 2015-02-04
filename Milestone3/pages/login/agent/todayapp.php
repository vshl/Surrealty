

<?php
    session_start();
    $servername = "localhost";
    $username = "f14g11";
    $pass = "Group11";
    $dbname = "student_f14g11";
    $user = $_SESSION['user_id'];
   
    
   
// Create connection
$conn = new mysqli($servername, $username, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$query="select id, apointment_with, status, date, time from apointment where status = '0' and user_id = $user and date = ' ".date('Y-m-d')." ' order by date , time";
$result = $conn->query($query);

$arr1 = array();
if($result->num_rows > 0) {
 while($row = $result->fetch_assoc()) {
 $arr1[] = $row;
 }
}
 
# JSON-encode the response
echo $json_response = json_encode($arr1);
