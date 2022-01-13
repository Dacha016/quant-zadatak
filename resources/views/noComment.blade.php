@extends("layout.main")
@section("content")
    <div style="margin: 20px auto; width: 1200px;">
        <h1 style="text-align:center">{{$image->file_name}}</h1>
        <div class="d-inline-block m-1 ">
            <img style="width: 35vw; height: 75vh;" src="{{$image->file_name}}" class="mt-2" alt="{{$image->file_name}}">
        </div>
        <div style="width: 500px" class="float-right">
            <p>{{$result}}</p>
            @if(isset($_SESSION["id"]))
                <form action="/image/comments" method="post">
                    <input type="hidden"  name="userId" value="{{$image->userId}}">
                    <input type="hidden"  name="username" value="{{$image->username}}">
                    <input type="hidden"  name="imageId" value="{{$image->imageId}}">
                    @if(isset($image->galleryId))
                        <input type="hidden" value="{{$image->galleryId}}" name="galleryId">
                    @endif
                   <label>
                       <input type="text" placeholder="Add comment" name="comment">
                   </label>
                    <button type="submit">Comment</button>
                </form>
            @endif
        </div>
    </div>
@endsection