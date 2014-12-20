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

<body>
        <!--header--> 
        <?php session_start(); include "./../include/header.php" ?>
        <!-- Jumbotron and Search Bar --> 
        <div class="header jumbotron">
            <div class="container">
                <!--search-->
                <div style="margin-top: 7% ; margin-bottom: 15%;  ">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="container-fluid" style=" padding: 10px; border: 5px solid gray; margin: 0; background-color: black; border-radius: 10px;">
                                <h4 style="color:white"> <b>Find your home with Surrealty...</b></h4>
                                <form role="form" action="search.php" class="form-inline" method="GET">
                                    <div class="input-group input-group-lg">
                                        <input size="60" type="text" class="form-control input-group-lg" placeholder="Search City, Zipcode, Area..." autofocus name="search">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="submit"><strong>Search</strong></button>
                                        </span>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
        <div class="row body-content">
            <!-- Thumbnail for recently sold houses --> 
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="thumbnail text-center">
                    <div class="caption">
                        <h3>Recently sold houses</h3>                       
                    </div>
                    <img src="../images/house1.jpg" class="img-circle">
                    <div class="caption text-center">
                        <p><b>8</b> Houses sold in San Francisco</p> 
                    </div>
                </div>
            </div>
            <!-- Thumbnail for Top Agents --> 
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Our top agent of the week!</h3>                       
                    </div>
                    <img src="../images/house4.jpg" class="img-circle">
                    <div class="caption text-center">
                        <p>Mark has sold <b>4</b> houses this week!</p> 
                    </div>
                </div>
            </div>
            <!-- Thumbnail for houses sold this month --> 
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <h3>Houses sold on Surrealty</h3>                       
                    </div>
                    <img src="../images/house5.jpg" class="img-circle">
                    <div class="caption text-center">
                        <p><b>968</b> houses sold on Surrealty and Counting </p> 
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php include "./../include/Modal_header.html"?>
        <?php include "./../include/footer.html"?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="./../javascripts/jquery-2.1.1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="./../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="./../javascripts/jquery.validate.js"</script>
        <script src="./../javascripts/script.js"></script> 
        <script src="./../javascripts/ajax.js"></script>
        <script src="./../javascripts/jquery.toaster.js"></script>
        <script src="./../javascripts/upload.js"></script>
        <script type="text/javascript">
            $("#login_submit_btn").click(loginAndRedirect);
            $("#login_submit_btn").focus(); 
            $("#myModal_SI").keyup(function(e) { 
                if (e.keyCode == 13) {
                loginAndRedirect();
                }
            });
        </script>

        <script type="text/javascript">
            $( "#signup").click(RegisterAndRedirect);
            $("#signup").focus(); 
            $("#myModal_SU").keyup(function(e) { 
                if (e.keyCode == 13) {
                RegisterAndRedirect();
                }
            });
        </script>

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
        } else if(isset($_POST['email']) && isset($_SESSION['resetCode'])) {
            $email = stripcslashes($_POST['email']);
            print "<script type=\"text/javascript\">" .
                   " $.toaster({settings : { 'timeout' : 20000 } }); ";

            if( $_SESSION['resetCode'] == 1 ) {
                print  "$.toaster({ priority : 'success', title : 'Email sent', message : 'We sent you an email with instructions for the password reset process. Your email: ".$email."' });";
            } else {
                print  "$.toaster({ priority : 'warning', title : 'Email was not found', message : 'Your email address was not found in our database. Your email: ".$email."' });";        
            }


            print " $.toaster.reset();" .
                    "</script>'";
            unset($_SESSION['resentCode']);
        }
    ?>
    </body>
</html>