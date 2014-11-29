/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {
 
    // Admin Dashboard bind delete button
    $("#deleteUser").click( function (){
       alert("test") ; // not working atm
    });
    
    
    // Admin Dashboard bind change from sorting dropdown
    $("#sort_role").change( function( event ) {
        $("#userlist").text("Loading...");
        showUserList( $(this).val());
    });
    
    $("#sort_role").change();
    
    
});


function showUserList(order) {
    var paramArr = {
        action: "showUserlist",
        order: order
    }
    $("#userlist").text("LOADING");
    var result = callBackend(paramArr);

    if (result !== "0") {
        $("#userlist").html(result);
    }
    else {
        $("#userlist").text("Error loading userlist!");
    }
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
 /*
  * readCommentsForAgent()
  * @param userID -> (int) ID of logged on agent
  * @param showOld -> (int) hide already red comments
  */



