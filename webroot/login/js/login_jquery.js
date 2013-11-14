
$(document).ready(function(){

    $("#saveForm").button();
    
    $("#saveForm").click(function(event){
        var paramsToSend = $("#pie_login_params").serialize();
        //instead of sending this params to the server in the traditional way
        //we use an ajax call to process the reponse of the server
        event.preventDefault();

        $.ajax({
            url:'./src/controllers/verify_login.php',
            type:'POST',
            data:paramsToSend,
            dataType:'json',
            success:function(data, textStatus, XMLHttpRequest){

                if(data){

                    if(data.isValidCaptcha && data.isValidCaptcha==true && data.isValidUser && data.isValidUser == true){


                        $("#pie_main_body").load("./webroot/desktop/desktop.html");
                        
                    }else {
                        
                        //we add the error message
                        $("#login_error_message").html(data.message);
                        $("#login_error_message").addClass("ui-state-error");
                    }

                }else {
                    var fatalErrorMessage = "An error ocurred while processing your request(data is empty)";
                    
                    $("#login_error_message").html(fatalErrorMessage);
                    $("#login_error_message").addClass("ui-state-error");
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){

                var fatalErrorMessage = "an error ocurred while processing your request" + textStatus + " errorThrown:" + errorThrown;

                $("#login_error_message").html(fatalErrorMessage);
                $("#login_error_message").addClass("ui-state-error");
            }
        });
    });
});