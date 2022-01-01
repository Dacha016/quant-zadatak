
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="#">
    <title>Document</title>
</head>
<body class="d-block justify-content-center" style="background:aqua; box-sizing:border-box; height:100vh">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" >
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" >
                <?php if (isset($_SESSION["id"])) {?>
                <h3><a href="/profile"><?php echo $_SESSION["username"]; ?></a></h3>
                    <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/logout">Logout </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/profile/users?page=0">Users </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/profile/galleries?page=0">Galleries </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/profile/galleries/newGallery"> New Gallery </a>
                </li>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link" href="/profile/updateAccount"> Update account </a>
                </li>
                <?php } else{?>
                    <h3><a href="/home">Welcome Guest</a></h3>
                <li class="nav-item active align-self-center" >
                    <a class="nav-link " href="/registration">Registration </a>
                </li>
                <li class="nav-item align-self-center">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <?php }?>
            </ul>
        </div>
    </nav>
    @yield("content")
</body>
</html>