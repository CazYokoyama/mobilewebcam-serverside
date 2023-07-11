<?php
// Rui Santos
// Complete project details at https://RandomNerdTutorials.com/esp32-cam-post-image-photo-server/
// Code Based on this example: w3schools.com/php/php_file_upload.asp

$target_dir = "uploads/";
$datum = mktime(date('H')+0, date('i'), date('s'), date('m'), date('d'), date('y'));
$target_file = $target_dir . date('Y.m.d_H:i:s_', $datum) . basename($_FILES["imageFile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

date_default_timezone_set("America/Los_Angeles");
$today = date ("Y-m-d", time());
// all archives are in "root_dir" of the gallery
$root_dir = "archive";

// every day a new directory archive/2012-09-08, archive/2012-09-09, ...
$working_dir = $root_dir."/$today";

// create thumbnails in directory archive/2012-09-08/thumbnails"
$thumbdir = $working_dir."/thumbnails";

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  }
  else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["imageFile"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

if (!file_exists($root_dir))
    mkdir($root_dir, 0777);

if (!file_exists($working_dir))
    mkdir($working_dir, 0777);

if (!file_exists($thumbdir))
    mkdir($thumbdir, 0777);

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
}
else {
  $imagefile = basename($_FILES["imageFile"]["name"]);
  if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $imagefile)) {
    echo "The file ". $imagefile . " has been uploaded.";
    $filename = time().".jpg";
    $archivefile =  $working_dir."/".$filename;
    $smallname = $thumbdir."/".$filename;
    copy($imagefile, $archivefile);
    rename($imagefile, 'current.jpg');
  }
  else {
    echo "Sorry, there was an error uploading your file.";
  }

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
