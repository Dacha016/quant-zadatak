
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
                <?php if (isset($_SESSION["id"])) {?>
                <h3><a href="/profile"><?php echo $_SESSION["username"]; ?></a></h3>

                <li class="nav-item active" >
                    <a class="nav-link" href="/home">Logout </a>
                </li>
                <li class="nav-item active" >
                    <a class="nav-link" href="/users">Users </a>
                </li>
                <?php } else{?>
                    <h3>Welcome Guest</h3>
                    <li class="nav-item active" >
                        <a class="nav-link" href="/home">Home </a>
                    </li>
                <li class="nav-item active" >
                    <a class="nav-link" href="/registration">Registration </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <?php }?>
            </ul>
        </div>
    </nav>
    <?php echo $__env->yieldContent("content"); ?>
</body>
</html><?php /**PATH /var/www/html/quant-zadatak/resources/views/layout/main.blade.php ENDPATH**/ ?>