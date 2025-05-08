$(document).ready(function () {
  $('form').bind("keypress", function(e) {
      if (e.keyCode == 13) {               
        e.preventDefault();
        return false;
      }
  }); 
  $('#otp').on('input', function () {
      $('#otp').val($('#otp').val().toUpperCase());
      checkotp();
      
  });

 
  $("#otpBtn").click(function () {
      
      if (!checkotp()) {
          $("#otp_message").html(`<div class="alert alert-warning">Please fill in the required field</div>`);
          const audio = new Audio("error.mp3");
          audio.play();
      }  else {
          console.log("ok");
          $("#otp_message").html("");
          var form = $('#otpForm')[0];
          var data = new FormData(form);
          $.ajax({
              type: "POST",
              url: "otp_action.php",
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              async: false,
              beforeSend: function () {
                  $('#otpBtn').html('<i class="fa-solid fa-spinner fa-spin"></i> Verifying');
                  $('#otpBtn').attr("disabled", true);
                  
              },
              success: function (data) {
                  $('#otp_message').html(data);
                  
                  
              },
              complete: function () {
                  //$('#otpForm').trigger("reset");
                  setTimeout(function () {
                      $('#otpBtn').html('Verify');
                      $('#otpBtn').attr("disabled", false);
                  }, 1000);
                      
                  
                  
                  
              }
          });
      }
  });
  $("#resendBtn").click(function () {
      console.log("ok");
      $("#otp_message").html("");
      var form = $('#resendForm')[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          url: "resend.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          async: false,
          beforeSend: function () {
              $('#linkBtn').html('<i class="fa-solid fa-spinner fa-spin"></i> Sending');
              $('#linkBtn').attr("disabled", true);
              
          },
          success: function (data) {
              $('#otp_message').html(data);

          },
          complete: function () {
              setTimeout(function () {
                  $('#linkBtn').html('Resend OTP?');
                  $('#linkBtn').attr("disabled", false);
              }, 1000);
              
          }
      });
  });
  

});
//!checkotp() && !checkl_name() && !checkemail() && !checkphone() && !checkfile() && !checkpassword() && !checkconfirm_password()
function checkotp() {
  if ($('#otp').val().length == "") {
      $('#invalid_otp').html('Can not be empty!');
      $('#valid_otp').html('');
      return false;
  } else {
      $('#invalid_otp').html('');
      $('#valid_otp').html('Looks good!');
      return true;
  }
}
