

@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        @foreach($result as $row)
            <div class="d-inline-block m-2">
                <p>
                    <a href="/users/{{$row->username}}">{{$row->username}}</a>
                </p>
            </div>
        @endforeach
    </div>
@endsection