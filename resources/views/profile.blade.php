@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        @foreach($result as $row)
            <img src={{$row->file_name}} class="mt-2" alt="{{$row->filename}}">
        @endforeach
    </div>
@endsection