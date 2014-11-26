<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <nav class = "navbar navbar-inverse navbar-static-top navbar-fixed-top" role="navigation" style=" padding-bottom: 2px;">
        <div class="container-fluid">
            <div class="navbar-header" >
                <a class="navbar-brand" href="home.php"> <img src="./../images/logo.png" class="image-responsive" width="100" height="70"> </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar_home">
                <span class="sr-only">Toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            </div>
            <div class="collapse navbar-collapse" id="navabr_home">
            <div>
            </div>
            <div class="navbar-header" style=" height: 80px;">
                <ul class="nav navbar-nav" style ="font-size: 1.3em">
                    <li><a href="./home.php">Home</a></li>
                    <li><a href="./search.php">Buy</a></li>
                    <li><a href="#myModal_sell" data-toggle="modal">Sell</a></li>
                    <li><a href="#">Agents</a></li>
                    <li><a href="#">Advice</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">About</a></li> 
                    <li><a href="#">Local</a></li>
                </ul>
            </div>
            <div class="navbar-header navbar-right">
                <ul class="nav navbar-nav" style ="font-size: 1.3em">
                    <li><a href="#myModal_SU" data-toggle="modal">Register</a></li>
                    <?php
                    if (isset($_SESSION['fname'])) {
                        echo "Hello" . $_SESSION['fname'] . "<li><a href=\"#myModal_SI\" data-toggle=\"modal\"><span class=\"glyphicon glyphicon-log-in\"></span>Login</a></li>";
                    }
                    else {
                        echo "<li><a href=\"#myModal_SI\" data-toggle=\"modal\"><span class=\"glyphicon glyphicon-log-in\"></span>Login</a></li>";
                    }
                    ?>
                    
                </ul>
            </div>
            </div>
        </div>
    </nav>

</html>