<?php include_once dirname(__DIR__, 2) . "/app/helpers/helper.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="d-block justify-content-center" style="background:aqua; box-sizing:border-box; height:100vh">
<nav class="navbar navbar-expand-lg navbar-light bg-light" >
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto" >
            <?php if ($_SESSION["id"]){?>
            <h3><?php echo explode(" ", $_SESSION["username"])[0]; ?></h3>
            <li class="nav-item active" >
                <a class="nav-link" href="/logout">Logout </a>
            </li>
            <?php } else{?>
            <li class="nav-item active" >
                <a class="nav-link" href="/signup">Registration </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/login">Login</a>
            </li>
            <?php }?>
        </ul>
    </div>
</nav>