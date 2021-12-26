<?php
session_start();
include (dirname(__DIR__, 2) . "/resources/components/main.header.php");
?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <h2>Welcome <?php  echo explode(" ", $_SESSION["username"])[0]; ?></h2>
<?php
include_once (dirname(__DIR__, 2) . "/resources/components/footer.php");
?>