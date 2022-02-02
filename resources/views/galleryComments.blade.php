@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="margin: 20px auto; width: 1200px;">
        <h1 style="text-align:center">Comments</h1>
        <div>
            <h1>{{$gallery->name}}</h1>
            <form action="/gallery/comment" method="post">
                <input type="hidden" name="slug" value="{{$gallery->slug}}">
                <input type="hidden" name="userId" value="{{$gallery->userId}}">
                <input type="hidden" value="{{$gallery->galleryId}}" name="galleryId">
                <label>
                    <input type="text" placeholder="Add comment" name="comment">
                </label>
                <button type="submit">Comment</button>
            </form>
            @foreach($result as $row)
                <p><span>{{$row->username}}:</span>{{$row->comment}}</p>
            @endforeach
        </div>
    </div>
@endsection