<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>

@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        @foreach($result as $row)
            <div class="d-inline-block m-2">
                <img src={{$row->file_name}}  alt="pictures" >
                <div>
                    <form action ="profile/image/update/{{$row->slug}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->slug}}" name="update">
                        <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                    </form>
                    <form action ="profile/image/delete/{{$row->slug}}" method="post" class="d-inline-block m-1">
                        <input type="hidden" value="{{$row->slug}}" name="delete">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
