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
            <img src="{{$image->file_name}}" class="mt-2" alt="{{$image->file_name}}">
            <form action="/create/comments" method="post">
                <input type="hidden"  name="userId" value="{{$image->userId}}">
                <input type="hidden"  name="imageId" value="{{$image->imageId}}">
                @if(isset($image->galleryId))
                    <input type="hidden" value="{{$image->galleryId}}" name="galleryId">
                @endif
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