@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    <form action ="/delete/gallery/{{$result->galleryId}}" method="post" class="p-2 align-self-center" style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
        <h2 class="mb-2 pt-4" style="text-align:center">Do you want to delete the </h2>
        <h3 style="text-align:center">{{$result->name}}</h3>
        <input type="hidden" value="{{$result->galleryId}}" name="galleryId">
        <input type="hidden" value="{{$result->userId}}" name="userId">
        <input type="hidden" name = "page" value={{$_GET["page"]}}>
        <button class="btn btn-danger float-right" type="submit">Delete</button>
    </form>
@endsection