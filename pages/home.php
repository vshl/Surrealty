 <!-- 
Filename : Home.php

Link :
index.php > home.php
----------------------------------------
Created by : Abhijit
Date : 11/10/2014
----------------------------------------
Updated by :
1> Abhijit @2.00 on 11/10/2014 > Added header 
2> Abhiijt @18:38 on 11/11 > added logo back
----------------------------------------
 -->
<?php

?>

<html>

<head>
	<meta charset = "utf-8">
	<meta name = "viewport" content = "width=device-width"  initial-scale="1.0">
	<title> Surrealty </title>
        <link href="./../frameworks/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
	<link href = "./../frameworks/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="./../frameworks/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
	<link href = "./../css/home.css" rel="stylesheet">

        
</head>

<body >
    <div class="container-fluid"  ><!-- main container -->
        <!--header--> 
        <?php include "./../include/header.php"?>
        <!--search-->
        <div style="margin-top: 7% ; margin-bottom: 15%;">
        <div class="row ">
        <div class="col-md-6 col-md-offset-3">
            <form role="form" action="search.php" class="form-inline" method="GET">
                <div class="input-group input-group-lg">
                <input size="60" type="text" class="form-control input-group-lg" placeholder="Search properties here..." autofocus name="search">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="submit"><strong>Search</strong></button>
                </span>
                </div>
            </form>
        </div>
        </div>
        </div>
        
        
        <div class="row" id="body-content" style="margin-bottom: 10%;">
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail" >
                
                <div class="caption">
                    
                  <h3>Recent Houses Sold</h3>
                  <p>8 House sold in San Francisco!</p>
                </div>
                  <img src="../images/home/house_home1.jpg">
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                
                <div class="caption">
                  <h3>Our top Agent of the week</h3>
                  <p>Mark has sold 4 houses this week!</p>
                </div>
                  <img src="./../images/home/house_home2.jpg">
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                
                <div class="caption">
                  <h3>Recent Houses Sold</h3>
                  <p>120 House sold this month!</p>
                </div>
                  <img src="../images/home/house_home3.jpg">
              </div>
            </div>
        </div>
        
        
           
 <!-- Modal Sign_in HTML -->
    <div id="myModal_SI" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</h4>
                </div>
                <form>
                    <div class="modal-body">
                        <p>Log in & track your saved homes and save preferences</p>
                          <div class="input-group" title="Email">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" name="email" id="email" type="text" placeholder="Enter your e-mail" >
                          </div>
                          <div class="input-group" title="Password">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control" name="password" id="password" type="password" placeholder="Enter your password">
                          </div>
                        <p classe="text-warning" id="login_incorrect"></p>
                            <p class="text-warning">
                                <a href="#myModal_RP" data-toggle="modal" class="pull-left">
                                    <h6><i class="glyphicon glyphicon-question-sign"></i>&nbsp;Forgot Password</h6>
                                </a>
                           </p>
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="login_submit_btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



     <!--Modal pass_recover -->

     <div class="modal fade" id="myModal_RP" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;Password Recovery</h4>
            </div>
            <div class="modal-body">
              <p class="center">Please enter your e-mail, you will recive a mail with your new password</p>
  
              <form action="PassRecover.php" methode="">
                      <div class="input-group" title="Email">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="email" id="email" type="text" placeholder="type your e-mail"  class="form-control">
                      </div>
  
            
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>      
            </div>
          </div>
        </div>
      </div>


     
     <!--sell-->
     
     <div class="modal fade" id="myModal_sell" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>Enter your contact information and our agent will contact you.</h3> 
                            </div>
                            <div class="modal-body">
                            <form role="form">
                                <div class="form-group">
                                    <label for="inputName">Name</label> 
                                    <input type="text" class="form-control" id="inputName" placeholder="Enter name">
                                </div> 
                                <div class="form-group">
                                    <label for="inputPhone">Phone</label> 
                                    <input type="text" class="form-control" id="inputPhone" placeholder="Enter phone number">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="inputMessage">Message</label> 
                                    <textarea class="form-control" id="inputMessage" placeholder="Enter message"></textarea>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </form> 
                            </div>        
                        </div>
                    </div>

     </div>



     <!-- Modal sign_up HTML -->
    <div id="myModal_SU" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-edit"></span>&nbsp;Sign Up</h4>
                    </div>
                <form action= "./register.php" methode="POST">
                    <div class="modal-body">
                        <p>Sign up to surrealty and enjoy membership features</p>
                        
                       
                        <div class="input-group" title="firstname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" name="firstname" id="" type="" placeholder="type your first name">
                          </div>

                          <div class="input-group" title="lastname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" name="lastname" id="" type="" placeholder="type your last name">
                          </div>

                          <div class="input-group" title="email">
                            <span class="input-group-addon">@</span>
                            <input class="form-control" name="email" id="" type="" placeholder="type your e-mail">
                          </div>

                          <div class="input-group" title="Password">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control" name="password" id="password" type="password" placeholder="type your password">
                          </div>

                          <div class="input-group" title="phone">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                            <input class="form-control" name="phone" id="" type="" placeholder="type your phone number">
                          </div>

                          <div class="input-group" title="image">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                            <span class="btn btn-default btn-file"><input type="file" data-filename-placement="inside" name="image" title="Search for a file to add"></span>
                          </div>

                          <div class="input-group" title="addr1">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input class="form-control" name="addr1" id="" type="" placeholder="type your first adresse">
                          </div>

                          <div class="input-group" title="addr2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input class="form-control" name="addr2" id="" type="" placeholder="type your seconde adresse">
                          </div>

                          <div class="input-group" title="zip">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                            <input class="form-control" name="zip" id="" type="" placeholder="type your zip code">
                          </div>

                          <div class="input-group" title="city">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                            <input class="form-control" name="city" id="" type="" placeholder="type your city name">
                          </div>

                          <div class="input-group" title="state">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                            <input class="form-control" name="state" id="" type="" placeholder="type your state name">
                          </div>

                          <p class="text-warning"><small><input type="checkbox" checked="checked" disabled="disabled"/>
                          &nbsp;&nbsp;&nbsp;I Aggree With <a href="terme.pdf">Terms &amp; Conditions</a></small></p>
                        
                    </div> 
                        

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign up</button></form>
                </div>
                    </form>
            </div>
        </div>
    </div>
        
        
        
        

	<!-- footer -->
        <?php include "./../include/footer.html"?>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./../javascripts/jquery-2.1.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./../javascripts/script.js"></script> 
    <script src="./../javascripts/ajax.js"></script>
    <script type="text/javascript">
        $( "#login_submit_btn").click(loginAndRedirect);
    </script>
    </div><!-- main container -->
 

   
</body>

</html>