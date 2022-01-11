@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    <div style="margin: 20px auto; width: 1200px;">
        <h1 style="text-align:center">Comments</h1>
        <div>
            <img src="{{$image->file_name}}" class="mt-2" alt="{{$image->filename}}">
            <p>{{$result}}</p>
            <form action="/create/comments" method="post">
                <input type="hidden"  name="userId" value="{{$_SESSION["id"]}}">
                <input type="hidden"  name="imageId" value="{{$image->id}}">
                <input type="text" placeholder="Add comment" name="comment">
                <button type="submit">Comment</button>
            </form>
        </div>
    </div>
@endsection