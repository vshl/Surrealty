<?php
// This section checks if logged in user has sufficent rights and redirect him
// to home.php if not. 
// pathMaker.php is necessary to calculate the prefix for the absolut path
// F.Hahner 27.11.2014
include ('../../../pathMaker.php');
require_once($path.'/include/checkUser.php');
checkUserRoleAndRedirect(array('AGENT', 'ADMIN'), "../../home.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Agent Dashboard</title>

    <!-- Bootstrap core CSS -->

<link href="../../../frameworks/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<link href="../../../frameworks/bootstrap/dist/bootstrap.min.css" rel="stylesheet">
<link href="../../../frameworks/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<!--<link href="bootstrap-3.3.0/js/jquery-ui-1.9.2.custom.css" rel="stylesheet">-->

<script src="../../../javascripts/jquery-2.1.1.js"></script>
<script src="../../../javascripts/ajax.js"></script>
<!-- <script src="../../../frameworks/bootstrap/dist/js/bootstrap.js"></script> -->
<script src="../../../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../../frameworks/bootstrap/dist/js/npm.js"></script>
<script src="../../../javascripts/jquery.toaster.js"></script>

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
<script>
        $(document).ready( function() {
            giveUnseenCommentsByAgentID();
        });
</script>
<script src="../../../javascripts/upload_prop.js"></script>

<!-- our main Css / it can be later on one separated file--> 
 <style type="text/css">
            body {
                background: white; 
                background-image: url("./../../../images/house1.jpg");
                background-repeat: no-repeat;
                background-position: center top
                
            }
            section {
                background: black;
                color: black;
                border-radius: 1em;
                padding: 1em;
                position: absolute;
                top: 80%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%)
            }
            
            
           
            input[type=submit] {
                color:black;
            }

             h1.white {
                text-align:center;
                color:white;
                font-family:"Trebuchet MS","Helvetica Neue",Arial,sans-serif;
                font-size: 18px;
            }

            h3.white {
                text-align:center;
                color:white;
                font-family:"Trebuchet MS","Helvetica Neue",Arial,sans-serif;
                font-size: 16px;
            }


           

            .well{
               
                background: rgba(255, 255, 255, 0.7); 
                }
                           
             .thumb {max-width:150px;max-height:130px;}
             .thumbuser {width:80px;height:80px;} 
             .thumbusercomment {max-width:60px;max-height:60px;}               

              .nav-tabs>li>a {
                background-color: #333333; 
                border-color: #777777;
                color:#fff;
              }

              /* active tab color */
              .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
                color: #fff;
                background-color: #666;
                border: 1px solid #888888;
              }

              /* hover tab color */
              .nav-tabs>li>a:hover {
                border-color: #000000;
                background-color: #111111;
              }   
        </style>
  </head>
<body>

<div class="container-fluid"><!-- main container -->
        <!--header--> 
        <?php include "../../../include/header.php" ?>
        <br><br><br><br>

<div class="row">
<div class="col-md-10 col-md-offset-1">

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#Listings" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;My Listings</a></li>
  <li role="presentation"><a href="#Comments" role="tab" data-toggle="tab" onclick="readCommentsForUser(<?php echo $_SESSION['user_id']; ?>)"><i class="glyphicon glyphicon-comment"></i>&nbsp;Comments&nbsp;
          <span id="tab_count_unseen_comments" class="badge">0</span></a></li>
  <li role="presentation"><a href="#Profile" role="tab" data-toggle="tab" id="profileTab"><i class="glyphicon glyphicon-user"></i>&nbsp;Profile</a></li>
    <li role="presentation"><a href="#AddProperty" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-import"></i>&nbsp;Add Property</a></li> 
<!-- <li role="presentation"><a href="http://localhost:8080/AddProperty/" target="_blank" ><i class="glyphicon glyphicon-import"></i>&nbsp;Add Property</a></li> -->
  <li role="presentation"><a  href="#Myappointment" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-calendar"></i>&nbsp;My Appointments</a></li>
</ul>

<div class="tab-content">
<!-- Tab my listings -->
  <div role="tabpanel" class="tab-pane active" id="Listings">
   <div class="well">
                <div class="page-header">
                <h1>My Listings</h1> 
                </div>
                                         <form class="form-inline" role="form" action="">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <span class="badge">Sort by:&nbsp;</span>
                                                  <select class="select" value="" name="">
                                                    
                                                     <option value="surface">Surface</option>
                                                     <option value="rating">Rating</option>
                                                     <option value="price">Price</option>
                                                     <option value="date">Date</option>
                                                  </select>
                                                  <div class="btn-group btn-toggle btn-group-xs" data-toggle="buttons">
                                                        <label class="btn btn-default active">
                                                          <input type="radio" name="options" value="asc">
                                                          <span class="glyphicon glyphicon-sort-by-attributes"></span>
                                                        </label>
                                                        <label class="btn btn-default ">
                                                          <input type="radio" name="options" value="dsc">
                                                          <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
                                                        </label>
                                                  </div>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="checkbox">
                                                      <label>
                                                       <span class="badge">&nbsp;&nbsp;Show sold properties</span>
                                                      </label> 
                                                      <input type="checkbox" name="">
                                                    </div>
                                                    &nbsp;&nbsp;<button type="submit" class="btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>
                                              </div>
                                            </div>
                                         </form>
                                          <hr>
<div class="" style="max-height:500px; min-width:70px; overflow-y:auto;"> <!--container for all results rows-->              
<!--a row of result inside tab-->
<div class="row well"> 
      <div class="col-xs-12 col-sm-2">
        <a class="" href="#">
          <img class="img-circle img-responsive" src="./../../../images/house2.jpg"  >
        </a>
      </div>
      <div class="col-xs-12 col-sm-4">
        <h5><span class="badge">Property ID:xxxx</span>
        <a href="">6 <i class="glyphicon glyphicon-comment"></i></a></h5>
          <h6>Creation-date:16-11-2014</h6>
          <h6>Price:400.000$</h6>
          <br>

          <div><a href="#"><span class="badge"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;Sold</span></a>
          <a href="#"><span class="badge"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Details</span></a>
          <a href="#"><span class="badge"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Edit</span></a>
          <a href="#"><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a>
          </div>                          
      </div>
      <div class="col-xs-12 col-sm-3">
          <h5><span class="badge">Address:</span></h5>
          <p><br>203 East 50th St., Suite 1157 New York, NY 10022 USA</p> 
      </div>
      <div class="col-xs-12 col-sm-3">
          <h5><span class="badge">Facts:</span></h5>
          <h6>Rooms:4</h6>
          <h6>Surface:1614 m&sup2;</h6>
          <h6>Pool:</h6>
          <h6>Balcon:</h6>
      </div> 
</div><!--endof row of result inside tab-->

<hr>

<!--a row of result inside tab-->
<div class="row well"> 
                  <div class="col-xs-12 col-sm-2">
                    <a class="" href="#"><img class="img-circle img-responsive" src="./../../../images/house3.jpg"  ></a>
                  </div>
                  <div class="col-xs-12 col-sm-4">
                        <h5><span class="badge">Property ID:xxxx</span>
                         <a href="">2 <i class="glyphicon glyphicon-comment"></i></a></h5>
                      <h6>Price:400.000$</h6>
                      <h6>Creation-date:16-11-2014</h6>
                      <br>

                      <div><a href="#"><span class="badge"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;Sold</span></a>
                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Details</span></a>
                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Edit</span></a>
                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a>
                      </div>                          
                  </div>
                  <div class="col-xs-12 col-sm-3">
                      <h5><span class="badge">Adresse:</span></h5>
                      <p><br>203 East 50th St., Suite 1157 New York, NY 10022 USA</p> 
                  </div>
                  <div class="col-xs-12 col-sm-3">

                      <h5><span class="badge">Facts:</span></h5>
                      <h6>Rooms:4</h6>
                      <h6>Surface:1614 m&sup2;</h6>
                      <h6>Pool:</h6>
                      <h6>Balcon:</h6>


                  </div> 
  
</div><!--endof row of result inside tab-->

<hr>

<!--a row of result inside tab-->
<div class="row well"> 
                  <div class="col-xs-12 col-sm-2">
                                    
                                 
                                    <a class="" href="#">
                                      <img class="img-circle img-responsive" src="./../../../images/house4.jpg"  >
                                    </a>
                                      
                                    
                  </div>


                  <div class="col-xs-12 col-sm-4">

                                    
                                        <h5><span class="badge">Property ID:xxxx</span>
                                        </h5>
                                      

                                      
                                      <h6>Price:400.000$</h6>
                                      <h6>Creation-date:16-11-2014</h6>
                                      <br>

                                      <div><a href="#"><span class="badge"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;Sold</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Details</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-wrench"></i>&nbsp;Edit</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</span></a>
                                      </div>                          
                                    

                  </div>

               

                  <div class="col-xs-12 col-sm-3">


                      <h5><span class="badge">Adresse:</span></h5>
                      <p><br>203 East 50th St., Suite 1157 New York, NY 10022 USA</p> 



                  </div>


                  <div class="col-xs-12 col-sm-3">

                      <h5><span class="badge">Facts:</span></h5>
                      <h6>Rooms:4</h6>
                      <h6>Surface:1614 m&sup2;</h6>
                      <h6>Pool:</h6>
                      <h6>Balcon:</h6>


                  </div> 
  
</div><!--endof row of result inside tab-->


</div><!--end of container for all results rows-->




   </div><!--endof well-->
  </div><!--endof tab pannel-->


<!-- Tab comments -->
  <div role="tabpanel" class="tab-pane " id="Comments">
   <div class="well">

                <div class="page-header">
                <h1>Comments</h1> 
                </div>
               <div class="checkbox">
                <label>
                 <span class="badge">&nbsp;&nbsp;Show hidden comments&nbsp;&nbsp;</span>
                </label> 
                   <input type="checkbox" name="" id="chkbox_show_seen_comments" onchange="readCommentsForUser(<?php echo $_SESSION['user_id']; ?>)">
              </div>
               <div id="comment_container" style="max-height:500px; min-width:70px; overflow-y:auto;"> <!--container for all results rows-->              
   
                <div class="row well">
                    <div class="col-xs-6 col-sm-2">

                         <a class="" href="#">
                                      <img class="img-circle img-responsive" src="./../../../images/house5.jpg">
                                      <h5><span class="badge">Property ID:xxxx</span></h5>
                         </a>

                    </div>
                    <div class="clearfix visible-xs-block"></div>



                    <div class="col-xs-6 col-sm-6">


                        <label><img class="img-circle thumbusercomment" src="./../../../images/images.jpg">&nbsp;Max Musterman has commented:</label>
                        <p>Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the parBootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par</p>


                    </div>

                    <!-- Add the extra clearfix for only the required viewport -->
                    <div class="clearfix visible-xs-block"></div>

                    <div class="col-xs-6 col-sm-4">

                                       <br><br><br> 
                                      <div><a href="#ReplyComment" data-toggle="modal"><span class="badge"><i class="glyphicon glyphicon-send"></i>&nbsp;Reply</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Show property details</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-eye-close"></i>&nbsp;Hide</span></a>
                                      </div>

                    </div>
                </div><!--endof row inside tab-->




                <div class="row well">
                    <div class="col-xs-6 col-sm-2">

                         <a class="" href="#">
                                      <img class="img-circle img-responsive" src="./../../../images/house4.jpg">
                                      <h5><span class="badge">Property ID:xxxx</span></h5>
                         </a>

                    </div>
                    <div class="clearfix visible-xs-block"></div>



                    <div class="col-xs-6 col-sm-6">


                        <label><img class="img-circle thumbusercomment" src="./../../../images/images.jpg">&nbsp;Max Musterman has commented:</label>
                        <p>Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the parBootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par</p>


                    </div>

                    <!-- Add the extra clearfix for only the required viewport -->
                    <div class="clearfix visible-xs-block"></div>

                    <div class="col-xs-6 col-sm-4">
                                      <br><br><br>

                                      <div style=""><a href="#ReplyComment" data-toggle="modal"><span class="badge"><i class="glyphicon glyphicon-send"></i>&nbsp;Reply</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Show property details</span></a>
                                      <a href="#"><span class="badge"><i class="glyphicon glyphicon-eye-close"></i>&nbsp;Hide</span></a>
                                      </div>

                    </div>
                </div><!--endof row inside tab-->







              </div><!--end of container for all results rows-->    

   </div>
  </div> 



<!-- Tab my profile -->
  <div role="tabpanel" class="tab-pane " id="Profile">
   <div class="well">

                <div class="page-header">
                <h1>Agent Profile<small>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?>&nbsp;&nbsp;<img id="user_avatar" src="../../../images/loading.gif" class="img-circle thumbuser"></small></h1> 
                </div>   


                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 well" id="myprofile">
                        
                        <!--
                        <form action="" methode="">
                          <div class="input-group" title="firstname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" name="firstname" id="" type="" placeholder="your first name" >
                          </div>

                          <div class="input-group" title="lastname">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" name="lastname" id="" type="" placeholder="your last name" >
                          </div>

                          <div class="input-group" title="email">
                            <span class="input-group-addon">@</span>
                            <input class="form-control" name="email" id="" type="" placeholder="your e-mail" >
                          </div>

                          <div class="input-group" title="Password">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control" name="password" id="password" type="password" placeholder="your password">
                          </div>

                          <div class="input-group" title="phone">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                            <input class="form-control" name="phone" id="" type="" placeholder="your phone number" >
                          </div>



                          <div class="input-group" title="addr1">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input class="form-control" name="addr1" id="" type="" placeholder="your first adresse">
                          </div>

                          <div class="input-group" title="addr2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input class="form-control" name="addr2" id="" type="" placeholder="your seconde adresse" >
                          </div>

                          <div class="input-group" title="zip">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                            <input class="form-control" name="zip" id="" type="" placeholder="your zip code">
                          </div>

                          <div class="input-group" title="city">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                            <input class="form-control" name="city" id="" type="" placeholder="your city name" >
                          </div>

                          <div class="input-group" title="state">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                            <input class="form-control" name="state" id="" type="" placeholder="your state name">
                          </div>

                          <div class="input-group" title="image">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                            <span class="btn btn-default btn-file">
                                <input type="file" data-filename-placement="inside" id="image_name" title="Search for a file to add">
                                <input type="hidden" id="signup_image_id">
                            </span>
                            <span class="btn">
                                <input type="button" value="Upload" id="signup_upload_picture_btn">
                            </span>
                            <span class="">
                                <img id="signup_user_image" src="../images/placeholder.jpg" height="48" width="48">
                            </span>
                          </div>

                          <a href="#UpdateProfile" class="modal-toggle" data-toggle="modal">
                            <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-wrench"></i> Modify</button>
                          </a>
                        </form>  -->              
                    </div>
                  </div><!--endof row inside tab-->
   </div>
  </div> 





<!--tab AddProperty-->
<div role="tabpanel" class="tab-pane" id="AddProperty">

<div class="well">

                <div class="page-header">
                <h1>Add Property</h1> 

                </div>





<div class="row">
        
                <div class="col-xs-12 col-sm-6  well">



                  <form action="#" methode="POST" id="addPropertyFrom">

                                    
                                              <div class="input-group" title="title">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="p_title" id="p_title" type="" placeholder="Titel of property">
                                              </div>


                                              <div class="input-group" title="p_addr1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="p_addr1" id="p_addr1" type="" placeholder="First adresse">
                                              </div>

                                              <div class="input-group" title="addr2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="p_addr2" id="p_addr2" type="" placeholder="Second adresse">
                                              </div>
                         
                                              <div class="input-group" title="zip">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                                <input class="form-control" name="p_zip" id="p_zip" type="p_zip" placeholder="Zip code">
                                              </div>


                                              <div class="input-group" title="neighborhood">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
                                                <input class="form-control" name="p_neighborhood" id="p_neighborhood" type="" placeholder="Neighborhood">
                                              </div>

                                              <div class="input-group" title="city">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                <input class="form-control" name="p_city" id="p_city" type="" placeholder="City">
                                              </div>

                                              <div class="input-group" title="state">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                                                <input class="form-control" name="p_state" id="p_state" type="" placeholder="State">
                                              </div>

                                              <div class="input-group" title="country">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                                <input class="form-control" name="p_country" id="p_country" type="" placeholder="Country">
                                              </div>

                                  
                                          <!--button-->



                </div>

              
              <div class="col-xs-12 col-sm-6 well">

                 <div class="input-group" title="description">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-text-width"></i></span>
                      <textarea class="form-control" name="p_description" id="p_description" placeholder="Property description"></textarea>
                 </div>

<br> Enter a number for: <br>

              <div class="input-group">

                      <span class="input-group-addon"><small>Balcon</small></span>
                      <input class="form-control" titel="balcon" name="p_balcon" id="p_balcon" type="">


                      <span class="input-group-addon"><small>Pool</small></span>
                      <input class="form-control" titel="pool" name="p_pool" id="p_pool" type="">
                      
       
                      <span class="input-group-addon"><small>Bath</small></span>
                      <input class="form-control" titel="bath" name="p_bath" id="p_bath" type="">
                 </div>   


                 <div class="input-group">

                      <span class="input-group-addon"><small>Bed</small></span>
                      <input class="form-control" titel="number of beds" name="p_bed" id="p_bed" type="">


                      <span class="input-group-addon"><small>Area&nbsp;<div class="badge">m&sup2;</div></small></span>
                      <input class="form-control" titel="Area" name="p_area" id="p_area" type="">
                      
       
                      <span class="input-group-addon"><small>Price&nbsp;<div class="badge">$</div></small></span>
                      <input class="form-control" titel="price" name="p_price" id="p_price" type="">
                 </div>

              


              </div>  

</div>

 

<div class="row">
        
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 well">Photos
                                          <input type="file" data-filename-placement="inside" id="property_image_name" title="Search for a file to add">
                                                    <input type="hidden" id="property_image_id">
                                                                                                    <span class="btn">
                                                    <input type="button" value="Upload" id="property_picture_btn">
                                              
                                                    <img id="property_image" src="../../../images/placeholder2.jpg" height="48" width="48">
                                                </span>
                                          <a href="" class="">
                                            <button type="submit" onclick="javascript:addAProperty(event);" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Property</button>
                                          </a> 
                                          </form>

                </div>

</div>

</div>

</div>
<!--endof tab add property-->




<!-- Tab my appointment -->
  <div role="tabpanel" class="tab-pane " id="Myappointment">
   <div class="well">

                <div class="page-header" style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 10px; margin-top: 0px">
                <h1>My Appointments</h1> 
                </div>   

                
                
                <div ng-app="todo">

                <div ng-controller="TodoController">
                    
                    

                    
                    <form class="form-inline" ng-submit="addTask()" name="ff">
                    <div class="input-group">    
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input class="form-control input-group-sm" name="appointment" id="appointment" type="text" ng-model="appointment" placeholder="Oppointment with Mr/Mrs" required />
                    </div>  
                    <div class="input-group" >    
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input class="form-control input-group-sm datepick" name="date"  id="dp" ng-model="date" placeholder="Select the date" maxlength="25" size="15" required />
                    </div>
                    <div class="input-group">  
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    <input class="form-control input-group-sm timepick" name="time" id="time"  ng-model="time" placeholder="Select the time" maxlength="25" size="15" required />
                    </div>    
                    <button type="submit" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-plus"></i></button>
                    <div class="input-group pull-right">  
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <input class="form-control input-group-sm " id="search" name="search" type="search" ng-model="search"  placeholder="Search ..." maxlength="30" size="30"/>
                    </div>
                    </form>
                    
                   
                    
                    <hr>
                    <div class="text-info" style="padding-bottom: 5px;"><div class="badge">{{restant}}</div> All Appointments to do, <div class="badge">{{restanttoday}}</div> today. </div>
                   
                    <div class="alert alert-{{notification.type}}" style="display: none;" role="alert" data-notification="{{notification.status}}">{{notification.message}}</div>
                    <div style="max-height:400px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                
                                <th data-field="appid" ng-hide="true"></th>
                                
                                <th data-field="appname" style="background-color: #bbbbbb;">
                                    <a href="#" ng-click="orderByField='apointment_with'; reverseSort = !reverseSort">
                                        Appointment with Mr/Mrs <span ng-show="orderByField == 'apointment_with'"><span ng-show="!reverseSort">
                                                <i class="glyphicon glyphicon-chevron-up"></i>
                                            </span><span ng-show="reverseSort"><i class="glyphicon glyphicon-chevron-down"></i></span></span>
                                    </a>
                                </th>
                                
                                <th data-field="appdate" style="background-color: #bbbbbb; text-align: center;">
                                    <a href="#" ng-click="orderByField='date'; reverseSort = !reverseSort">
                                        Appointment day <span ng-show="orderByField == 'date'"><span ng-show="!reverseSort">
                                                <i class="glyphicon glyphicon-chevron-up"></i>
                                            </span><span ng-show="reverseSort"><i class="glyphicon glyphicon-chevron-down"></i></span></span>
                                    </a>
                                </th>
                                
                                <th data-field="apptime" style="background-color: #bbbbbb; text-align: center;">
                                    <a href="#" ng-click="orderByField='time'; reverseSort = !reverseSort">
                                        Appointment time <span ng-show="orderByField == 'time'"><span ng-show="!reverseSort">
                                                <i class="glyphicon glyphicon-chevron-up"></i>
                                            </span><span ng-show="reverseSort"><i class="glyphicon glyphicon-chevron-down"></i></span></span>
                                    </a>
                                </th><!--
<!--                            <th data-field="appname" style="background-color: #bbbbbb;">Appointment with Mr/Mrs</th>
                                <th data-field="appday" style="text-align: center; background-color: #bbbbbb;">Appointment day</th>
                                <th data-field="apptime" style="text-align: center; background-color: #bbbbbb;">Appointment time</th>-->
                                <th data-field="appdone" style="text-align: center; background-color: #bbbbbb;">Delete</th>
                                <th data-field="appedit" style="text-align: center; background-color: #bbbbbb;">Edit</th>
                                <th data-field="appdel" style="text-align: center; background-color: #bbbbbb;">Done</th>

                            </tr>    
                        </thead>
                        <tbody style="font-size: 13px; font-weight:bold;">
                            <tr ng-repeat="task in tasks |orderBy:orderByField:reverseSort | filter:search ">
                                <td ng-hide="true"><input type="text" value="{{task.id}}"/></td>   
                              <td>{{task.apointment_with}}</td>
                              <td style="text-align: center;">{{task.date}}</td>
                              <td style="text-align: center;">{{task.time}}</td>
                              <td><button class="btn btn-danger btn-xs center-block" ng-click="deltask(task.id);  notification.message = 'Appointment with ' + task.apointment_with + ' is deleted'; notification.type = 'danger'"><span class="glyphicon glyphicon-trash"></span></button></td>
                              
                              
                              
                              <td>
                                  <a href="#updatapp" class="modal-toggle" data-toggle="modal">
                                  <button class="btn btn-info btn-xs center-block" ng-click="loadeditmodal(task.id, task.apointment_with, task.date, task.time)"><span class="glyphicon glyphicon-edit"></span></button>
                                  </a>
                              </td>    
                              <td><button class="btn btn-success btn-xs center-block"  ng-click="taskdone(task.id); notification.message = 'Appointment with ' + task.apointment_with + ' is set done'; notification.type = 'success'"><span class="glyphicon glyphicon-ok-sign"></span></button></td>
<!--<div ng-repeat="today in todayapp">                           
<script>
$(function() {

toastr["info"](today.date);
       
        });
</script>
</div> -->
                            <!--modal for update appointment-->
                                <div id="updatapp" class="modal fade">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit Appointment <p ng-hide="true">{{appid}}</p></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group">    
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control input-group-sm" name="editappwith" id="editappwith" type="text" ng-model="appwith" value="{{appwith}}"  required /> 
                                                </div>          
                                                <div class="input-group"> <!-- onclick="javascript:NewCssCal('date')" style="cursor:pointer"--> 
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input class="form-control  input-group-sm datepick" name="editappdate" id="datepicker"  ng-model="appdate" value="{{appdate}}" maxlength="25" size="25" required />
                                                </div>
                                                <div class="input-group">  
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                <input class="form-control input-group-sm " name="editapptime" id="timepicker"  ng-model="apptime" value="{{apptime}}" maxlength="25" size="25" required />
                                                </div>

                                            </div> 


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Close</button>
                                                <button type="submit" id="" class="btn btn-success btn-xs" ng-click="updatetask(appid, appwith, appdate, apptime); notification.message = 'Appointment with ' + appwith + ' is modified'; notification.type = 'info'" data-dismiss="modal"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp;save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- en of modal update appointment-->
                           </tr> 
                        </tbody>    
                    </table>
                    </div>               
                
               
                <!--endof row inside tab-->
   </div>
  </div> 



</div>



</div><!--endof tab contents-->


</div><!--endglobal colon of the hole tabs-->
</div> <!--endglobal row-->

<!--Modal for replay  comment-->
 <div id="ReplyComment" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-comment"></span>&nbsp;Reply Comment</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="text-center"> 
                    <img id="reply_image" src="https://secure.gravatar.com/avatar/de9b11d0f9c0569ba917393ed5e5b3ab?s=140&r=g&d=mm" class="img-circle thumbuser">
                    
                    
                    <h4 id="reply_name" class="text-left">MAX Mustermann</h4>
                    <h6 id="reply_address" class="text-left">Adresse: florengasse 36 Fulda 36039 Germany</h6>
                    <h6 id="reply_telephon" class="text-left">Tel:16112014</h6>
                    </div>


                    

                      <div class="input-group" title="comment">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <textarea class="form-control" name="" id="reply_comment"  placeholder="Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the parBootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par Bootstrap is responsive and since version" disabled="disabled"></textarea>
                      </div>
            
                      <div class="input-group" title="commentreply">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <textarea class="form-control" name="answer" id="reply_answer" placeholder="type your answer to this comment"></textarea>
                      </div>
                    
                </div> 
                    
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="reply_submit_btn" class="btn btn-primary" onClick=""><span class="glyphicon glyphicon-send"></span>&nbsp;submit</button>
                </div>
            </div>
        </div>
    </div>

<!--end of Modal for replay  comment-->

<!--Modal for user update profile-->
 <div id="UpdateProfile" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-save"></span>&nbsp;Update profile</h4>
                </div>
                <div class="modal-body">
                    
                    
                   <form action="" methode="">

                                    
                                              <div class="input-group" title="firstname">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" name="firstname" id="" type="" placeholder="your first name">
                                              </div>

                                              <div class="input-group" title="lastname">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" name="lastname" id="" type="" placeholder="your last name">
                                              </div>

                                              <div class="input-group" title="email">
                                                <span class="input-group-addon">@</span>
                                                <input class="form-control" name="email" id="" type="" placeholder="your e-mail">
                                              </div>

                                              <div class="input-group" title="Password">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" name="password" id="password" type="password" placeholder="your password">
                                              </div>

                                              <div class="input-group" title="phone">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                                <input class="form-control" name="phone" id="" type="" placeholder="your phone number">
                                              </div>

          

                                              <div class="input-group" title="addr1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr1" id="" type="" placeholder="your first adresse">
                                              </div>

                                              <div class="input-group" title="addr2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr2" id="" type="" placeholder="your seconde adresse">
                                              </div>

                                              <div class="input-group" title="zip">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                                <input class="form-control" name="zip" id="" type="" placeholder="your zip code">
                                              </div>

                                              <div class="input-group" title="city">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                <input class="form-control" name="city" id="" type="" placeholder="your city name">
                                              </div>

                                              <div class="input-group" title="state">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                                                <input class="form-control" name="state" id="" type="" placeholder="your state name">
                                              </div>

                                              <div class="input-group" title="image">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                <span class="btn btn-default btn-file"><input type="file" data-filename-placement="inside" name="image" title="Search for a file to add"></span>
                                              </div>
    
                </div> 
      
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-save"></i> Save</button> </form>

                </div>
            </div>
        </div>
    </div>
<!--end of Modal for user update profile-->

<!--Footer-->
        <?php include "./../../../include/footer.html"?>
        <?php include "./../../../include/Modal_header.html"?>

</body>
</html>
