@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
<div style="width: 1200px; margin: 10px auto">
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    @foreach($result as $row)
        @if(($_SESSION["role"] === "admin" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "moderator" && $row->userId ===$_SESSION["id"]) || ($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"]))
            <div class="d-inline-block m-3" >
                <div>
                    <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                </div>
                <div class="text-center">
                    <a href="/profile/comments/galleries/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="http://localhost/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
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
                    <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                </div>
                <div>
                    <a href="/comments/users/{{$row->userId}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="http://localhost/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
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
                    <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                </div>
                <div>
                    <a href="/comments/users/{{$row->userId}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    <form action ="http://localhost/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                </div>
            </div>
        @endif
            @if($_SESSION["role"] === "user" && $row->userId !==$_SESSION["id"])
                <div class="d-inline-block" >
                    <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    <div class="text-center">
                        <a href="/comments/users/{{$row->userId}}/{{$row->galleryId}}/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class=" d-block fas fa-comment"></i></a>
                    </div>
                </div>
            @endif
    @endforeach
</div>
@endsection