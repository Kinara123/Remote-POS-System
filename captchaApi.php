
<?php

require_once('vendor/autoload.php');
use SimpleCaptcha\Builder;
session_start();
$captcha = Builder::create();
$captcha->distortion = false;
$captcha->noiseFactor = 3;
$captcha->applyNoise = false;
$captcha->maxLinesBehind = 1;
$captcha->maxLinesFront = 1;
$captcha->maxAngle = 2;
$captcha->textColor = '#ffffff';
// if (isset($_SESSION['phrase'])){
//     echo $_SESSION['phrase'];
// }
if (isset($_SESSION['phrase']) && $captcha->compare($_SESSION['phrase'], $_POST['phrase'])) {
    echo 1;
}else{
    echo 0;
}
//unset($_SESSION['phrase']);

?>