<?php
// Rui Santos
// Complete project details at https://RandomNerdTutorials.com/esp32-cam-post-image-photo-server/
// Code Based on this example: w3schools.com/php/php_file_upload.asp

$font_width = 16;
$font_height = 24;

$uploadOk = 1;

date_default_timezone_set("America/Los_Angeles");
$today = date ("Y-m-d", time());
// all archives are in "root_dir" of the gallery
$root_dir = "archive";

// every day a new directory archive/2012-09-08, archive/2012-09-09, ...
$working_dir = $root_dir."/$today";

// create thumbnails in directory archive/2012-09-08/thumbnails"
$thumbdir = $working_dir."/thumbnails";

$imagefile = $argv[1];

// Check file size
if (filesize($imagefile) > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

if (!file_exists($root_dir))
    mkdir($root_dir, 0777);

if (!file_exists($working_dir))
    mkdir($working_dir, 0777);

if (!file_exists($thumbdir))
    mkdir($thumbdir, 0777);

if (!file_exists($imagefile)) {
  echo $imagefile . " was not uploaded.";
}
else {
    echo $imagefile . " has been uploaded to " . basename(getcwd()) . "\n";
    $filename = time().".jpg";
    $archivefile =  $working_dir."/".$filename;
    $smallname = $thumbdir."/".$filename;

    $img = imagecreatefromjpeg($imagefile);
    list($width, $height, $type, $attr) = getimagesize($imagefile);

    $white = imagecolorallocate($img, 255, 255, 255);
    imagefilledrectangle($img, 0, 0, $width, $font_height + 10, $white);

    $black = imagecolorallocate($img, 0, 0, 0);
    $font = "../OpenSans-Regular.ttf";
    imagettftext($img, $font_height, 0, 0, $font_height, $black, $font, basename(getcwd()));

    imagefilledrectangle($img, 0, $height - $font_height - 10, $width, $height, $black);

    $ip_title = "IP:";
    imagettftext($img, $font_height, 0, 0, $height - 5, $white, $font, $ip_title);
    $ip = $argv[2];
    imagettftext($img, $font_height, 0, $font_width * strlen($ip_title), $height - 5, $white, $font, $ip);

    $timestamp = date ("Y/m/d H:i:s", time());
    $strlen = strlen($timestamp);
    $x_loc = $width - $font_width * $strlen;
    $y_loc = $height - 5;
    imagettftext($img, $font_height, 0, $x_loc, $y_loc, $white, $font, $timestamp);
    imagejpeg($img, $imagefile, 100);

    copy($imagefile, $archivefile);
    rename($imagefile, 'current.jpg');

  if (!file_exists($smallname)) {
      $image = @imagecreatefromjpeg($archivefile);
      if (!$image) {
          echo "can't create thumbnail.";
      }

      $new_image = imagecreatetruecolor(240, 180);
      imagecopyresampled($new_image, $image, 0, 0, 0, 0, 240, 180, imagesx($image), imagesy($image));
      imagejpeg($new_image, $smallname);
  }
}
?>
