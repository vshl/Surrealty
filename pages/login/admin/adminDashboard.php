<?php
include ('../../../pathMaker.php');
require_once($path.'/include/checkUser.php');
checkUserRoleAndRedirect(array('ADMIN'), "../../home.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Admin Dashboard</title>

    <!-- Bootstrap core CSS -->


<link href="../../../frameworks/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<!-- <link href="../../../frameworks/bootstrap/dist/bootstrap.min.css" rel="stylesheet"> -->
<link href="../../../frameworks/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
<!--<link href="bootstrap-3.3.0/js/jquery-ui-1.9.2.custom.css" rel="stylesheet">-->

<script src="../../../javascripts/jquery-2.1.1.js"></script>
<script src="../../../javascripts/ajax.js"></script>
<!-- <script src="../../../frameworks/bootstrap/dist/js/bootstrap.js"></script> -->
<script src="../../../frameworks/bootstrap/dist/js/bootstrap.js"></script>
<script src="../../../frameworks/bootstrap/dist/js/npm.js"></script>
<script src="../../../javascripts/jquery.toaster.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->

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

  <li role="presentation" class="active"><a href="#Users" role="tab" data-toggle="tab" id="manageUserTab"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Manage Users</a></li>
  <li role="presentation"><a href="#Property" role="tab" data-toggle="tab" id="approvePropertiesTab"><i class="glyphicon glyphicon-home"></i>&nbsp;Approve Property</a></li>
  <li role="presentation"><a href="#Profile" role="tab" data-toggle="tab" id="profileTab"><i class="glyphicon glyphicon-user"></i>&nbsp;Profile</a></li>
</ul>
 

<div class="tab-content">
<!-- Tab user -->
  <div role="tabpanel" class="tab-pane active" id="Users">
   <div class="well">

                <div class="page-header">
                <h1>Users administration</h1> 
                </div>
                                         <form class="form-inline" role="form" action="">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <span class="badge">Sort by user typ:&nbsp;</span>
                                                  <select class="select" value="" name="sort_role" id="user_sort_role">
                                                     <option value="admin">Admin</option>
                                                     <option value="agent">Agent</option>
                                                     <option value="buyer">Buyer</option>
                                                     <option value="all" selected>All</option>
                                                  </select>&nbsp;&nbsp;
                                                  <span class="badge">Sort by:&nbsp;</span>
                                                  <select class="select" value="" name="sort_order" id="user_sort_order">
                                                     <option value="creation_date">Creation_date</option>
                                                     <option value="modification_date">Modification_date</option>
                                                      <option value="role">Role</option>
                                                     <option value="zipcode">Zip Code</option>
                                                     <option value="lname" selected>Lastname</option>
                                                     <option value="email">Email</option>
                                                  </select>
                                                  <div class="btn-group btn-toggle btn-group-xs" data-toggle="buttons">
                                                        <label class="btn btn-default active">
                                                          <input type="radio" name="user_ascdesc" value="asc"  checked="checked">
                                                          <span class="glyphicon glyphicon-sort-by-attributes"></span>
                                                        </label>
                                                        <label class="btn btn-default ">
                                                          <input type="radio" name="user_ascdesc" value="desc">
                                                          <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
                                                        </label>
                                                  </div>&nbsp;&nbsp;
<!--                                                  <input type="text" placeholder="search term" name="srch-term" id="">-->
                                                  &nbsp;&nbsp;<button type="submit" class="btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>
                                              </div>
                                            </div>
                                         </form>
                                          <hr>
<div class="" style="max-height:500px; min-width:70px; overflow-y:auto; overflow-x:hidden;" id="userlist"> 
    <!--container for all results rows-->              
<!--a row of result inside tab-->
        
</div><!--end of container for all results rows-->




   </div><!--endof well-->
  </div><!--endof tab pannel-->


<!-- Tab Property -->
  <div role="tabpanel" class="tab-pane " id="Property">
   <div class="well">

                <div class="page-header">
                <h1>Property administration</h1> 
                </div>

                <form class="form-inline" role="form" action="">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <span class="badge">Sort by:&nbsp;</span>
                                                  <select class="select" name="sort_order" id="property_sort_order">
                                                     <option value="creation_date" selected>Creation_date</option>
                                                     <option value="modification_date">Modification_date</option>
                                                     <option value="price">Price</option>
                                                     <option value="city">City</option>
                                                     <option value="status">Status</option>
                                                     <option value="area">Area</option>
                                                  </select>                                                    
                                                  <div class="btn-group btn-toggle btn-group-xs" data-toggle="buttons">
                                                        <label class="btn btn-default active">
                                                          <input type="radio" name="property_ascdesc" value="asc">
                                                          <span class="glyphicon glyphicon-sort-by-attributes"></span>
                                                        </label>
                                                        <label class="btn btn-default ">
                                                          <input type="radio" name="property_ascdesc" value="desc" checked="checked">
                                                          <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
                                                        </label>
                                                  </div>
                                                    
                                                    &nbsp;&nbsp;<button type="submit" class="btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>
                                              </div>
                                            </div>
                                         </form>
                                          <hr>

              <div style="max-height:500px; min-width:70px; overflow-y:auto; overflow-x:hidden;" id="unproven_properties"> <!--container for all results rows-->              
   


               





              </div><!--end of container for all results rows-->    

   </div>
  </div> 



<!-- Tab my profile -->
  <div role="tabpanel" class="tab-pane " id="Profile">
   <div class="well">

                <div class="page-header">
                <h1>Admin Profile<small>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?>&nbsp;&nbsp;<img id="user_avatar" src="../../../images/loading.gif" class="img-circle thumbuser"></small></h1> 
                </div>   


                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 well" id="myprofile">









<!--
                        <form action="" methode="">

                                    
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
                                                <input class="form-control" name="password" id="password" type="password" placeholder="Password is hidden" disabled="disabled">
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



-->








                    </div>
                    

                   
                  </div><!--endof row inside tab-->
                    
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
                    <img src="https://secure.gravatar.com/avatar/de9b11d0f9c0569ba917393ed5e5b3ab?s=140&r=g&d=mm" class="img-circle thumbuser">
                    
                    
                    <h4 class="text-left">MAX Mustermann</h4>
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
                    
                </div> 
                    
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>&nbsp;submit</button></form>
                </div>
            </div>
        </div>
    </div>

<!--end of Modal for replay  comment-->





<!--Modal for user update profile-->
<!--
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
                                                <input class="form-control" name="firstname" id="edit_firstname" type="" placeholder="your first name2">
                                              </div>

                                              <div class="input-group" title="lastname">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" name="lastname" id="edit_lastname" type="" placeholder="your last name">
                                              </div>

                                              <div class="input-group" title="email">
                                                <span class="input-group-addon">@</span>
                                                <input class="form-control" name="email" id="edit_email" type="" placeholder="your e-mail">
                                              </div>

                                              <div class="input-group" title="Password">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" name="password" id="edit_password" type="password" placeholder="Password unchanged">
                                              </div>

                                              <div class="input-group" title="phone">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                                <input class="form-control" name="phone" id="edit_phone" type="" placeholder="your phone number">
                                              </div>

          

                                              <div class="input-group" title="addr1">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr1" id="edit_address1" type="" placeholder="your first adresse">
                                              </div>

                                              <div class="input-group" title="addr2">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                                <input class="form-control" name="addr2" id="edit_address2" type="" placeholder="your seconde adresse">
                                              </div>

                                              <div class="input-group" title="zip">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                                <input class="form-control" name="zip" id="" type="" placeholder="your zip code">
                                              </div>

                                              <div class="input-group" title="city">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                                <input class="form-control" name="city" id="edit_city" type="" placeholder="your city name">
                                              </div>

                                              <div class="input-group" title="state">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                                                <input class="form-control" name="state" id="edit_state" type="" placeholder="your state name">
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
    </div> -->
<!--end of Modal for user update profile-->

<?php
//echo dir(__FILE__);
//echo'<pre>';
//echo "Session Dump";
//var_dump($_SESSION);
//echo '</pre>'
?>








</div>
<!--Footer-->
        <?php include "./../../../include/footer.html"?>
        <?php include "./../../../include/Modal_header.html"?>


  </body>
</html>
