/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready( function() {
    $('a.deleteUser').click( function( event ) {
     event.preventDefault();
     if( confirm("You are about to delete a user, this procedure is irreversible.\n\nDo you want to proceed?")) {
         var paramArr = {
             action: "deleteUser",
             user_id: $(this).attr("href")
         };
         result = callBackend(paramArr);

    //check result and do stuff

     } else {
         return false;
     }  

    });
});
    
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

  function readCommentsForUser(userID, showOld) {
    var paramArr = {
        action: "readCommentsForUser",
        userID: userID,
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


function callBackend(param) {
    var url = "http://www.sfsuswe.com/~fhahner/include/backend.php";
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



