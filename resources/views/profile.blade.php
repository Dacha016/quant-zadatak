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
                    <a href="">Update picture</a>
                    <form action ="profile/{{$row->slug}}" method="post">
                        <input type="hidden" value="{{$row->slug}}" name="delete">
                        <button class="btn btn-danger" type="submit">DELETE</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
