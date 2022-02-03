@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="width: 500px;  background:white;  border-radius: 15px; border:black 1px solid; margin: 20px auto">
        <form action="/profile/updateAccount" method="post" class="p-2 " style="overflow:hidden">
            <h2 class="mb-5 pt-4" style="text-align:center">Update account</h2>
            @if(isset($error))
                <div class="mb-3 mt-3 b">
                    <p>{{$error}}</p>

                </div>
            @endif
            <div class="mb-3 mt-3 b">
                <label for="username" class="form-label" style="font-size:18px; margin-left:15px;">Username:</label>
                <input type="username" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px"
                       id="username" name="username" value="{{$result->username}}">
            </div>

            <div class="mb-3 mt-3">
                <label for="email" class="form-label" style="font-size:18px; margin-left:15px;">Email:</label>
                <input type="email" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px"
                       id="email" name="email" value="{{$result->email}}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label" style="font-size:18px; margin-left:15px;">Password:
                    <input type="password" class="form- control d-block p-2"
                           style="width:95%;margin:10px auto; border-radius:10px" name="password" value="">
                </label>
            </div>

            <div class="mb-3">
                <label for="rPassword" class="form-label" style="font-size:18px; margin-left:15px;">Retype password:
                    <input type="password" class="form- control d-block p-2"
                           style="width:95%;margin:10px auto; border-radius:10px" name="rPassword">
                </label>
            </div>

            <div class="mb-3">
                <label for="valid_until" class="form-label" style="font-size:18px; margin-left:15px;">Card valid:
                    <input type="date" class="form- control d-block p-2"
                           style="width:95%;margin:10px auto; border-radius:10px" name="valid_until"
                           value={{$result->valid_until}}>
                </label>
            </div>

            <div class="form-check ml-3">
                @if($result->payment)
                    <input class="form-check-input" type="checkbox" id="payment" name="payment"
                           value={{$result->payment}} checked>
                @endif
                @if(!$result->payment)
                    <input class="form-check-input" type="checkbox" id="payment" name="payment" value="0">
                @endif
                <label class="form-check-label" for="payment">Payment</label>
            </div>

            <div class="m-3">
                <a class="btn btn-secondary" style="color: white" href="/profile">Cancel</a>
                <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
