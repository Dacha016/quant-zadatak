<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Document</title>
</head>
<body class=" justify-content-center" style="background:aqua; box-sizing:border-box; height:100vh">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" >
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" >
                <?php if (isset($_SESSION["id"])) {?>
                <h3><a href="http://localhost/profile"><?php echo $_SESSION["username"]; ?></a></h3>
                    <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="http://localhost/logout">Logout </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="http://localhost/profile/users?page=1">Users </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="http://localhost/profile/galleries?page=1">Galleries </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="http://localhost/profile/galleries/newGallery"> New Gallery </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="http://localhost/profile/updateAccount"> Update account </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/addImage"> Add Image </a>
                </li>
                <?php } else{?>
                    <h3><a href="http://localhost/home">Welcome Guest</a></h3>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link " href="http://localhost/registration">Registration </a>
                </li>
                <li class="nav-item align-self-center">
                    <a class="nav-link" href="http://localhost/login">Login</a>
                </li>
                <?php }?>
            </ul>
        </div>
    </nav>
    <?php echo $__env->yieldContent("content"); ?>
</body>
</html><?php /**PATH /var/www/html/quant-zadatak/resources/views/layout/main.blade.php ENDPATH**/ ?>