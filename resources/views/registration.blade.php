@extends("layout.main")
@section("content")
    <form action="/registration" method="post" class="p-2 align-self-center" style="margin-left: 35vW; margin-top:20Vh; border:black 1px solid;
   width:500px; background:white; border-radius: 15px; overflow:hidden">
        <h2 class="mb-5 pt-4" style="text-align:center">Registration</h2>
        <?php
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {?>
            <div class="mb-3 mt-3 b">
            <p>{{$error}}</p>
       <?php }?>
        </div>

        <div class="mb-3 mt-3 b">
            <label for="username" class="form-label" style="font-size:18px; margin-left:15px;">Username:</label>
            <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="username" name="username">
        </div>

        <div class="mb-3 mt-3">
            <label for="email" class="form-label" style="font-size:18px; margin-left:15px;">Email:</label>
            <input type="email" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label" style="font-size:18px; margin-left:15px;">Password:</label>
            <input id="password" type="password" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" name="password">
        </div>

        <div class="mb-3">
            <label for="rPassword" class="form-label" style="font-size:18px; margin-left:15px;">Retype password:</label>
            <input id = "rPassword" type="password" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" name="rPassword">
        </div>

        <label for="subscription">Subscription plan:</label>
        <select id="subscription" name="subscription">
            <option value="Free" selected>Free</option>
        </select>

        <div class="m-3">
            <button class="btn btn-secondary d-inline-block" type="submit"><a style="color: white" href="/home">Cancel</a></button>
            <button class="btn btn-success d-inline-block float-right" type="submit">Register</button>
        </div>

    </form>
@endsection
