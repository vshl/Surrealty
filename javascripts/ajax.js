/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {
 
    $("#manageUserTab").click( function() {    
        $("#user_sort_role").change( function() {
            showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
        });
        
        $("#user_sort_order").change( function() {
            showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
        });

        $("input[name='user_ascdesc']").change( function() {
            showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
        });
        
        $("#user_sort_role").change();
        
    });
    
    // Admin Dashboard bind change from sorting dropdown
    
    $("#approvePropertiesTab").click( function() {
        
        $("#property_sort_order").change( function () {
            showUnprovenProperties( $("#property_sort_order").val(), $("input:radio[name=property_ascdesc]:checked").val());
        });
   
        $("input[name='property_ascdesc']").change( function() {
             showUnprovenProperties( $("#property_sort_order").val(), $("input:radio[name=property_ascdesc]:checked").val() );
             $("#property_sort_order").change();
        });
        
        $("#property_sort_order").change();      
    });
    
    
    $("#profileTab").click( function() {
        fillProfile();
    });
    
    showUserList( $("#user_sort_role").val(), $("#user_sort_order").val(), $("input:radio[name=user_ascdesc]:checked").val() );
});

function fillProfile() {
    var paramArr = {
      action: "loadUserInformation"
    }
       
   callAsyncBackend(paramArr, "myprofile");
}

function approvePropertyByID(propertyID) {
    event.preventDefault();
    var paramArr = {
      action: "approvePropertyByID",
      propertyID: propertyID
    }
       
    var result = callBackend(paramArr);

    if (result !== "0") {
        $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'Property successfully approved' });
        $("#property_sort_order").change();
    }
    else
    {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result })
    }
}

function deletePropertyByID(propertyID) {
    event.preventDefault();
    var paramArr = {
      action: "deletePropertyByID",
      propertyID: propertyID
    }
       
    var result = callBackend(paramArr);
  
    if (result !== "0") {
        $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'Property successfully deleted' });
        $("#property_sort_order").change();
    }
    else
    {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result })
    }
}

function deleteUserByID(userID, role) {
    event.preventDefault();
    // insert modal box here
    
    if( confirm("You are going to delete a "+role+" ("+ userID+"). Are you sure?") ) 
    {
        var paramArr = {
          action: "deleteUserByID",
          userID: userID,
          role: role
        }
 
       var result = callBackend(paramArr);
   //    alert(result);
        if (result !== "0") {
            $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'User successfully deleted' });
            $("#sort_role").change();
        }
        else
        {
             $.toaster({ priority : 'warning', title : 'Administrator Dashboard', message : result })
        }
    } 
    else
    {
        return fase;
    }
        
}

function enableUser(userID, role, enable) {
    event.preventDefault();
    var paramArr = {
       action: "enableUserByID",
       userID: userID,
       role: role,
       enable: enable
     }

     var result = callBackend(paramArr);

     if (result !== "0") {
        $("#sort_role").change();;
        $.toaster({ priority : 'success', title : 'Administrator Dashboard', message : 'User successfully enabled/disabled' });
     }
     else
     {
        $.toaster({ priority : 'warning', title : 'Comment System', message : result })
     }
}

function showUnprovenProperties( order, ascdesc) {
    var paramArr = {
        action: "showUnprovenProperties",
        order: order,
        ascdesc: ascdesc 
    }
 
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

function giveUnseenCommentsByUserID(userID) {
    var paramArr = {
        action: "giveUnseenCommentsByID",
        userID: userID
        };
    var result = callBackend(paramArr);
    if (result == 0) {
        $(" #tab_count_unseen_comments").hide();
    }
    else {
        $(" #tab_count_unseen_comments").text(result);
    }
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
 
 /*
  * readCommentsForAgent()
  * @param userID -> (int) ID of logged on agent
  * @param showOld -> (int) hide already red comments
  */



