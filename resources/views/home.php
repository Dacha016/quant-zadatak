<?php
session_start();
include_once dirname(__DIR__, 2) . "/app/helpers/helper.php";
include (dirname(__DIR__, 2) . "/resources/components/main.header.php");
?>
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<h2>Welcome Guest"</h2>
<?php
showPicturesOnHome("Gallery");
include_once (dirname(__DIR__, 2) . "/resources/components/footer.php");
?>