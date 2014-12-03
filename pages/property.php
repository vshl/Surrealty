<?php
// This section checks if logged in user has sufficent rights and redirect him
// to home.php if not. 
// pathMaker.php is necessary to calculate the prefix for the absolut path
// F.Hahner 27.11.2014
include ('../pathMaker.php');
require_once($path.'/include/checkUser.php');
//checkUserRoleAndRedirect(array('BUYER', 'AGENT', 'ADMIN'), "../home.php");
?>

<?php
    $property_id = htmlspecialchars($_GET["PropertyId"]);
    $search = htmlspecialchars($_GET["Search"]);
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

$sql = "SELECT * FROM property WHERE property_id = '$property_id'";
$result = $conn->query($sql);

if (($result->num_rows ) == 1) 
{
    $row = $result->fetch_assoc();
    $address = "";
    
    if($row["address2"] != NULL)
    {
                $address =  $row["address2"] . ", " . $row["address1"] ; 
    }
    else
    {
         $address =  $row["address1"] ; 
    }
            $address =  $address .", ".$row["zipcode"].", ".$row["city"].", ".$row["state"]   ; 
            $price = $row["price"];
            $beds = $row["beds"];
            $baths = $row["baths"];
            $area = $row["area"];
}

?>
<html>
    <head>
    <title> Detailed Listing</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="../javascripts/jquery-2.1.1.js"></script>
    <script src="../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../frameworks/bootstrap/dist/js/npm.js"></script>
    <script src="../javascripts/ajax.js"></script>
    <!--  Importing property.css --> 
    <link href ="./../css/property.css" rel="stylesheet">
    <script>
        $( document ).ready(function() {
            loadAllCommentsByProperty(<?php echo $property_id; ?>);
        });
    </script>
    
    </head>
    <body>
        <div class="container-fluid"  ><!-- main container -->
        <!--header--> 
        <?php include "./../include/header.php"?>
        <div style="margin-top: 6% ; margin-bottom: 0%;">
        <div class="row ">
        <div class="col-md-6 col-md-offset-3">
            <form role="form" action="search.php" class="form-inline" method="GET">
                <div class="input-group input-group-lg">
                <input size="60" type="text" class="form-control input-group-lg" placeholder="<?php echo $search;?>" autofocus name="search">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="submit"><strong>Search</strong></button>
                </span>
                </div>
            </form>
        </div>
        </div>
        </div>
            <div class="row" >
                <div class="col-sm-12 col-md-6" id="pictures" style="margin-top: 1%; margin-left: 5px ;margin-right: 10px;  ">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                          <li data-target="#myCarousel" data-slide-to="3"></li>
                          <li data-target="#myCarousel" data-slide-to="4"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="../images/property_images/<?php echo $property_id;?>.jpg" class="image" alt="...">
                                <div class="carousel-caption">
                                </div>
                            </div>
                            <div class="item">
                                <img src="../images/house_2.JPG" class="image"  alt="...">
                                <div class="carousel-caption"></div>
                            </div>

                            <div class="item" >
                                <img src="../images/house_3.JPG" class="image" alt="...">
                                <div class="carousel-caption"></div>
                            </div>

                            <div class="item" >
                                <img src="../images/house_4.JPG" class="image" alt="...">
                                <div class="carousel-caption"></div>
                            </div>

                            <div class="item" >
                                <img src="../images/house_1.JPG" class="image" alt="...">
                                <div class="carousel-caption"></div>
                            </div>
                        </div>
                          <!-- Controls -->
                          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                          </a>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4" id="contact" style="margin-top: 1%;">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3>Contact an Agent</h3> 
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
                                <button type="submit" class="btn btn-defualt">Submit</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-md-8" id="description" style="margin-bottom: 1%;">
                    <h1 id="address">
                        <?php echo $address;?>
                    </h1>
                    <p id="description">
                        Available NOW - Clean, bright and airy Studio Apartment with large windows near Union Square. This apartment was just freshly painted and has carpet throughout. This charming apartment comes with a large walk-in closet to provide ample storage space. The kitchen is equipped with a newer fridge, gas stove, and plenty of cabinet and counter space for all your cooking needs.This 7th floor unit is located in a well-maintained Victorian building with an elevator. The building is clean, quiet and secured. There is a community laundry room in the basement of our neighboring sister property next door for your use. We pay for your heat, water, sewer and trash pickup.
                    </p>
                    <p id="openHouse">
                        <b>Open House</b> 
                        <ul>
                            <li>11/28 2pm-4pm</li>
                            <li>11/29 4pm-5pm</li> 
                        </ul>
                    </p>
                </div>
                <div class="col-sm-4 col-md-4" id="details">
                    <h1>For Sale</h1>
                    <h2 style="font-size: 20; color: #2aabd2 ">
                        <strong>
                        <?php echo "$ " . number_format($price).".00";?>
                            </strong>
                    </h2>
                    <p >
                        <?php echo $beds;?> Bedrooms  <?php echo $baths;?> Bath <br> 
                        Lot: <?php echo $area;?> sqft <br>
                        Single Family <br> 
                        Built in 1938 <br> 
                        5 Days on Surreality <br> 
                    </p>
                </div>
            </div>
        <!--- the following code is from florian. its a proof of concept for working comment section -->
        <div class="row" style="margin-bottom: 5%;">
            <div class="col-sm-4 col-md-4" id="new_comment_container">
            <?php
                if (!isset($_SESSION['role'])) {
                    echo "<h4> please Login or register to use the comment function. Thank you</h4>";
                }
                ?>
            </div>
            
            
            <div class="col-sm-8 col-md-8" id="prop_comment_container">
            </div>
            
        </div>
            
        
        <!-- footer -->
        <?php include "./../include/footer.html"?>
        
       
        
        
        
     <!-- Modal sign_up HTML -->
    <div id="myModal_SU" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-edit"></span>&nbsp;Sign Up</h4>
                    </div>
                <form action="./register.php" methode="POST">
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


      
           
 <!-- Modal Sign_in HTML -->
    <div id="myModal_SI" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</h4>
                </div>
                <form action="./login/authenticate.php" methode="POST">
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
                            <p class="text-warning">
                                <a href="#myModal_RP" data-toggle="modal" class="pull-left">
                                    <h6><i class="glyphicon glyphicon-question-sign"></i>&nbsp;Forgot Password</h6>
                                </a>
                           </p>
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./../javascripts/script.js"></script> 
     
      </div>
     
    </body>
</html>