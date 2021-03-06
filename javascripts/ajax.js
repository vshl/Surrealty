/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {

    $("#user_sort_role").change( function() {
        showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
    });

    $("#user_sort_order").change( function() {
        showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
    });

    $("input[name='user_ascdesc']").change( function() {
        showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
    });
    
    $("#property_sort_order").change( function () {
        showUnprovenProperties( $("#property_sort_order").val(), $("input:radio[name=property_ascdesc]:checked").val());
    });
    
    $("input[name='property_ascdesc']").change( function() {
        showUnprovenProperties( $("#property_sort_order").val(), $("input:radio[name=property_ascdesc]:checked").val() );
    });

    $("#resetpwd").submit( function() {
        sentResetCode( $("#email_resetpwd").val() );
    });
        
    $("#approvePropertiesTab").click( function() {
        $("#property_sort_order").change();
    });
        
    $("#manageUserTab").click( function() {
        $("#user_sort_role").change();
    });

    $("#approvePropertiesTab").click( function() {
        $("#property_sort_order").change();      
    });
    
    $("#profileTab").click( function() {
        fillProfile();
    });
        
    // for the first call of the dasgboard load the usertab
    showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
});


function addAProperty(event) {
    event.preventDefault();
    
    var title           = $( "#p_title").val();
    var address1        = $("#p_addr1").val();
    var address2        = $ ("#p_addr2").val();
    var zipcode         = $("#p_zip").val();
    var neighborhood    = $("#p_neighborhood").val();
    var city            = $ ("#p_city").val();
    var state           = $("#p_state").val();
    var country           = $("#p_country").val();
    var description     = $ ("#p_description").val();
    var balcon          = $("#p_balcon").val();
    var pool            = $ ("#p_pool").val();
    var bath            = $("#p_bath").val();
    var bed             = $("#p_bed").val();
    var area            = $ ("#p_area").val();
    var price           = $("#p_price").val();
    var image           = $("#property_image_id").val();
 
    var paramArr = {
            action: "addAProperty",
            title: title,
            address1: address1,
            address2: address2,
            zipcode: zipcode,
            neighborhood: neighborhood,
            city: city,
            state: state,
            country: country,
            description: description,
            balcon: balcon,
            pool: pool,
            bath: bath,
            bed: bed,
            area: area,
            price: price,
            image: image
            
    };
    
    var result = callBackend(paramArr);
    
    if (result != "0") {
      //  $("#addPropertyFrom").trigger("reset");
        $.toaster({ priority : 'success', title : 'Agent Dashboard', message : 'Property successfully added' });
    }
    else
    {
       $.toaster({ priority : 'warning', title : 'Agent Dashboard', message : result });
    }
    
    return true;
}

function sentResetCode( email ) {
 
    var paramArr = {
        action: "sentResetCode",
        email: email 
    };

    callBackend(paramArr);
    
    // results will be evaluated via $_SESSION['resetCode'] in the home.php file.
}

function fillProfile() {
    var paramArr = {
      action: "loadUserInformation"
    };
       
   callAsyncBackend(paramArr, "myprofile");
   
}

function updateUserProfile() {
    
    var fname = $( "#edit_firstname").val();
    var lname = $ ("#edit_lastname").val();
    var email = $("#edit_email").val();
    var password = $ ("#edit_password").val();
    var phone = $("#edit_phone").val();
    var image_name = $ ("#signup_image_id").val();
    var address1 = $("#edit_address1").val();
    var address2 = $ ("#edit_address2").val();
    var zipcode = $("#edit_zipcode").val();
    var city = $ ("#edit_city").val();
    var state = $("#edit_state").val();

 
    var paramArr = {
            action: "updateUserProfile",
            fname: fname,
            lname: lname,
            email: email,
            password: password,
            phone: phone,
            image_name: image_name,
            address1: address1,
            address2: address2,
            zipcode: zipcode,
            city: city,
            state: state
            
    };

    
    var result = callBackend(paramArr);

    if (result !== "0") {
        $.toaster({ priority : 'success', title : 'Profile update', message : 'Your profile has been successfully updated' });
        fillProfile();
    }
    else
    {
       $.toaster({ priority : 'warning', title : 'Profile update', message : result });
    }
    
    return true;

}



function approvePropertyByID(propertyID) {
    //event.preventDefault();
    var paramArr = {
      action: "approvePropertyByID",
      propertyID: propertyID
    };
       
    var result = callBackend(paramArr);

    if (result !== "0") {
        $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'Property successfully approved' });
        $("#property_sort_order").change();
    }
    else
    {
       $.toaster({ priority : 'warning', title : 'Administrator Dashboard', message : result });
    }
}

function deletePropertyByID(propertyID) {
    //event.preventDefault();
    var paramArr = {
      action: "deletePropertyByID",
      propertyID: propertyID
    };
       
    var result = callBackend(paramArr);
  
    if (result !== "0") {
        $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'Property successfully deleted' });
        $("#property_sort_order").change();
    }
    else
    {
        $.toaster({ priority : 'warning', title : 'Administrator Dashboard', message : result })
    }
}

function deleteUserByID(userID, role) {
    //event.preventDefault();
    
     if( confirm("You are going to delete a "+role+" ("+ userID+"). Are you sure?") ) 
    {
        var paramArr = {
          action: "deleteUserByID",
          userID: userID,
          role: role
        }
 
       var result = callBackend(paramArr);

        if (result !== "0") {
            $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'User successfully deleted' });
            $("#user_sort_order").change();
        }
        else
        {
            $.toaster({ priority : 'warning', title : 'Administrator Dashboard', message : result })
        }
    } 
    else
    {
        return false;
    }
    
}

function enableUser(userID, role, enable) {
    //event.preventDefault();
    var paramArr = {
       action: "enableUserByID",
       userID: userID,
       role: role,
       enable: enable
     };

     var result = callBackend(paramArr);

     if (result !== "0") {
        $("#user_sort_order").change();
        if(enable) {
            $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'User successfully enabled' });
        } else {
            $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'User successfully disabled' });
        }
    }
     else
     {
        $.toaster({ priority : 'warning', title : 'Administrator Dashboard', message : result })
     }
}

function showUnprovenProperties( order, ascdesc) {
    
    var paramArr = {
        action: "showUnprovenProperties",
        order: order,
        ascdesc: ascdesc 
    };

    callAsyncBackend(paramArr, "unproven_properties");
}


function showUserList( role, order, ascdesc) {
    var paramArr = {
        action: "showUserlist",
        role: role,
        order: order,
        ascdesc: ascdesc 
    }
     callAsyncBackend(paramArr, "userlist");
}
    
function loginAndRedirect() {
        var email = $( "#email").val();
        var password = $ ("#password").val();
        var paramArr = {
            action: "loginAndRedirect",
            email: email,
            password: password
        };
        result = callBackend(paramArr);
        if (result !== "0") {
            window.location.replace(result);
        }
        else
        {
            $(" #login_incorrect").text("User not found");
            setTimeout(function() {
               $(" #login_incorrect").text("");
            }, 1500);
        }
    }

function RegisterAndRedirect() {
        
        var $Form = $('#registrationForm');
      if ($Form[0].checkValidity()) {
        var fname = $( "#fname").val();
        var lname = $ ("#lname").val();
        var email = $("#email1").val();
        var password = $ ("#password1").val();
        var phone = $("#phone").val();
        var image_name = $ ("#signup_image_id").val();
        var address1 = $("#address1").val();
        var address2 = $ ("#address2").val();
        var zipcode = $("#zipcode").val();
        var city = $ ("#city").val();
        var state = $("#state").val();
        var country = $ ("#country").val();
        
        
        
        var paramArr = {
            action: "RegisterAndRedirect",
            fname: fname,
            lname: lname,
            email: email,
            password: password,
            phone: phone,
            image_name: image_name,
            address1: address1,
            address2: address2,
            zipcode: zipcode,
            city: city,
            state: state,
            country: country
            
        };
        
        result = callBackend(paramArr);
        }
        
    }
    
function readCommentsForUser() {
    if ($( "#chkbox_show_seen_comments").is(':checked')) {
        showOld = 1;
    }
    else {
        showOld = 0;
    }
    
    var paramArr = {
        action: "readCommentsForUser",
        showOld: showOld
    };
    var result = callBackend(paramArr);
    if (result !== "0") {
        $(" #comment_container").html(result);
    }
    else {
        $(" #comment_container").text("Error loading comments!");
    }
} 

function giveUnseenCommentsByAgentID() {
    var paramArr = {
        action: "giveUnseenCommentsByAgentID"
        };
    var result = callBackend(paramArr);
    if (result == 0) {
        $(" #tab_count_unseen_comments").hide();
    }
    else {
        $(" #tab_count_unseen_comments").text(result);
    }
}

function giveCountOfUnreadRepliesForBuyer() {
    var paramArr = {
        action: "giveCountOfUnreadRepliesForBuyer",
        };
    var result = callBackend(paramArr);
    if (result == 0) {
        $(" #tab_count_unseen_comments").hide();
    }
    else {
        $(" #tab_count_unseen_comments").text(result);
    }
}


function  loadAllCommentsByProperty(propertyID) {
    var paramArr = {
        action: "readPublicCommentsForProperty",
        propertyID: propertyID
        };
    var result = callBackend(paramArr);
    $( "#prop_comment_container").html(result);
}

function sellProperty() {
    var sellerName = $(" #inputName").val();
    var sellerPhone = $(" #inputPhone").val();
    var sellerMail = $(" #inputEmail").val();
    var sellerMessage = $(" #inputMessage").val();
        
    var message = "Hello \n " + sellerName + " wants to sell a property. He/She leaves to following message: " + sellerMessage + "\n Please contact under: \n " + sellerPhone + "\n" + sellerMail;
    var paramArr = {
        action: "sellProperty",
        message: message
        };
    result = callBackend(paramArr);
    $.toaster({ priority : 'success', title : 'Notification ', message : 'Request sent. Agent will conact you soon.'  });
}



function returnAnswerToComment(commentID) {
    var answerText = $(" #reply_answer").val();
    var paramArr = {
        action: "returnAnswerToComment",
        answerText: answerText,
        commentID: commentID
        };
    result = callBackend(paramArr);
    if (result == 1) {
        $.toaster({ priority : 'success', title : 'Comment System', message : 'Reply successfully transmitted' });
    }
    else {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result });
    }
    readCommentsForUser();  
}

function readCommentReply(commentID) {
    var paramArr = {
        action: "readCommentReply",
        commentID: commentID
        };
    result = callBackend(paramArr);
    if (result == 1) {
        $.toaster({ priority : 'success', title : 'Comment System', message : 'Reply acknowledged' });
    }
    else {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result });
    }
    giveCountOfUnreadRepliesForBuyer();
    readCommentsForUser();
    
}

function returnModfiedComment(commentID) {
    var commentText = $(" #modify_comment").val();
    var paramArr = {
        action: "returnModifyToComment",
        commentText: commentText,
        commentID: commentID
        };
    result = callBackend(paramArr);
    if (result == 1) {
        $.toaster({ priority : 'success', title : 'Comment System', message : 'Modification successfully transmitted' });
    }
    else {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result });
    }
    readCommentsForUser();
    
}


    
function removeComment(commentID) {
    if( confirm("You are going to delete a comment. Are you sure?") ) 
    {
        var paramArr = {
            action: "removeComment",
            commentID: commentID
            };
        result = callBackend(paramArr);
        if (result == 1) {
            $.toaster({ priority : 'success', title : 'Comment System', message : 'Comment successfully removed' });
        }
        else {
            $.toaster({ priority : 'warning', title : 'Comment System', message : result });
        }
        readCommentsForUser();
        giveUnseenCommentsBy
    }
}


function switchCommentHideState(commentID) {
    var paramArr = {
        action: "switchCommentHideState",
        commentID: commentID
        };
        result =callBackend(paramArr);
        $.toaster({ priority : 'success', title : 'Comment System', message : 'Comment Hide state change'});
        readCommentsForUser();
}

function switchCommentPublicState(commentID) {
    var paramArr = {
        action: "switchCommentPublicState",
        commentID: commentID
        };
        callBackend(paramArr);
        readCommentsForUser();
 }

function createComment(listingID) {
    var comment = $(" #comment_message").val();
    var paramArr = {
         action: "createCommentByListingID",
         listingID: listingID,
         comment: comment
        };
    result = callBackend(paramArr);
   
    if (result == 1) {
        $.toaster({ priority : 'success', title : 'Comment System', message : 'Comment successfully created' });
    }
    else {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result });
    }
 //   $.toaster({ priority : 'success', title : 'Comment System', message : result});
 
    
 }

function callBackend(param) {
        
    // here we will split string to get path names
    // f.hahner 29Nov2014
    var str = $(location).attr('href');
    var res = str.split("/");
    // res[2] = www.sfsuswe.com
    // res[3] = ~fhahner
    var url = "/" + res[3] + "/include/backend.php";    
    $.ajax( {
        url: url,
        type: "post",
        data: param,
        dataType: "html",
          async: false,
          timeout: 150000,
          /*
            beforeSend: function() {
            $("#dashboard_content").html('<img src="../images/loading.gif" width=300px height=300px>').show();
           },
           */
          success: function( response ) {
              //$("#dashboard_content").html(response);
              data = response;
             },
          error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(ajaxOptions);
                alert(thrownError);
            } 
          
        });
    return data;
 };
 
 
 
 function callAsyncBackend(paramArr, target) {
    var str = $(location).attr('href');
    var res = str.split("/");
    var url = "/" + res[3] + "/include/backend.php";    
    $.ajax( {
        url: url,
        type: "post",
        data: paramArr,
        dataType: "html",
        async: true,
        timeout: 150000,
        success: function( response ) {
            $("#"+target).html(response);
        }
 
    });
 };
 
 function transferCommentDataToReplyModal(commentID) {
     // Copy Username
     $(" #reply_name").text($(" #comment_" + commentID + "_username").text());
     // Copy Picutre Source Information
     //alert($(" #comment_" + commentID + "_userimage").attr('src'));
     $(" #reply_image").attr('src', $(" #comment_" + commentID + "_userimage").attr('src'));
     // Copy comment text string
     $(" #reply_comment").text($(" #comment_" + commentID + "_comment").text());
     // Copy answer text string
     if (!$(" #comment_" + commentID + "_answer").text() == "") {
         $(" #reply_answer").text($(" #comment_" + commentID + "_answer").text());
     }
     // Copy address and phone text string
     $(" #reply_address").text($(" #comment_" + commentID + "_address").text());
     $(" #reply_phone").text($(" #comment_" + commentID + "_phone").text());
     $(" #reply_submit_btn").attr('onClick', "returnAnswerToComment(" + commentID + ") ");
 }
 
  function transferCommentDataToModifyModal(commentID) {
     // Copy Username
     //$(" #reply_name").text($(" #comment_" + commentID + "_username").text());
     // Copy Picutre Source Information
     //alert($(" #comment_" + commentID + "_userimage").attr('src'));
     $(" #property_image").attr('src', $(" #comment_" + commentID + "_propertyimage").attr('src'));
     // Copy comment text string
     $(" #modify_comment").text($(" #comment_" + commentID + "_comment").text());
     // Copy answer text string
     //if (!$(" #comment_" + commentID + "_answer").text() == "") {
     //    $(" #reply_answer").text($(" #comment_" + commentID + "_answer").text());
    // }
     // Copy address and phone text string
     //$(" #reply_address").text($(" #comment_" + commentID + "_address").text());
     //$(" #reply_phone").text($(" #comment_" + commentID + "_phone").text());
     $(" #modify_submit_btn").attr('onClick', "returnModfiedComment(" + commentID + ") ");
 }
 
 /*
  * readCommentsForAgent()
  * @param userID -> (int) ID of logged on agent
  * @param showOld -> (int) hide already red comments
  */
 
 function contactAgent(propId) {
    event.preventDefault();
    var $Form = $('#contactform');
    if ($Form[0].checkValidity()) {
    var propId = propId;
    var mailto = $(" #emailTo").val();
    var userName = $(" #inputName").val();
    var userPhone = $(" #inputPhone").val();
    var userMail = $(" #inputEmail").val();
    var message = $(" #inputMessage").val();
    var mailHeader = "Mail from : " + userName + " <" + userMail + ">\n" + "Tel:" + userPhone;
    var subject = userName + " contact you for the Property: " + propId;
    var paramArr = {
       action: "contactAgent",
       mailHeader: mailHeader ,
       subject: subject ,
       message: message ,
       mailto: mailto   
     };

     var result = callBackend(paramArr);

     if (result !== "0") {
        $.toaster({ priority : 'success', title : 'mail sent', message : 'mail to ' + mailto + 'was successfully sent' })
    }
     else
     {
        $.toaster({ priority : 'warning', title : 'mail not sent', message : 'send failed' })
     }
     
     }
}