@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
<div style="width: 1200px; margin: 10px auto">
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <form id="imageForm" action ="/addImage/galleries/{{$galleryId}}" method="post" class="p-2 align-self-center" style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
        <input type="file" id="fileName" name="fileName" />
        <input class="float-right" type="submit" id="submit" name="submit" value="Upload" />
    </form>
    @foreach($result as $row)
        @if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"]))
            <div class="d-inline-block m-1" >
                <div>
                    <a href="/profile/comments/galleries/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div class="text-center">
                    <a href="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
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
            <div class="d-inline-block m-1" >
                <div class="text-center">
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div>
                    <a href="/profile/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
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
            <div class="d-inline-block m-1" >
                <div >
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div class="text-center">
                    <a href="/profile/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>
                </div>
            </div>
        @endif
            @if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block m-1" >
                    <a href="/comments/users/{{$row->username}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
            @endif
    @endforeach
</div>
@endsection
<script type="text/javascript" src="../js/index.js"></script>