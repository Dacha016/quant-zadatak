@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<div >
    @foreach($result as $row)
        <div class="d-inline-block m-2">
            <img src={{$row->file_name}}  alt="pictures" >
            @if($_SESSION["role"] === "admin")
                @if($row->userId ===$_SESSION["id"])
                    <form action ="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                @endif
                @if($row->userId !==$_SESSION["id"])
                    <form action ="/profile/users/{{$row->userId}}/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                @endif
                    <input type="hidden" value="{{$row->imageId}}" name="getImage">
                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                </form>
                <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                    <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                    <input type="hidden" value="{{$row->userId}}" name="userId">
                    <input type="hidden" value="{{$row->imageId}}" name="imageId">
                    <button class="btn btn-danger" type="submit">DELETE</button>
                </form>
            @endif
            @if($_SESSION["role"] === "moderator" && $row->userId === $_SESSION["id"])
                <div class="d-inline-block m-2">
                    <form action ="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                        <input type="hidden" value="{{$row->userId}}" name="userId">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            @endif
            @if($_SESSION["role"] === "moderator" && $row->userId !==$_SESSION["id"])
                <div >
                    <form action ="/profile/users/{{$row->userId}}/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                </div>
            @endif
            @if($_SESSION["role"] === "user" && $row->userId ===$_SESSION["id"])
                <div class="d-inline-block m-2">
                    <form action ="/profile/galleries/{{$row->galleryId}}/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="getImage">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                        <input type="hidden" value="{{$row->userId}}" name="userId">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            @endif
        <div>
    @endforeach
</div>
@endsection