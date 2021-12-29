@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">Users</h1>
    <div style="margin: 20px auto; max-width: 1000px; display: flex; flex-wrap: wrap; justify-content: space-between">
        <?php $role = $_SESSION["role"] ?>
            @if($role === "admin")
                @foreach($result as $row)
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/admin/users/{{$row->id}}" > {{$row->username}}</a>
                        </p>
                    </div>
                @endforeach
            @endif
            @if($role === "moderator")
                @foreach($result as $row)
                <div class="d-inline-block m-2">
                    <p>
                        <a href="/profile/moderator/users/{{$row->id}}" > {{$row->username}}</a>
                    </p>
                </div>
                @endforeach
            @endif
            @if($role === "user")
                @foreach($result as $row)
                    <div class="d-inline-block m-2">
                        <p>
                            <a href="/profile/users/{{$row->id}}"  style="display: inline-block; padding: 10px; background: azure; justify-content: stretch" > {{$row->username}}</a>
                        </p>
                    </div>
                @endforeach
            @endif
    </div>
@endsection