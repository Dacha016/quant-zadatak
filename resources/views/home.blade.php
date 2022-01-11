@extends("layout.main")
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        @foreach($result as $row)
            <div class="d-inline-block">
                <img src={{$row->file_name}} class="mt-2" alt="{{$row->filename}}">
                <i class=" d-block fas fa-comment"></i>
            </div>
        @endforeach
    </div>
@endsection