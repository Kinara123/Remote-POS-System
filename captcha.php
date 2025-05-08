<?php
//generate a random captcha text and set it in the session variables
//this file will be included in the login page as a src file for the captcha image
require_once('vendor/autoload.php');

use SimpleCaptcha\Builder;
use SimpleCaptcha\Helpers\Mime;

session_start();

$captcha = Builder::create();
$captcha->noiseFactor = 3;
$captcha->applyNoise = false;
$captcha->maxLinesBehind = 1;
$captcha->maxLinesFront = 1;
$captcha->maxAngle = 2;
$captcha->textColor = '#ffffff';

$_SESSION['phrase'] = $captcha->phrase;
header('Content-type: ' . Mime::fromExtension('png'));
$captcha->build()->output();
