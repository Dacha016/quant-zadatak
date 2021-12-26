@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    @foreach($result as $row)

        <img src={{$row->file_name}}  alt="pictures" >
    @endforeach
@endsection