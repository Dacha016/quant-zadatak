<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script type="text/javascript" src="../../js/index.js"></script>
    <title>Document</title>
</head>
<body class=" justify-content-center" style="background:aqua; box-sizing:border-box; ">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (isset($_SESSION["id"])) {?>
            <h3><a href="/profile"><?php echo $_SESSION["username"]; ?></a></h3>
            <li class="nav-item active align-self-center">
                <a class="nav-link" href="/logout">Logout </a>
            </li>
            <li class="nav-item active align-self-center">
                <a class="nav-link" href="/profile/users?page=1">Users </a>
            </li>
            <li class="nav-item active align-self-center">
                <a class="nav-link" href="/users/<?php echo e($_SESSION['username']); ?>?page=1">Galleries </a>
            </li>
            <li class="nav-item active align-self-center">
                <a class="nav-link" href="/profile/galleries/newGallery"> New Gallery </a>
            </li>
            <li class="nav-item active align-self-center">
                <a class="nav-link" href="/profile/updateAccount"> Update account </a>
            </li>
            <?php } else{?>
            <h3><a href="/home">Welcome Guest</a></h3>
            <li class="nav-item active align-self-center">
                <a class="nav-link " href="/registration">Registration </a>
            </li>
            <li class="nav-item align-self-center">
                <a class="nav-link" href="/login">Login</a>
            </li>
            <?php }?>
        </ul>
    </div>
    <?php if(isset($_SESSION["id"])): ?>
        <div>
            <p class="d-inline">Subscription: <b><?php echo e($_SESSION["plan"]); ?></b></p>
            <p class="d-inline">Ends:<b><?php echo e($_SESSION["plans end"]); ?></b></p>
        </div>
    <?php endif; ?>
</nav>
<div style="overflow: scroll">
    <section id="header-main" class="col-12"
             style="background: linear-gradient( #FFFFFF, #00FFFF ) ">
        <?php echo $__env->make("components.header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
    <aside class="col-2 float-left "
           style="height: 50vh; background: linear-gradient(90deg, rgba(255,255,255,1) 7%, rgba(0,255,255,1) 100%, rgba(0,212,255,1) 100%)">
        <?php echo $__env->make("components.left", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </aside>
    <section class="col-8 float-left" style="height: 78vh">
        <?php echo $__env->yieldContent("content"); ?>
    </section>
    <aside class="col-2 float-right"
           style="height: 100%;background:  linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(0,255,255,1) 0%, rgba(255,255,255,1) 93%)">
        <?php echo $__env->make("components.right", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </aside>
</div>
</body>
<footer id="header-main" class="col-12"
        style="background: linear-gradient( #00FFFF, #FFFFFF) ; position: absolute; bottom: 0">
    <?php echo $__env->make("components.footer", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</footer>

</html><?php /**PATH /var/www/html/quant-zadatak/resources/views/layout/main.blade.php ENDPATH**/ ?>