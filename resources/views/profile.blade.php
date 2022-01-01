@extends("layout.main")
@section("content")
    <?php
    if(!isset($_SESSION["id"])) {
        header("Location: http://localhost/home");
    }
    ?>
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    @foreach($result as $row)
        <img src={{$row->file_name}}  alt="pictures" >
    @endforeach
@endsection