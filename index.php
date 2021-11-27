<?php
    require 'common.php';
    getparams();
    $status = getdirs();
    if ($status == 0) {
        print "directory \"$archive_dir\" not found<br>";
        exit;
    }
    getfiles();
?>
<html>
<head><title>mobilewebcam</title></head>
<body>
    <?php
        date_default_timezone_set("America/Los_Angeles");
        navigation_top();
    ?>
    <?php print "<img src=\"$current\" name=\"refresh\">\n" ?>
    <script language="JavaScript" type="text/javascript">
        <?php print "image = \"$current\"\n"; ?>
        function Reload() {
            tmp = new Date();
            tmp = "?"+tmp.getTime()
            document.images["refresh"].src = image+tmp
            setTimeout("Reload()", 180000)
        }
        Reload();
    </script>
    <?php
        feeding_log();
        include("inc/footer.php");
    ?>

</body>
</html>
