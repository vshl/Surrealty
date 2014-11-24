<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<html>
    <head>
    <title> LOGOUT </title>
    
    </head>
    <body>
        <h1>Logged out successfully. </h1>
        
       <p></p>
        <p>Redirecting to home page...</p>
        <?php 
        
       
        header("Refresh: 3; URL=./../home.php")
        
        ?>
                  
    </body>
</html>
