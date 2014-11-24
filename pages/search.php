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
require_once './../APIs/geocoder.php';
require_once './../controllers/PropertyController.php';
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
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCopAYcpV4Eo5BZ9q3PbeAI4nPBTct36HE"></script>
      <script type="text/javascript">
    //<![CDATA[
    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(37.7577,-122.4376),
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      });
      var infoWindow = new google.maps.InfoWindow;

      var bounds = new google.maps.LatLngBounds();

      // Change this depending on the name of your PHP file
      var searchUrl = 'genXMLForMap.php?search=' + <?php echo json_encode($address);?>;
      downloadUrl(searchUrl, function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var property_id = markers[i].getAttribute("property_id");
          var address = markers[i].getAttribute("address");
          var price = markers[i].getAttribute("price");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          bounds.extend(point);
          // var html = "<b>" + address + "<br/>Price: </b>$" + price;
          var html =
              [ '<strong>Address: </strong>' + address + '<br/>',
               '<strong>Price: $' + price + '</strong><br/>',
               '<a href="property.php?Search='+<?php echo json_encode($address);?>+'&PropertyId='+ property_id +'" role="button" class="btn btn-info btn-xs">Details</a>',
               // '<a href="property.php" role="button" class="btn btn-primary btn-xs">Details</a>',
               ].join('\n');
          var marker = new google.maps.Marker({
            map: map,
            position: point,
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
        map.fitBounds(bounds);
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState === 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>

  </script>
  
  
      <title> Search results for <?php echo " " . $address; ?> </title>
    </head>
    
    
    <body onload="load()">
        
        <div class="container-fluid" >
        <!--header-->
        <?php include "./../include/header.html" ?>
        <!--main content-->
        <div class="container-fluid "   style="margin-top: 6%; padding: 0px 0px 0px 0px;">
            <div class="row">
            <!--map-->
            <div   class="col-lg-4 col-md-4 col-sm-0" style="  float: left; padding: 0px 5px 0px 5px; margin: 0px 0px 0px 0px;">
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
                    
                <input size="60" type="text" class="form-control input-group-lg no-margin no-padding" placeholder="<?php echo $address; ?>" autofocus name="search">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="submit"><strong>Search</strong></button>
                </span>
                </div>
                </form>
                    
                </div> 
                    <!--search box end-->
                     <!--filter panel start-->
                     <div class="panel panel-body " style=" margin-top: 2px; margin-bottom: 2px; padding: 2px;  border: 0px; border-radius: 0px;">   
                <?php echo "Results for " ; ?> <strong><?php echo $address; ?></strong>
                <div class="pull-right">
                Sort by :
                <select class="input-sm">
                        <option value="one"> Price : Low to High </option>
                        <option value="two"> Price : High to Low </option>
                        <option value="three"> Area : Low to High </option>
                        <option value="four"> Area : High to Low </option>
                </select>              
                </div>
                </div>
                <!-- filter panel end-->
                    
                 
                <!--results content-->
                <div  class="container" style="overflow: auto; height: 70%; width: 100%; float: right;  margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
                <?php
                    require_once '../controllers/PropertyController.php';
                    $search = $address;
//                            filter_input(INPUT_GET, 'search');
                    $properties = PropertyController::searchProperty($search);
                ?>
                <div class="row" style=" height: 75%; margin : 0px 0px 0px 0px; padding: 0px 0px 0px 0px ; text-align : left; ">
                <?php
                if ( $properties != 0 )
                {    
                    foreach ($properties as $property)
                    {?>
                    <div class="col-sm-6 col-md-6 col-lg-4" style="padding: 5px 2px 0px 5px; margin-bottom: 2px 2px 2px 2px ; ">
                        <div class="thumbnail" style="margin-bottom: 0px;">
                            <img src="<?php echo "./../images/property_images/". $property['property_id'] .".jpg"; ?>" alt="..." width="771" height="577" style="width:571px;height:280px;"  >
                            <div class="caption">
                              <h4>
                                  <?php 
                                  if ($property['address2'] != NULL)
                                  {
                                  echo $property['address2'] .',' ;
                                  }
                                  echo $property['address1']. ", ";
                                  echo $property['zipcode'],', ',$property['city'],', ',$property['state']; ?></h4>
                                <p>
                                    <strong style="font-size: 25">
                                      <?php
                                      setlocale(LC_MONETARY, 'en_US');
                                    echo "$ " ; echo number_format($property['price']).".00";  ;
                                       ?>
                                    </strong>
                                </p>
                              <p>
                                  <a href="#myModal_sell" data-toggle="modal" class="btn btn-lg btn-primary" role="button" style="width: 120px;">Buy</a>
                                 <a href="./property.php?Search=<?php $a = str_replace(" ", "+", $address);
            echo $a;?>&PropertyId=<?php echo $property['property_id']; ?>" class="btn btn-lg btn-default" role="button">More Details</a> 
                                  
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
        
        <!--footer-->
            <?php include "./../include/footer.html" ?>
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
        
        
        
    </body>
</html>