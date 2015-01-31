<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<html>
    <head>
    <title> AUTHENTICATE </title>
    
    </head>
    <body>
        <!--This is where will authenticate the user and redirect him to the proper dashboard.-->
        <?php 
        
    $email = $_GET["email"] ;
    $password = $_GET["password"];
        
     
    $servername = "localhost";
    $username = "f14g11";
    $pass = "Group11";
    $dbname = "student_f14g11";

// Create connection
$conn = new mysqli($servername, $username, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
$result = $conn->query($sql);

if (($result->num_rows ) == 1) 
{
    $row = $result->fetch_assoc(); 
    
            $id   =  $row["user_id"] ;
            $name =  $row["fname"] . " " . $row["lname"];
            $role =  $row["role"];
            
            
            echo '<h3>Logged in successfully as ' . $role . '</h3>';
            if ($role == "ADMIN")
            {
                 echo '<p>Redirecting to dashboard...</p>';
                header('Refresh: 3; URL=./admin/adminDashboard.php');
                ?>
                
        
        <?php
            }
            if ($role == "AGENT")
            {
                echo '<p>Redirecting to dashboard...</p>';
                header('Refresh: 3; URL=./agent/agentDashboard.php');
                ?>
        <?php
                
            }
            if ($role == "BUYER")
            {
                echo '<p>Redirecting to dashboard...</p>';
                header('Refresh: 3; URL= ./buyer/buyerDashboard.php');
                ?>
        
        <?php        
            }
                        
                
} 
else 
{
    echo "<h2>Invalid Username and Password</h2>";
    echo "<p>Redirecting to home page...</p>";
    header('Refresh: 2; URL=./../home.php');
}
$conn->close();
?>

    </body>
</html>