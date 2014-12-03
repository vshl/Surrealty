
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
/**
 * We use $pathArray[2] to determine the username in www.sfsuswe.com/~USERNAME
 * This should solve the problems relating to the different paths / absolute paths
 * Hence is it important the we include the pathMaker.php
 * Before you modifie anything, please try to contact me
 * Florian Hahner, 27.Nov 2014
 */

session_start();
include ('../pathMaker.php');
?>
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">    
        <div class="container-fluid">
                <div class="navbar-header" style=" height: 60px;">
                    <a class="navbar-brand" href="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/pages/home.php"> <img src="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/images/Logo_surreal.png" class="image-responsive" style="max-height:65px; margin-top: -15px;">
                    </a>
                         <button type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse" data-target="#navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                        </button>
                </div>
        <!--right part of the navbar-->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    
                    <!--left part of the navbar-->           
                    <ul class="nav navbar-nav navbar-left" style="font-size: 1.2em">
                        <li><a href="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/pages/home.php">Home</a></li>
                        <li><a href="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/pages/search.php">Buy</a></li>
                        <li><a href="#myModal_sell" data-toggle="modal">Sell</a></li>
                        <li><a href="#">Agents</a></li>
                        <li><a href="#">Advice</a></li>
                        <li><a href="#ContactUs" data-toggle="modal">Contact Us</a></li>
                        <li><a href="#AboutUs" data-toggle="modal">About</a></li> 
                        <li><a href="#">Local</a></li>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right" style="font-size: 1.2em">
                        <?php 
                            if(isset($_SESSION['fname'])) {
                                echo "<li><a href=\"login/".strtolower($_SESSION['role'])."/".strtolower($_SESSION['role'])."Dashboard.php\" ><span class=\"glyphicon glyphicon-user\"></span>&nbsp;Hello&nbsp;".$_SESSION['fname']."</a></li>";
                                echo "<li><a href=\"http://www.sfsuswe.com/~". $pathArray[2] ."/pages/login/logout.php\"><span class=\"glyphicon glyphicon-log-out\"></span>&nbsp;Logout</a></li>";
                            } 
                            else {
                               echo "<li><a href=\"#myModal_SU\" data-toggle=\"modal\"><span class=\"glyphicon glyphicon-edit\"></span>&nbsp;Register</a></li>";
                               echo "<li><a href=\"#myModal_SI\" data-toggle=\"modal\"><span class=\"glyphicon glyphicon-log-in\"></span>&nbsp;Login</a></li> ";
                            }   
                        ?>
                      </ul>
         
                </div>
        </div>
    </nav>


<br><br><br><br><!--this space allow dislaying the complet navtabs of dashboards- thats a temporary solution-->
           