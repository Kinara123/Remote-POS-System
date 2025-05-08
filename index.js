$(document).ready(function () {
    $('form').bind("keypress", function(e) {
        if (e.keyCode == 13) {               
          e.preventDefault();
          return false;
        }
    });
    $('#email').on('input', function () {
        checkemail();
        
    });
    $('#password').on('input', function () {
        checkpassword();
        
    });
    $('#phrase').on('input', function () {
        checkphrase();
        
    });
   
    $("#loginBtn").click(function () {
        checkphrase();
        if (!checkemail() && !checkpassword() && !checkphrase()) {
            $("#login_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
            const audio = new Audio("error.mp3");
            audio.play();
        }else if(!checkemail() || !checkpassword() || !checkphrase()){
            $("#login_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
            const audio = new Audio("error.mp3");
            audio.play();
        } else {
            console.log("ok");
            $("#login_message").html("");
            var form = $('#loginForm')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "action.php",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function () {
                    $('#loginBtn').html('<i class="fa-solid fa-spinner fa-spin"></i> Loging In');
                    $('#loginBtn').attr("disabled", true);
                    
                },
                success: function (data) {
                    $('#login_message').html(data);
                    
                    
                },
                complete: function () {
                    setTimeout(function () {
                        $('#loginBtn').html('Login');
                        $('#loginBtn').attr("disabled", false);
                    }, 1000);
                        
                    
                    
                    
                }
            });
        }
    });
    
 
});

function checkemail() {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ($('#email').val().length == "") {
        $('#invalid_email').html('Can not be empty!');
        $('#valid_email').html('');
        return false;
    }else if($.isNumeric($('#email').val())){
        $('#invalid_email').html('');
        $('#valid_email').html('Looks good!');
        return true;
    } else if(!regex.test($('#email').val())){
        $('#invalid_email').html('Invalid email address!');
        $('#valid_email').html('');
        return false;

    }else {
        $('#invalid_email').html('');
        $('#valid_email').html('Looks good!');
        return true;
    }
}
function checkpassword() {
    if ($('#password').val().length == "") {
        $('#invalid_password').html('Can not be empty!');
        $('#valid_password').html('');
        return false;
    } else {
        $('#invalid_password').html('');
        $('#valid_password').html('Looks good!');
        return true;
    }
}
function checkphrase() {
    if ($('#phrase').val().length == "") {
        $('#invalid_phrase').html('Can not be empty!');
        $('#valid_phrase').html('');
        return false;
    } else {
        $('#invalid_phrase').html('');
        $('#valid_phrase').html('');
        return true;        
    }
}
