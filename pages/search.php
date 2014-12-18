<?php
/**
* search.php
* This displays the search results from the property table
*
* @author Vishal Ravi Shankar <vshankar@mail.sfsu.edu>
 * 
 * 
 * 
 * updated 
 * 1> abhijit  modified UI
 * 2> abhijit modified geocoder
 * 3> abhijit modified lay out
 * 4> added new script
* 
*/

session_start();

define ("PROPERTY_DIR", "../images/property_images");

require_once './../APIs/geocoder.php';
require_once './../controllers/PropertyController.php';
require_once './../controllers/ImageController.php';
require_once './../APIs/maps.php';
$address = filter_input(INPUT_GET, 'search');

if ($address != NULL )
{
$coords = geocoder::getLocation($address);
$lat = $coords['lat'];
$lng = $coords['lng'];
}
else
{
$address = "San Francisco";    
$coords = geocoder::getLocation($address);
$lat = $coords['lat'];
$lng = $coords['lng'];
}   



?>

<html>

    
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" initial-scale="1.0">
      <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
      <!-- Latest compiled and minified bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      <!-- Custom CSS -->
      <link rel="stylesheet" href="../css/search.css" title='Custom css for search page'>
      <!-- Javascript -->
      <script type="text/javascript">
      // for dynamic loading of sort menu
        $(function() {
            $("#order").change(function() {
                this.form.submit();
            });
        });
      </script>
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCopAYcpV4Eo5BZ9q3PbeAI4nPBTct36HE"></script>
      <title> Search results for <?php echo " " . $address; ?> </title>
    </head>
    
    
    <body>
        
        <div class="container-fluid" >
        <!--header-->
        <?php include "./../include/header.php" ?>
        <!--main content-->
        <div class="container-fluid" style="padding: 60px 10px">
            <div class="row">
            <!--map-->
            <div class="col-lg-4 col-md-4 hidden-xs hidden-sm" style="padding: inherit">
                <div id="map" class="panel panel-body" style="border: 0px; border-radius: 0px;">
                    
                </div>
            </div>    
            <!--results-->
            
                <!--results header-->
                 <!--search box start-->
                <div class="col-lg-8 col-md-8 col-sm-12" style="  float: right; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;">
                <div class="panel panel-body " style=" margin: 0px; padding: 0px; text-align: left; height: 60px ; border: 0px; border-radius: 0px;">
                
                <form role="form" action="search.php" class="form-inline" method="GET" style=" margin-top: 1%">
                    <strong>Refine your search :</strong>
                    <div class="input-group input-group-lg no-margin no-padding">
                    
                <input size="60" type="text" class="form-control input-group-lg no-margin no-padding" value="<?php echo $address; ?>" autofocus name="search">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="submit"><strong>Search</strong></button>
                </span>
                </div>
                </form>
                    
                </div> 
                <!--search box end-->
                <!--filter panel start-->
                <div class="panel panel-body">   
                <?php echo "Results for " ; ?> <strong><?php echo $address; ?></strong>
                <div class="pull-right">
                <form name="order" method="post">
                  <select id="order", name="order">
                      <option value='property_id ASC'>Sort: Relevance</option>
                      <option value='price ASC'
                        <?=filter_input(INPUT_POST, "order") == 'price ASC' ? ' selected="selected"' : ''?>>
                        Sort: Price low to high
                      </option>
                      <option value='price DESC'
                        <?=filter_input(INPUT_POST, "order") == 'price DESC' ? ' selected="selected"' : ''?>>
                        Sort: Price high to low
                      </option>
                      <option value='area ASC'
                        <?=filter_input(INPUT_POST, "order") == 'area ASC' ? ' selected="selected"' : ''?>>
                        Sort: Area low to high
                      </option>
                      <option value='area DESC'
                        <?=filter_input(INPUT_POST, "order") == 'area DESC' ? ' selected="selected"' : ''?>>
                        Sort: Area high to low
                      </option>
                  </select>
                </form>
                </div>
                </div>
                <!-- filter panel end-->
                    
                 
                <!--results content-->
                <div  class="container" style="overflow: auto; height: 70%; width: 100%; float: right;  margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
                <?php
                    $order = filter_input(INPUT_POST, "order");
                    $sortField = 'property_id';
                    $sortOrder = 'ASC';
                    if ($order)
                    {
                        $sort = explode(' ', $order);
                        $sortField = $sort[0];
                        $sortOrder = $sort[1];
                    }
                    $properties = PropertyController::searchProperty($address, $sortField, $sortOrder);
                    $maps = new Maps($properties);
                    $maps->genXML();
                ?>
                <script type="text/javascript">
                    $(function() {
                        $.getScript('../javascripts/maps.js', function() {
                            load();
                        });
                    });
                </script>

                <div class="row" style=" height: 75%; margin : 0px 0px 0px 0px; padding: 0px 0px 0px 0px ; text-align : left; ">
                <?php
                if ( $properties != 0 )
                {   
                    $no = 0; 
                    foreach ($properties as $property)
                    {?>
                    <div class="col-sm-6 col-md-6 col-lg-4" style="padding: 5px 2px 0px 5px; margin-bottom: 2px 2px 2px 2px ; ">
                        <div class="thumbnail" style="margin-bottom: 0px;">
                            <?php
                              $property_img = PROPERTY_DIR .'/'. $property['property_id'] .'.jpg';
                              $ic = new ImageController();
                              $ic->compressImage($property_img, 50);
                            ?>
                            <div class="caption">
                                  <p><strong><?php echo $no + 1; $no++; ?></strong></p>
                                  <?php
                                  if ($property['address2'] != NULL)
                                  {
                                  echo $property['address2'] .',' ;
                                  }
                                  echo $property['address1']. ", ";
                                  echo $property['zipcode'],', ',$property['city'],', ',$property['state']; ?>
                                <p align="center">
                                    <strong style="font-size: 18">
                                      <?php
                                      setlocale(LC_MONETARY, 'en_US');
                                    echo "$ " ; echo number_format($property['price']).".00";  ;
                                       ?>
                                    </strong>
                                </p>
                              <p>
                              <a href="./property.php?Search=<?php $a = str_replace(" ", "+", $address);
            echo $a;?>&PropertyId=<?php echo $property['property_id']; ?>" class="btn btn-sm btn-default pull-left" role="button">More Details</a>
                              <a href="#myModal_sell" data-toggle="modal" class="btn btn-md btn-primary pull-right" role="button">Buy</a>
                                  
                              </p>
                            </div>
                        </div>
                    </div>
                    <?php

                    } 
                }
                else
                { ?>
                    <div class="container" style="overflow: auto; height: 75%; width: 100%;" >
                        <div class="panel-body" >
                            <p style="text-align: center">
                <?php
                    echo 'NO RESULTS FOUND.';
                ?>    
                                </p>
                        </div>     
                    </div>    
                <?php    
                }
               ?>
                    
                </div>
            </div>
            </div>    
            </div> <!-- row-->
        </div><!--main container ends-->
        
       
        </div>
        
              
       <?php include "./../include/Modal_header.html"?>
       <?php include "./../include/footer.html"?>
 

    
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