$(function()
{
	// Variable to store your files
	var files;

	// Add events (for sign_up form)
	$(" #image_name").on('change', prepareUpload);
	$(" #signup_upload_picture_btn").click(uploadFiles);
        $(" #profile_upload_picture_btn").click(uploadFiles);
        

	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
		files = event.target.files;
	}

	// Catch the form submit and upload the files
	function uploadFiles(event)	{
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            $(" #signup_user_image").attr('src', "../images/loading.gif");
            $(" #profile_user_image").attr('src', "../../../images/loading.gif"); // START A LOADING SPINNER HERE

                                    // Create a formdata object and add the files
            var data = new FormData();
	
            $.each(files, function(key, value)
            {
                data.append(key, value);
            });
            var str = $(location).attr('href');
            var res = str.split("/");
            // res[2] = www.sfsuswe.com
            // res[3] = ~fhahner
            var url = "/" + res[3] + "/include/upload_user_picture.php?files"; 
        
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'html',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(response)
                {
                    console.log("returned image id is" + response)
                    $(" #signup_image_id").val(response);
                    $(" #signup_user_image").attr('src', "../images/" + response + "_SMALL.jpg");
                    $(" #profile_user_image").attr('src', "../../../images/" + response + "_SMALL.jpg");
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    // STOP LOADING SPINNER
                }
            });
        }
});