<?php
include ('../../../pathMaker.php');
require_once($path.'/include/checkUser.php');
checkUserRoleAndRedirect(array('BUYER'), "../../home.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surreality</title>
    <!-- Bootstrap core CSS -->
    <link href="../../../frameworks/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
    <link href="../../../frameworks/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../frameworks/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
<!-- Integration jQuery libraire  -->
    <script src="../../../frameworks/bootstrap/dist/js/bootstrap.js"></script>
    <script src="../../../frameworks/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../../frameworks/bootstrap/dist/js/npm.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
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


              .vcenter {
                  display: inline-block;
                  vertical-align: middle;
                  float: none;
              }


    </style>
  
  </head>
  <body>
      <div class="container-fluid"><!-- main container -->
        <!--header--> 
        <?php include "../../../include/header.php" ?>




   





<div class="row">
<div class="col-md-10 col-md-offset-1">

<ul class="nav nav-tabs" role="tablist">

   <li role="presentation" class="active"><a href="#Listings" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;My Listings</a></li>
  <li role="presentation"><a href="#Comments" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-comment"></i>&nbsp;Comments&nbsp;<span class="badge">2</span></a></li>
  <li role="presentation"><a href="#Profile" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-user"></i>&nbsp;Profile</a></li>
  <li role="presentation"><a href="#Preferences" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-cog"></i>&nbsp;Preferences</a></li>
</ul>
 

<div class="tab-content">
<!-- Tab my listings -->
  <div role="tabpanel" class="tab-pane active" id="Listings">
   <div class="well">

      
                <h1>My Listings</h1> 
               
                                        
                                        

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
                                                    
                                                    &nbsp;&nbsp;<button type="submit" class="btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>

                                                    
                                                      
                                                      
                                                       


                                              </div>
                                            </div>
                                            
                                            

                                         </form>

                                          <hr>
<div class="" style="max-height:500px; min-width:70px; overflow-y:auto; overflow-x:hidden; "> <!--container for all results rows-->              
<!--a row of result inside tab-->
<div class="row well"> 
                  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                                    
                                 
                                    <a class="" href="#">
                                        <img class="center-block thumb img-circle img-responsive" src="./../../../images/house2.jpg"  >
                                    </a>
                                      
                                    
                  </div>


                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-5">

                                    
                                        <h5><span class="badge">Property ID:xxxx</span></h5>
                                        
                                      

                                      
                                      <h6>Price:400.000$</h6>
                                      <h6>Creation-date:16-11-2014</h6>
                                      <br>

                                      <div><a href="#"><span class="badge" style=" margin-top: 5px; "><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;remove</span></a>
                                      <a href="#"><span class="badge" style=" margin-top: 5px; "><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Details</span></a>
                                      <a href="#PostComment" data-toggle="modal"><span class="badge" style=" margin-top: 5px; "><i class="glyphicon glyphicon-comment"></i>&nbsp;Comment</span></a>
                                      <a href="#AgentDetails" data-toggle="modal"><span class="badge" style=" margin-top: 5px; "><i class="glyphicon glyphicon-user"></i>&nbsp;Conatct</span></a>
                                      </div>                          
                                    

                  </div>

               

                  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">


                      <h5><span class="badge">Adresse:</span></h5>
                      <p><br>203 East 50th St., Suite 1157 New York, NY 10022 USA</p> 



                  </div>


                  <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">

                      <h5><span class="badge">Facts:</span></h5>
                      <h6>Rooms:4</h6>
                      <h6>Surface:1614 m&sup2;</h6>
                      <h6>Pool:</h6>
                      <h6>Balcon:</h6>


                  </div> 
  
</div><!--endof row of result inside tab-->

<hr>



</div><!--end of container for all results rows-->




   </div><!--endof well-->
  </div><!--endof tab pannel-->


<!-- Tab comments -->
  <div role="tabpanel" class="tab-pane " id="Comments">
   <div class="well">

                
                <h1>Comments</h1> 
                

               <div style="max-height:500px; min-width:70px; overflow-y:auto; overflow-x:hidden;"> <!--container for all results rows-->              
   
                <div class="row well">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">

                         <a class="" href="#">
                             <img class="center-block thumb img-circle img-responsive" src="./../../../images/house5.jpg">
                                      <h5><span class="badge">Property ID:xxxx</span></h5>
                         </a>

                    </div>
                    <div class="clearfix visible-xs-block"></div>



                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">


                        <label><img class="img-circle thumbusercomment" src="./../../../images/images.jpg">&nbsp;Feedback from Agent Jack Daniel:</label>
                        <p>Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the parBootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par</p>


                    </div>

                    <!-- Add the extra clearfix for only the required viewport -->
                    <div class="clearfix visible-xs-block"></div>

                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-4">

                                       <br><br><br> 
                                      <div><a href="#ReplyComment" data-toggle="modal"><span class="badge" style=" margin-top: 5px; " ><i class="glyphicon glyphicon-send"></i>&nbsp;Reply</span></a>
                                      <a href="#"><span class="badge" style=" margin-top: 5px; " ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Show property details</span></a>
                                      <a href="#"><span class="badge" style=" margin-top: 5px; " ><i class="glyphicon glyphicon-eye-close"></i>&nbsp;Hide</span></a>
                                      </div>

                    </div>
                </div><!--endof row inside tab-->






              </div><!--end of container for all results rows-->    

   </div>
  </div> 



<!-- Tab my profile -->
  <div role="tabpanel" class="tab-pane " id="Profile">
   <div class="well">

                
                <h1>User Profile<small>&nbsp;&nbsp;&nbsp;&nbsp;User_First&Last_name&nbsp;&nbsp;<img src="https://secure.gravatar.com/avatar/de9b11d0f9c0569ba917393ed5e5b3ab?s=140&r=g&d=mm" class="img-circle thumbuser"></small></h1> 
                 


                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 well">










                        <form action="#UpdateProfile" class="modal-toggle" data-toggle="modal" methode="">

                                    
                                              <div class="input-group" title="firstname">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" name="firstname" id="" type="" placeholder="your first name" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="lastname">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" name="lastname" id="" type="" placeholder="your last name" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="email">
                                                <span class="input-group-addon">@</span>
                                                <input class="form-control" name="email" id="" type="" placeholder="your e-mail" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="Password">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" name="password" id="password" type="password" placeholder="your password" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="phone">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                                <input class="form-control" name="phone" id="" type="" placeholder="your phone number" disabled="disabled">
                                              </div>

          

                                              <div class="input-group" title="addr1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr1" id="" type="" placeholder="your first adresse" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="addr2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr2" id="" type="" placeholder="your seconde adresse" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="zip">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                                <input class="form-control" name="zip" id="" type="" placeholder="your zip code" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="city">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                <input class="form-control" name="city" id="" type="" placeholder="your city name" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="state">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                                                <input class="form-control" name="state" id="" type="" placeholder="your state name" disabled="disabled">
                                              </div>

                                              <div class="input-group" title="image">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                <span class="btn btn-default btn-file"><input type="file" data-filename-placement="inside" name="image" title="Search for a file to add" disabled="disabled"></span>
                                              </div>
                                  
                                          <a href="#UpdateProfile" class="modal-toggle" data-toggle="modal">
                                            <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-wrench"></i> Modify</button>
                                          </a>
                                        
                                    
                                    
                                 </form>                  












                    </div>
                    

                   
                  </div><!--endof row inside tab-->
                    
   </div>
  </div> 



<!-- Tab preferences -->
  <div role="tabpanel" class="tab-pane " id="Preferences">
   <div class="well">

                
                <h1>Preferences</h1> 
                  


                  <div class="row ">
                
                <div class="col-xs-12 col-sm-8 vcenter">

                    <br><br><br><br><br><br><br>

                  <form action="" methode="">

                                    
                                             
                                              <div class="input-group" title="street">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr2" id="" type="" placeholder="Street">
                                              </div>
                         
                                              <div class="input-group" title="zip">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                                <input class="form-control" name="zip" id="" type="" placeholder="Zip code">
                                              </div>


                                              <div class="input-group" title="neighborhood">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
                                                <input class="form-control" name="phone" id="" type="" placeholder="Neighborhood">
                                              </div>

                                              <div class="input-group" title="city">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                <input class="form-control" name="city" id="" type="" placeholder="City">
                                              </div>

                                              <div class="input-group" title="state">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                                                <input class="form-control" name="state" id="" type="" placeholder="State">
                                              </div>

                                              <div class="input-group" title="country">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                                <input class="form-control" name="state" id="" type="" placeholder="Country">
                                              </div>

                                  
                                          <!--button--> <br><br><br><br><br><br>



                </div>

              
              <div class="col-xs-12 col-sm-4 well ">

                 
                  <h5>Balcon:</h5>
               <div class="input-group">
                        
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="balconmin" name="balconmin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="balconmax" name="balconmax" id="" type="">
               </div>  
                  <h5>Pool:</h5>
               <div class="input-group">
                        
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="Poolmin" name="Poolmin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="Poolmax" name="Poolmax" id="" type="">
               </div>
                   <h5>Bath:</h5>
               <div class="input-group">                       
       
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="bathmin" name="bathmin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="bathmax" name="bathmax" id="" type="">

               </div>   

                     <h5>Bed:</h5>
               <div class="input-group">                       
       
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="bedmin" name="bedmin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="bedmax" name="bedmax" id="" type="">

               </div>

                     <h5>Area&nbsp;<div class="badge">m&sup2;</div>:</h5>
               <div class="input-group">                       
       
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="areamin" name="areamin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="areamax" name="areamax" id="" type="">

               </div>

                     <h5>Price&nbsp;<div class="badge">$</div>:</h5>
               <div class="input-group">                       
       
                      <span class="input-group-addon"><div class="badge">min&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></div></span>
                      <input class="form-control" titel="pricemin" name="pricemin" id="" type="">

                      <span class="input-group-addon"><div class="badge">max&nbsp;<i class="glyphicon glyphicon-chevron-up"></i></div></span>
                      <input class="form-control" titel="pricemax" name="pricemax" id="" type="">

               </div>


                               
<br>
                <a href="" class="">
                <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-save"></i>Save Preferences</button>
                </a> 
                </form>
              </div>  

</div>
<!--endof row inside tab-->
                    
   </div>
  </div> <!-- end Tab preferences -->



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
                    <img src="https://secure.gravatar.com/avatar/de9b11d0f9c0569ba917393ed5e5b3ab?s=140&r=g&d=mm" class="img-circle thumbuser">
                    <h4 class="text-left">Jack Daniel</h4>
                    <h6 class="text-left">Adresse: florengasse 36 Fulda 36039 Germany</h6>
                    <h6 class="text-left">Tel:16112014</h6>
                    </div>
                    <form action="" methode="">
                      <div class="input-group" title="comment">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <textarea class="form-control" name="" id=""  placeholder="Bootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the parBootstrap is responsive and since version 3 is now mobile first. ... Bootstrap forces tables to fit the width of the par Bootstrap is responsive and since version" disabled="disabled"></textarea>
                      </div>
                      <div class="input-group" title="commentreply">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <textarea class="form-control" name="answer" id="answer"  placeholder="type your answer to this comment"></textarea>
                      </div>
                    </form>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;submit</button></form>
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for replay  comment-->

<!--Modal for post  comment-->
<div id="PostComment" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-comment"></span>&nbsp;Post Comment</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center"> 
                    <img class="img-circle  thumbuser" src="./../../../images/house4.jpg">
                    <h4 class="text-left">Propertie managed by: </h4>
                    <h6 class="text-left">#Agentid</h6>
                    <h6 class="text-left">Property adresse: florengasse 36 Fulda 36039 Germany</h6>
                    </div>
                    <form action="" methode="">
                      <div class="input-group" title="comment">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <textarea class="form-control" name="answer" id="answer"  placeholder="type your comment"></textarea>
                      </div>
                    </form>
                </div> 
                    
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;submit</button></form>
                </div>
            </div>
        </div>
    </div>
    <!--end of Modal for post  comment-->


    <!--Modal for agent details-->
 <div id="AgentDetails" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Agent Details</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center"> 
                    <img src="https://secure.gravatar.com/avatar/de9b11d0f9c0569ba917393ed5e5b3ab?s=140&r=g&d=mm" class="img-circle thumbuser">
                    <h4 class="text-left"><span class="glyphicon glyphicon-user"></span>&nbsp;Jack Daniel</h4>
                    <h6 class="text-left"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;Adresse: florengasse 36 Fulda 36039 Germany</h6>
                    <h6 class="text-left"><span class="glyphicon glyphicon-earphone"></span>&nbsp;Tel:16112014</h6>
                    <h6 class="text-left"><span class="glyphicon glyphicon-envelope"></span>&nbsp;Mail:abc@gmail.com</h6>
                    <h6 class="text-left"><span class="glyphicon glyphicon-home"></span>&nbsp;Managed properties:16</h6>
                    </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for agent details-->




<!--Modal for agent update profile-->
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
                    </form>
                </div> 
                    
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-default btn-sm pull-right"><i class="glyphicon glyphicon-save"></i> Save</button> </form>
                </div>
            </div>
        </div>
    </div>
<!--end of Modal for agent update profile-->
        
</div>
      <!--Footer-->
        <?php include "./../../../include/footer.html"?>
        <?php include "./../../../include/Modal_header.html"?>


  </body>
</html>
