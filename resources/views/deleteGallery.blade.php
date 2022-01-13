@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <form action ="/delete/gallery/{{$result->galleryId}}" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
        <h3 class="mb-2 pt-4" style="text-align:center">Do you want to delete the </h3>
        <h2 style=" font-weight: bolder; text-align:center">{{$result->name}}</h2>
        <input type="hidden" value="{{$result->galleryId}}" name="galleryId">
        <input type="hidden" value="{{$result->userId}}" name="userId">
        <input type="hidden" value="{{$result->userUsername}}" name="userUsername">
        <input type="hidden" name = "page" value={{$_GET["page"]}}>
        @if($result->userId == $_SESSION["id"])
            <a class="btn btn-secondary" style="color: white" href="/profile/galleries?page={{$_GET['page']}}">Cancel</a>
        @endif
        @if($result->userId !== $_SESSION["id"])
            <a class="btn btn-secondary" style="color: white" href="/profile/users/{{$result->userUsername}}?page={{$_GET['page']}}">Cancel</a>
        @endif
        <button class="btn btn-danger float-right" type="submit">Delete</button>
    </form>
@endsection