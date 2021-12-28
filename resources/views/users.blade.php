@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <?php $role = $_SESSION["role"] ?>
            @if($role === "admin")
                @foreach($result as $row)
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/users/{{$row->id}}" > {{$row->username}}</a>
                        </p>
                    </div>
                @endforeach
            @endif
            @if($role === "moderator")
                @foreach($result as $row)
                <div class="d-inline-block m-2">
                    <p>
                        <a href="moderator/users/{{$row->id}}" > {{$row->username}}</a>
                    </p>
                </div>
                @endforeach
            @endif
            @if($role === "user")
                @foreach($result as $row)
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/users/{{$row->id}}" > {{$row->username}}</a>
                        </p>
                    </div>
                @endforeach
            @endif
    </div>
@endsection