/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {
 
    
    // Admin Dashboard bind change from sorting dropdown
    $("#sort_role").change( function( event ) {
        showUserList( $("#sort_role").val(), $("#sort_order").val(), $("input:radio[name=ascdesc]:checked").val() );
    });
    $("#sort_order").change( function( event ) {
        showUserList( $("#sort_role").val(), $("#sort_order").val(), $("input:radio[name=ascdesc]:checked").val() );
    });
    
    $("input[name='ascdesc']").change( function( event ) {
        showUserList( $("#sort_role").val(), $("#sort_order").val(), $("input:radio[name=ascdesc]:checked").val() );
    });

    $("#sort_role").change();
  
});


function deleteUser(user_id) {
    event.preventDefault();
    // insert modal box here
    
    if( confirm("You are going to delete a user ("+ user_id+"). Are you sure?") ) 
    {
        var paramArr = {
          action: "deleteUserByID",
          user_id: user_id
        }
 
        var result = callBackend(paramArr);
       
        if (result !== "0") {
            alert("User deleted"+result);
            $("#sort_role").change();
        }
        else
        {
            alert("somethign went wrong!");
        }
    } 
    else
    {
        return fase;
    }
        
}

function enableUser(user_id, enable) {
    event.preventDefault();
    var paramArr = {
       action: "enableUserByID",
       user_id: user_id,
       enable: enable
     }

     var result = callBackend(paramArr);

     if (result !== "0") {
         $("#sort_role").change();;
     }
     else
     {
         alert("somethign went wrong!");
     }
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

function switchCommentHideState(commentID) {
    var paramArr = {
        action: "switchCommentHideState",
        commentID: commentID
        };
        callBackend(paramArr);
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
 
 /*
  * readCommentsForAgent()
  * @param userID -> (int) ID of logged on agent
  * @param showOld -> (int) hide already red comments
  */



