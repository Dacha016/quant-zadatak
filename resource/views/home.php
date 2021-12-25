<?php
session_start();
include (dirname(__DIR__,2) . "/resource/components/main.header.php");
?>
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<h2>Wlocome <?php if (isset($_SESSION["usersid"])) {
    echo explode(" ", $_SESSION["usersUsername"])[0];
    } else {
    echo "Guest";
    }?></h2>
<?php
include_once (dirname(__DIR__,2) . "/resource/components/footer.php");
?>