<div id='header'>
  <?php
    $http_host = getenv('HTTP_HOST');
    print "<a href=\"http://$http_host"."$http_dir"."index.php?cam=$cam&dir=$dir\">Home</a>";
  ?>
</div>
