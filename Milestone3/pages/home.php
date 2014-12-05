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
  
              <form action="home.php" id="resetpwd" method="post">
                      <div class="input-group" title="Email">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="email" id="email_resetpwd" type="text" placeholder="type your e-mail"  class="form-control">
                      </div>
  
            
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="resetpwd" class="btn btn-primary">Submit</button>
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
                            <form role="form" id="sellAgentForm">
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
                                <button type="button" id="btn_sell_property" onclick="sellProperty()" Cclass="btn btn-primary pull-right">Submit</button>
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
                <form id="registrationForm">
                    <div class="modal-body">
                        <p>Sign up to surrealty and enjoy membership features</p>
                        <p classe="text-warning" id="login_incorrect"></p>
                       
                        <div class="input-group" title="firstname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i><sup>*</sup></span>
                            <input class="form-control" name="firstname" id="fname" type="text" placeholder="type your first name" maxlength="50" required>
                              </div>

                        <div class="input-group" title="lastname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i><sup>*</sup></span>
                            <input class="form-control" name="lastname" id="lname" type="text" placeholder="type your last name" maxlength="50" required>
                          </div>

                          <div class="input-group" title="email">
                            <span class="input-group-addon">@<sup>*</sup></span>
                            <input class="form-control" name="email1" id="email1" type="email" placeholder="type your e-mail" maxlength="50" required>
                          </div>

                          <div class="input-group" title="Password">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i><sup>*</sup></span>
                            <input class="form-control" name="password" id="password1" type="password" placeholder="type your password" maxlength="32" required>
                          </div>

                          <div class="input-group" title="phone">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i>&nbsp;</span>
                            <input class="form-control" name="phone" id="phone" type="tel" placeholder="type your phone number" maxlength="50" pattern="\d*">
                          </div>

                          <div class="input-group" title="image">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i>&nbsp;</span>
                            <span class="btn btn-default btn-file"><input type="file" data-filename-placement="inside" id="image_name" title="Search for a file to add" maxlength="50"></span>
                          </div>

                          <div class="input-group" title="addr1">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i><sup>*</sup></span>
                            <input class="form-control" id="address1" type="text" placeholder="type your first adresse" maxlength="100" required>
                          </div>

                          <div class="input-group" title="addr2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i>&nbsp;</span>
                            <input class="form-control" id="address2" type="text" placeholder="type your seconde adresse" maxlength="100">
                          </div>

                          <div class="input-group" title="zip">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i><sup>*</sup></span>
                            <input class="form-control" id="zipcode" type="text" placeholder="type your zip code" maxlength="10" pattern="\d*" required>
                          </div>

                          <div class="input-group" title="city">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i><sup>*</sup></span>
                              <input class="form-control" id="city" type="text" placeholder="type your city name" maxlength="50" required>
                          </div>

                          <div class="input-group" title="state">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i><sup>*</sup></span>
                            <input class="form-control" id="state" type="text" placeholder="type your state name" maxlength="50" required>
                          </div>
                          
                          <div class="input-group" title="country">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i><sup>*</sup></span>
                            <input class="form-control" id="country" type="text" placeholder="type your country name" maxlength="50" required>
                          </div>
                        <p class="text-warning"><small><input type="checkbox" checked="checked" disabled="disabled"/>
                          &nbsp;&nbsp;&nbsp;I Aggree With <a href="terme.pdf">Terms &amp; Conditions</a></small></p>
                          <p class="text-warning"><small>Please fill in all fields marked with <sup>*</sup></small></p>
                    </div> 
                        

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="signup">Sign up</button></form>
                </div>
                    </form>
            </div>
        </div>
    </div>
        
    <!--Modal for About us-->
 <div id="AboutUs" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;About us</h4>
                </div>
                <div class="modal-body">
                    <img src="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/images/fh-fulda.png" width="70" height="70" class="pull-left">
                    <img src="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/images/sfsu.png" width="70" height="70" class="pull-right">
                    <div class="text-center"> 
                        <h1>Software Engineering Class SFSU & FULDA Fall 2014 - Team 11</h1>
                    
                        <p> <h6>Surrealty is be a new online real-estate application for customers in search of real-estate properties on the Internet. The application's user experience gives the buyers a platform to perform a high level of interaction with the real-estate agents to find the right property based on their preferences.   

With the help of an easy to use and intuitive search function, the application provides results that match listings based on the search operation they perform. The application also provides methods to filter their search results with controls that dictate criteria like location, zip code, type of property and neighborhood amenities.

Additionally, customers can register their accounts with the application. Creating an account with the system provides additional features to the customers such as a dashboard that encompasses profile settings, managing bookmarks of the listings, and messaging system. The messaging system allows customers to posts questions to the real-estate agents to inquire further information about a property.
                        </h6> </p>
                        <small><a href="#Team" data-toggle="modal">Performed by</a></small>
                    
                    </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for about us-->


<!--Modal for Team-->
 <div id="Team" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-star"></span>&nbsp;Our Team</h4>
                </div>
                <div class="modal-body">
                <table class="table table-striped">
                    
                    <thead>
                        <tr>
                            <th data-field="First Name">First Name</th>
                            <th data-field="Last Name">Last Name</th>
                            <th data-field="University">University</th>
                            <th data-field="Email">Email</th>	
                                                
                        </tr>    
                    </thead>
                    <tbody style="font-size: 12px;">
                         <tr>
                            <td>Florian</td>  
                            <td>Hahner</td>
                            <td>FULDA</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:fhahne@sfsuswe.com'>&nbsp;fhahne@sfsuswe.com</a></td>  
                         </tr>
                         <tr>
                            <td>Benjamint</td>  
                            <td>Bleicher</td>
                            <td>FULDA</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:bbleic@sfsuswe.com'>&nbsp;bbleic@sfsuswe.com</a></td>  
                         </tr>
                         <tr>
                            <td>Ahmed</td>  
                            <td>Landolsi</td>
                            <td>FULDA</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:landosiamed@sfsuswe.com'>&nbsp;landosiamed@sfsuswe.com</a></td>  
                         </tr>
                         <tr>
                            <td>Abhijit</td>  
                            <td>Parate</td>
                            <td>SFSU</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:aparat@sfsuswe.com'>&nbsp;aparat@sfsuswe.com</a></td>  
                         </tr>
                         <tr>
                            <td>Vishal</td>  
                            <td>Ravi Shankar</td>
                            <td>SFSU</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:vshank@sfsuswe.com'>&nbsp;vshank@sfsuswe.com</a></td>  
                         </tr>
                         <tr>
                            <td>Johnnie</td>  
                            <td>Lo</td>
                            <td>SFSU</td>  
                            <td><span class='glyphicon glyphicon-envelope'></span><a href='mailto:jlo@sfsuswe.com'>&nbsp;jlo@sfsuswe.com</a></td>  
                         </tr>
                    </tbody>
                </table>    
                    
                    
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for Team-->



<!--Modal for Contact us-->
 <div id="ContactUs" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                    <div class="navbar navbar-inverse"><h4 class="modal-title text-center">
                            <img src="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/images/Logo_surreal.png" width="170" height="70"></h4>
                    </div>
                </div>
                
                <div class="modal-body">
                    <div class="text-center"> 
                        <div class="row">
                            <div class="col-lg-5">
                                <br>
                                <h4 class="text-left"><span class="glyphicon glyphicon-tower"></span>&nbsp;Surrealty Real estate Agency</h4>
                                <br>
                                <h6 class="text-left"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;Adresse:88 Kearny Street, Suite 600 94108 San Francisco</h6>
                                
                                <h6 class="text-left"><span class="glyphicon glyphicon-earphone"></span>&nbsp;Tel:16112014</h6>
                                <h6 class="text-left"><span class="glyphicon glyphicon-envelope"></span>&nbsp;Mail:surrealty@sfsuswe.com</h6>
                                <h6 class="text-left"><span class="glyphicon glyphicon-home"></span>&nbsp;Managed properties:250</h6>
                                <h6 class="text-left"><span class="glyphicon glyphicon-user"></span>&nbsp;Employed agent:10</h6>
                            </div>
                            <div class="col-lg-7">
                                 <img src="http://www.sfsuswe.com/~<?php echo $pathArray[2] ?>/images/map.jpg" width="450" height="250">
                            </div>    
                        </div>
                            
                    </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for contact us--> 
        

	<!-- footer -->
        <?php include "./../include/footer.html"?>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./../javascripts/jquery-2.1.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./../javascripts/jquery.validate.js"</script>
    <script src="./../javascripts/script.js"></script> 
    <script src="./../javascripts/ajax.js"></script>
    <script src="./../javascripts/jquery.toaster.js"></script>
    <script type="text/javascript">
        $( "#login_submit_btn").click(loginAndRedirect);
    </script>
    <script type="text/javascript">
        $( "#signup").click(RegisterAndRedirect);
    </script>
    </div><!-- main container -->
 
 <?php
    if(isset($_GET['code']) && isset($_GET['email'])) {
       $code = stripslashes($_GET['code']);
       $email = stripcslashes($_GET['email']);

       include "./../controllers/AuthenticationController.php";

       $ac      = new AuthenticationController();
       $newpw   = $ac->resetPassword($email, $code);
   
       if($newpw !== 0) {
           print "<script type=\"text/javascript\">" .
                   " $.toaster({settings : { 'timeout' : 120000 } }); " .
                   " $.toaster({ priority : 'success', title : 'Password reset', message : 'Password is successfully reset. Your new password is: ".$newpw."' });" .
                   " $.toaster.reset();" .
                "</script>'";
       } else {
            print "<script type=\"text/javascript\">" .
                   " $.toaster({settings : { 'timeout' : 120000 } }); " .
                   " $.toaster({ priority : 'warning', title : 'Password reset', message : 'Password reset process failed. You have just 10 minutes time to checkout your emails and follow the instructions!' });" .
                   " $.toaster.reset();" .
                "</script>'";
       }
    } else if(isset($_POST['email'])) {
        $email = stripcslashes($_POST['email']);
        print "<script type=\"text/javascript\">" .
               " $.toaster({settings : { 'timeout' : 20000 } }); " .
               "$.toaster({ priority : 'success', title : 'Email sent', message : 'We sent you an email with instructions for the password reset process. Your email: ".$email."' });" .
                " $.toaster.reset();" .
                "</script>'";
    }
?>

   
</body>

</html>