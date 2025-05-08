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
  
 
  $("#forgotBtn").click(function () {
      
      if (!checkemail()) {
          $("#forgot_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
          const audio = new Audio("error.mp3");
          audio.play();
      } else {
          console.log("ok");
          $("#forgot_message").html("");
          var form = $('#forgotForm')[0];
          var data = new FormData(form);
          $.ajax({
              type: "POST",
              url: "forgot_action.php",
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              async: false,
              beforeSend: function () {
                  $('#forgotBtn').html('<i class="fa-solid fa-spinner fa-spin"></i> Submiting');
                  $('#forgotBtn').attr("disabled", true);
                  
              },
              success: function (data) {
                  $('#forgot_message').html(data);
                  
              },
              complete: function () {
                  
                  setTimeout(function () {
                      
                      $('#forgotBtn').html('Submit');
                      $('#forgotBtn').attr("disabled", false);
                      
                  }, 1000);
                      
                  
                  
                  
              }
          });
      }
  });
  
  $('#password').on('input', function () {
      checkpassword();
      
  });
  $('#confirm_password').on('input', function () {
      checkconfirm_password();
      
  });
 
  $("#resetBtn").click(function () {
      
      if (!checkpassword() && !checkconfirm_password()) {
          $("#reset_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
          const audio = new Audio("error.mp3");
          audio.play();
      }else if(!checkpassword() || !checkconfirm_password()){
          $("#reset_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
          const audio = new Audio("error.mp3");
          audio.play();
      } else {
          console.log("ok");
          $("#reset_message").html("");
          var form = $('#resetForm')[0];
          var data = new FormData(form);
          $.ajax({
              type: "POST",
              url: "reset.php",
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              async: false,
              beforeSend: function () {
                  $('#resetBtn').html('<i class="fa-solid fa-spinner fa-spin"></i> Reseting');
                  $('#resetBtn').attr("disabled", true);
                  
              },
              success: function (data) {
                  $('#reset_message').html(data);
                  
                  
              },
              complete: function () {
                  //$('#resetForm').trigger("reset");
                  setTimeout(function () {
                      //$('#reset_message').html(data);
                      $('#resetBtn').html('Reset');
                      $('#resetBtn').attr("disabled", false);
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
  var number = /([0-9])/;
var alphabets = /([a-zA-Z])/;
var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
var password = $('#password').val().trim();
if (password.length < 8) {
  $('#invalid_password').html('Password should be atleast 8 characters!');
      $('#valid_password').html('');
      return false;
} else if (password.match(number) && password.match(alphabets) && password.match(special_characters)){
      $('#invalid_password').html('');
      $('#valid_password').html('Looks good!');
      return true;
  
}else{
      $('#invalid_password').html('Password must contain UPPERCASE, NUMBER and SPECIAL CHARS!');
      $('#valid_password').html('');
      return false;

  }
  
}
function checkconfirm_password() {
  var pswd = $('#password').val();
  if ($('#confirm_password').val().length == "") {
      $('#invalid_confirm_password').html('Can not be empty!');
      $('#valid_confirm_password').html('');
      return false;
  } else if($('#confirm_password').val() != pswd){
      $('#invalid_confirm_password').html('Password does not match!');
      $('#valid_confirm_password').html('');
      return false;
  }else {
      $('#invalid_confirm_password').html('');
      $('#valid_confirm_password').html('Looks good!');
      return true;
  }
}

