@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        @foreach($result as $row)
            <div class="d-inline-block m-3" >
                <div>
                    <a href="/profile/comments/images/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                        <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                    </a>
                </div>
                <div class="text-center">
                    <form action ="/profile/images/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-info d-inline-block" type="submit"><i class="fas fa-pen"></i></button>
                    </form>
                    <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->imageId}}" name="imageId">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection