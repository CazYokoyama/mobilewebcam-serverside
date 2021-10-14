<?php
// new file uploaded? copy to $root_dir; create thumbnail;
// version 1.03, 12/16/2012;

$uploadfile = "";
date_default_timezone_set("America/Los_Angeles");
$today = date ("Y-m-d", time());
// all archives are in "root_dir" of the gallery
$root_dir = "archive";

// every day a new directory archive/2012-09-08, archive/2012-09-09, ...
$working_dir = $root_dir."/$today";

// create thumbnails in directory archive/2012-09-08/thumbnails"
$thumbdir = $working_dir."/thumbnails";

if(strlen(basename($_FILES["userfile"]["name"])) > 0) {
    $uploadfile = basename($_FILES["userfile"]["name"]);
    $uploadlog = basename($_POST["log"]);

    if(!file_exists($root_dir))
        mkdir($root_dir, 0777);

    if(!file_exists($working_dir))
        mkdir($working_dir, 0777);

    if(!file_exists($thumbdir))
        mkdir($thumbdir, 0777);

    if(move_uploaded_file($_FILES["userfile"]["tmp_name"], $uploadfile)) {
        @chmod($uploadfile,0755);
        $filename = time().".jpg";
        $archivefile =  $working_dir."/".$filename;
	$smallname = $thumbdir."/".$filename;
	copy($uploadfile, $archivefile);
	if ($uploadfile <> 'current.jpg')
	    rename ($uploadfile, 'current.jpg');
	echo "Upload Ok!<br>";
    } else
        echo "Error create archive-file!<br>";

    if(!file_exists($smallname)) {
        $image = @imagecreatefromjpeg($archivefile);
        if($image) {
	    $new_image = imagecreatetruecolor(240, 180);
	    imagecopyresampled($new_image, $image, 0, 0, 0, 0, 240, 180, imagesx($image), imagesy($image));
	    imagejpeg($new_image, $smallname);
	    echo "Thumbnail Ok!";
	} else
	  echo "Error create thumbnail!.<br>";

    }
}

?>
