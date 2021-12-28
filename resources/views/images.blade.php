
@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
        <?php $role = $_SESSION["role"]?>
        @if($role === "admin")
            <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                @foreach($result as $row)
                    <div class="d-inline-block m-2">
                        <img src={{$row->file_name}}  alt="pictures" >
                        <div>
                            <form action ="/profile/gallery/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="adminModeratorUpdate">
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                            <form action ="delete/image/{{$result->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$result->slug}}" name="delete">
                                <button class="btn btn-danger" type="submit">DELETE</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
            @if($role === "moderator")
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    @foreach($result as $row)
                        <div class="d-inline-block m-2">
                            <img src={{$row->file_name}}  alt="pictures" >
                            <div>
                                <form action ="/profile/gallery/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                    <input type="hidden" value="{{$row->slug}}" name="adminModeratorUpdate">
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($role === "user")
                @foreach($result as $row)
                    <img src={{$row->file_name}}  alt="pictures" >
                @endforeach
            @endif
@endsection