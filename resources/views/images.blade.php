@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
<div style="width: 1200px; margin: 10px auto">
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    @foreach($result as $row)
        @if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"]))
            <div class="d-inline-block m-3" >
                <div>
                    <a href="/profile/comments/galleries/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div class="text-center">
                    <form action ="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                        <input type="hidden" value="{{$row->userId}}" name="userId">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endif
        @if($_SESSION["role"] === "admin" && $row->userId !==$_SESSION["id"])
            <div class="d-inline-block" >
                <div>
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div>
                    <form action ="/profile/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                        <input type="hidden" value="{{$row->userId}}" name="userId">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endif
        @if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block" >
                <div>
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div>
                    <form action ="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                </div>
            </div>
        @endif
            @if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block" >
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
            @endif
    @endforeach
</div>
@endsection