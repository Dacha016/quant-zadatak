@extends("layout.main")
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        @foreach($result as $row)

            <div class="d-inline-block m-3" >
                <a href="/home/images/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                    <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                </a>
            </div>
        @endforeach
    </div>
@endsection