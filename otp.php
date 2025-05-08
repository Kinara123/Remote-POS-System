<?php
session_start();
include_once 'config.php';
if (isset($_SESSION['otp_id'])) {
  $otp_id = $_SESSION['otp_id'];
  $email = $_SESSION['email'];
} else {
  $otp_id = '';
  header("Location: ./");
  exit();
}

?>
<?php include_once 'includes/header.php'; ?>
<section class="vh-100 ">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 mb-5">
        <div class="card bg-light text-dark" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <?php if (isset($_SESSION['message'])): ?>
              <div style="text-align:center; font-size:16px;">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
              </div>
            <?php endif ?>

            <div class="mb-md-2 mt-md-4 pb-5">

              <h2 class="text-dark-50 mb-3 font-weight-bold">OTP Verification</h2>
              <span id="otp_message"></span>
              <form action="" method="POST" role="form" id="resendForm" enctype="multipart/form-data">
                <input type="hidden" name="otp_id" value="<?php echo $otp_id; ?>" />
                <input type="hidden" name="email" value="<?php echo $email; ?>" />
              </form>
              <form action="" method="POST" role="form" id="otpForm" enctype="multipart/form-data">
                <div class="text-left ">
                  <label class="form-label font-weight-bold " for="otp">OTP Verification Code</label>
                  <div class="input-group mb-3">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" id="otp" name="otp" class="form-control form-control-lg" placeholder="Enter OTP code" />
                  </div>
                  <div class="valid_message" id="valid_otp">
                  </div>
                  <div class="invalid_message" id="invalid_otp">
                  </div>
                </div>
                <p class="small mb-3 pb-lg-2 text-right" id="resendBtn"><a href="javaScript:void(0)" id="linkBtn" class="text-primary font-weight-bold">Resend OTP?</a></p>
                <button class="btn btn-outline-primary btn-lg px-5 btn-block rounded-pill " type="button" id="otpBtn">Verify</button>

              </form>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="otp.js"></script>
<?php include_once 'includes/footer.php'; ?>