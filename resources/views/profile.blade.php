@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <div>
            <h1 class="d-block mb-5 " style="text-align:center">IMGUR Clone</h1>
            @if($_SESSION["plan"] == "Free" && $monthlyNumberOfPictures < 5 )
                <form id="imageForm" action="/addImage" method="post" class=" d-inline-block p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
                <p id="error"></p>
            @endif
            @if($_SESSION["plan"] == "Month" && $monthlyNumberOfPictures < 20 )
                <form id="imageForm" action="/addImage" method="post" class=" d-inline-block p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "6 months" && $monthlyNumberOfPictures < 30 )
                <form id="imageForm" action="/addImage" method="post" class=" d-inline-block p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "Year" && $monthlyNumberOfPictures < 50 )
                <form id="imageForm" action="/addImage" method="post" class=" d-inline-block p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "Free" && $monthlyNumberOfPictures == 5 || $_SESSION["plan"] == "Month" && $monthlyNumberOfPictures == 20 ||
                $_SESSION["plan"] == "6 months" && $monthlyNumberOfPictures == 30 || $_SESSION["plan"] == "Year" && $monthlyNumberOfPictures == 50)
                <h2>Upgrade subscription plan</h2>
            @endif
            <a href="/profile/subscription" class="btn-light btn float-right">Subscription plan</a>
        </div>
        <div>
            @if(isset($result))
                <h2 class="m-5" style="text-align:center">Profile images</h2>
                @foreach($result as $row)
                    <div class="d-inline-block m-3">
                        <div>
                            <a href="/images/{{$row->slug}}" class="btn btn-info d-inline-block"
                               style="padding: 10px">
                                <img class="mt-2" alt="{{$row->file_name}}" src={{$row->file_name}} >
                            </a>
                        </div>
                        <div class="text-center">
                            <a href="/update/images/{{$row->slug}}" class="btn btn-info d-inline-block"
                               style="padding: 10px"><i class="fas fa-pen"></i></a>

                            <form action="/delete/images/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="imageSlug">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
