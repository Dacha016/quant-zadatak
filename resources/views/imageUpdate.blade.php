@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
<h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
<div style="margin: 20px auto; max-width: 1000px; text-align: center">
    <img style=" width: 35vw; height: 70vh" src={{$result->file_name}} class="mt-2" alt="{{$result->file_name}}">
    <div>
        @if($result->userId !== $_SESSION["id"])
            <form action ="/update/images/{{$result->imageId}}" method="post" class="d-inline-block m-1">
        @endif
        <form action ="/profile/update/images/{{$result->imageId}}" method="post" class="d-inline-block m-1">
            <input type="hidden" value="{{$result->userId}}" name="userId">
            <input type="hidden" value="{{$result->username}}" name="userUsername">
            @if(isset($result->galleryId))
                <input type="hidden" value="{{$result->galleryId}}" name="galleryId">
            @endif
            <input type="hidden" value="{{$result->imageId}}" name="imageId">
            <input type="hidden" value="{{$result->file_name}}" name="imageName">
            <div class="form-check">
                @if($result->hidden)
                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$result->hidden}} checked>
                @endif
                @if(!$result->hidden)
                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="0">
                @endif
                <label class="form-check-label" for="hidden">Hidden</label>
            </div>
            <div class="form-check">
                @if($result->nsfw)
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$result->nsfw}} checked>
                @endif
                @if(!$result->nsfw)
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="0">
                @endif
                <label class="form-check-label" for="nsfw">Nsfw</label>
            </div>
            <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
        </form>
    </div>
</div>
@endsection

