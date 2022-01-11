@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    @if(($_SESSION["role"]==="moderator" && $result->userId === $_SESSION["id"]) || $_SESSION["role"]==="admin" || ($_SESSION["role"]==="user" && $result->userId === $_SESSION["id"]) )
        <form action="/profile/update/gallery/{{$result->galleryId}}" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden"   >
            <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
            <h3 style="text-align:center">{{$result->name}}</h3>
            <input type="hidden" name="galleryId" value="{{$result->galleryId}}">
            <input type="hidden" name="userId" value="{{$result->userId}}">
                <input type="hidden" name="userUsername" value="{{$result->userUsername}}">
            <input type="hidden" name = "page" value={{$_GET["page"]}}>
            <div class="mb-3 pt-3 ">
                <label for="name" class="form-label" style="font-size:18px; margin-left:15px;">Name:</label>
                <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="name" name="name" value="{{$result->name}}">
            </div>

            <div class="mb-3 pt-3 ">
                <label for="description" class="form-label" style="font-size:18px; margin-left:15px;">Description:</label>
                    <textarea type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="description" name="description">{{$result->description}}</textarea>
            </div>

            <div class="mb-3 pt-3 ">
                <label for="slug" class="form-label" style="font-size:18px; margin-left:15px;">Slug:</label>
                    <input type="text" class="form- control d-block p-2" style="width:95%;margin:10px auto; border-radius:10px" id="slug" name="slug" value="{{$result->slug}}">
            </div>

            <div class="form-check mb-3 ml-3">
                <label class="form-check-label" for="hidden">
                    @if($result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$result->nsfw}} checked>
                    @endif
                    @if(!$result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$result->nsfw}}">
                    @endif
                    <label >Hidden</label>
                </label>
            </div>

            <div class="form-check ml-3 ">
                <label class="form-check-label" for="hidden">
                    @if($result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$result->hidden}} checked>
                    @endif
                    @if(!$result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$result->hidden}}">
                    @endif
                    <label >Nsfw</label>
                </label>
            </div>
            <div class="m-3">
                <button class="btn btn-secondary d-inline-block" type="submit"><a style="color: white" href="http://localhost/profile/galleries?page={{$_GET['page']}}">Cancel</a></button>
                <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
            </div>
        </form>
    @endif
    @if(($_SESSION["role"]==="moderator" && $result->userId !== $_SESSION["id"]))
        <form action="/profile/update/gallery/{{$result->galleryId}}" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden"   >
            <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
            <h3 style="text-align:center">{{$result->name}}</h3>
            <input type="hidden" name="galleryId" value="{{$result->galleryId}}">
            <input type="hidden" name="userId" value="{{$result->userId}}">
            <input type="hidden" name="userUsername" value="{{$result->userUsername}}">
            <input type="hidden" name="name" value="{{$result->name}}">
            <input type="hidden" name="description" value="{{$result->description}}">
            <input type="hidden" name="slug" value="{{$result->slug}}">
            <input type="hidden" name = "page" value={{$_GET["page"]}}>
            <div class="form-check mb-3 ml-3">
                <label class="form-check-label" for="hidden">
                    @if($result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$result->nsfw}} checked>
                    @endif
                    @if(!$result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$result->nsfw}}">
                    @endif
                    <label >Hidden</label>
                </label>
            </div>

            <div class="form-check ml-3 ">
                <label class="form-check-label" for="hidden">
                    @if($result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$result->hidden}} checked>
                    @endif
                    @if(!$result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$result->hidden}}">
                    @endif
                    <label >Nsfw</label>
                </label>
            </div>
            <div class="m-3">
                <a class="btn btn-secondary" style="color: white" href="http://localhost/profile/galleries?page={{$_GET['page']}}">Cancel</a>
                <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
            </div>
        </form>
    @endif
@endsection