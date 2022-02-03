@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="width: 1200px; margin: 10px auto">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        @if($_SESSION["id"] == $userId)
            @if($_SESSION["plan"] == "Free" && $monthlyNumberOfPictures < 5 )
                <form id="imageForm" action="/addImage/galleries/{{$galleryId}}" method="post"
                      class="p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="hidden" name="galleryId" value="{{$galleryId}}">
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
                <p id="error"></p>
            @endif
            @if($_SESSION["plan"] == "Month" && $monthlyNumberOfPictures < 20 )
                <form id="imageForm" action="/addImage/galleries/{{$galleryId}}" method="post"
                      class="p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="hidden" name="galleryId" value="{{$galleryId}}">
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "6 months" && $monthlyNumberOfPictures < 30 )
                <form id="imageForm" action="/addImage/galleries/{{$galleryId}}" method="post"
                      class="p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="hidden" name="galleryId" value="{{$galleryId}}">
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "Year" && $monthlyNumberOfPictures < 50 )
                <form id="imageForm" action="/addImage/galleries/{{$galleryId}}" method="post"
                      class="p-2 align-self-center"
                      style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
                    @if(isset($error))
                        <p>{{$error}}</p>
                    @endif
                    <input type="hidden" name="galleryId" value="{{$galleryId}}">
                    <input type="file" id="fileName" name="fileName"/>
                    <input class="float-right" type="submit" id="submit" name="submit" value="Upload"/>
                </form>
            @endif
            @if($_SESSION["plan"] == "Free" && $monthlyNumberOfPictures == 5 || $_SESSION["plan"] == "Month" && $monthlyNumberOfPictures == 20 ||
                $_SESSION["plan"] == "6 months" && $monthlyNumberOfPictures == 30 || $_SESSION["plan"] == "Year" && $monthlyNumberOfPictures == 50)
                <h2>Upgrade subscription plan</h2>
            @endif
        @endif
        @foreach($result as $row)
            @if(($_SESSION["role"] === "admin" && $row->userId === $_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"]))
                <div class="d-inline-block m-1">
                    <div>
                        <a href="/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px">
                            <img class="mt-2" alt="{{$row->file_name}}" src={{$row->file_name}} >
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="/update/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                        <form action="/delete/images/{{$row->slug}}" method="post" class="d-inline-block m-1">
                            <input type="hidden" value="{{$row->gallerySlug}}" name="gallerySlug">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endif
            @if($_SESSION["role"] === "admin" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block m-1">
                    <div class="text-center">
                        <a href="/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px">
                            <img class="mt-2" alt="{{$row->file_name}}" src={{$row->file_name}} >
                        </a>
                    </div>
                    <div>
                        <a href="/update/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                        <form action="/delete/images/{{$row->slug}}" method="post" class="d-inline-block m-1">
                            <input type="hidden" value="{{$row->gallerySlug}}" name="gallerySlug">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endif
            @if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block m-1">
                    <div>
                        <a href="/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px">
                            <img class="mt-2" alt="{{$row->file_name}}" src={{$row->file_name}} >
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="/update/images/{{$row->slug}}"
                           class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                    </div>
                </div>
            @endif
            @if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block m-1">
                    <a href="/images/{{$row->slug}}"
                       class="btn btn-info d-inline-block" style="padding: 10px">
                        <img class="mt-2" alt="{{$row->file_name}}" src={{$row->file_name}} >
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@endsection
<script type="text/javascript" src="../js/index.js"></script>