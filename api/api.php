<?php
/*
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

$keys = array();
$keys[]="ID";
$keys[]="DD";
$keys[]="AM";
$keys[]="CC";
$keys[]="TP";
$keys[]="TD";
$keys[]="SA";
$keys[]="MSG";
$keys[]="ON";
$keys[]="VS";
$keys[]="VII";
$keys[]="IDI";
$keys[]="INI";
$keys[]="VIR";
$keys[]="IDR";
$keys[]="INR";
$keys[]="DUZP";
$keys[]="DPPD";
$keys[]="TB0";
$keys[]="TB1";
$keys[]="TB2";
$keys[]="T0";
$keys[]="T1";
$keys[]="T2";
$keys[]="NTB";
$keys[]="FX";
$keys[]="FXA";
$keys[]="ACC";

$data = array();

if(sizeof($keys)>0)
{
    foreach($keys as $key)
    {
        if(isset($_GET[$key]) && $_GET[$key]!="") $data[]=$key.':'.$_GET[$key].'*';
    }
}


include 'qrcode.php';

$string = '';
if(sizeof($data)>0) $string = 'SQF*1.0*'.implode('',$data);

$options = array(
    "pb"=> 10,
);
$generator = new QRCode($string, $options);

$qrImage = $generator->render_image();

$image = new Imagick();
$draw = new ImagickDraw();

ob_start();
imagepng($qrImage);
$blob = ob_get_clean();

$image->readImageBlob($blob);

$draw->setFillColor('black');
$draw->setFont('./Ubuntu-R.ttf');
$draw->setFontSize( 16 );

$iw = $image->getImageWidth();
$ih = $image->getImageHeight();

$image->annotateImage($draw, (($iw/2)-42), ($ih-5), 0, 'QR-Faktúra');
$image->setImageFormat('png');

header('Content-type: image/png');
echo $image;
?>