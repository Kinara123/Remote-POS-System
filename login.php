<?php
session_start();
require_once 'vendor/autoload.php';

use SimpleCaptcha\Builder;

include_once 'config.php';
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

                                <h2 class="text-dark-50 mb-3 font-weight-bold">Login</h2>
                                <span id="login_message"></span>
                                <form action="" method="POST" role="form" id="loginForm" enctype="multipart/form-data">
                                    <div class="text-left">
                                        <label class="form-label font-weight-bold" for="role">Select role</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            </div>
                                            <select name="role" id="role" class="form-control form-control-lg" required>
                                                <option value="1">Admin</option>
                                                <option value="2">Manager</option>
                                                <option value="3">Cashier</option>
                                            </select>
                                            <div class="valid_message" id="valid_role"></div>
                                            <div class="invalid_message" id="invalid_role"></div>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <label class="form-label font-weight-bold" for="email">Username</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            </div>
                                            <input name="email" type="text" id="email" class="form-control form-control-lg"
                                                placeholder="Enter your username" required />
                                            <div class="valid_message" id="valid_email"></div>
                                            <div class="invalid_message" id="invalid_email"></div>
                                        </div>
                                    </div>

                                    <div class="text-left">
                                        <label class="form-label font-weight-bold" for="password">Password</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                            </div>
                                            <input name="password" type="password" id="password"
                                                class="form-control form-control-lg" placeholder="Enter your password"
                                                required />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i id="pass" class="fa fa-eye-slash"
                                                        onclick="toggleVisibility()"></i></span>
                                            </div>
                                            <div class="valid_message" id="valid_password"></div>
                                            <div class="invalid_message" id="invalid_password"></div>
                                        </div>
                                    </div>

                                    <div class="text-left">
                                        <img src="captcha.php" style="width:100%;">
                                        <div class="text-left mt-2">
                                            <label class="form-label font-weight-bold" for="phrase">Enter CAPTCHA</label>
                                            <input name="phrase" type="text" id="phrase"
                                                class="form-control form-control-lg" placeholder="Enter your phrase"
                                                required />
                                            <div class="valid_message" id="valid_phrase"></div>
                                            <div class="invalid_message" id="invalid_phrase"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                                        <p class="mb-0"><a class="text-dark font-weight-bold" href="forgot">Forgot password?</a></p>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5 btn-block rounded-pill lbtn"
                                        type="button" id="loginBtn"><i class="fa fa-save"></i> Login</button>

                                    <!-- Corrected Sign Up button -->
                                    <div class="text-left mt-3">
                                        <a href="register.php" class="btn btn-dark btn-lg btn-block rounded-pill">
                                            <i class="fa fa-user-plus"></i> Sign Up
                                        </a>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="login.js"></script>
    <?php include_once 'includes/footer.php'; ?>

