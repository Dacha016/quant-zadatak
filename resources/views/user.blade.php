@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <?php $role = $_SESSION["role"]?>
        @if($role === "admin")
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    @foreach($result as $row)
                    <img src={{$row->file_name}}  alt="pictures" >
                        <div>
                            <form action ="admin/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="update">
                                <div class="form-check">
                                    @if($row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                    @endif
                                    @if(!$row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}}>
                                    @endif
                                    <label class="form-check-label" for="hidden">Hidden</label>
                                </div>
                                <div class="form-check">
                                    @if($row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                    @endif
                                    @if(!$row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}}>
                                    @endif
                                    <label class="form-check-label" for="nsfw">Nsfw</label>
                                </div>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                            <form action ="delete/image/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="delete">
                                <button class="btn btn-danger" type="submit">DELETE</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($role === "moderator")
                <div style="margin: 20px auto; max-width: 1000px; text-align: center">
                    @foreach($result as $row)
                        <img src={{$row->file_name}}  alt="pictures" >
                        <div>
                            <form action ="moderator/{{$row->slug}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="update">
                                <div class="form-check">
                                    @if($row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                    @endif
                                    @if(!$row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}}>
                                    @endif
                                    <label class="form-check-label" for="hidden">Hidden</label>
                                </div>
                                <div class="form-check">
                                    @if($row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                    @endif
                                    @if(!$row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}}>
                                    @endif
                                    <label class="form-check-label" for="nsfw">Nsfw</label>
                                </div>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($role === "user")
                @foreach($result as $row)
                    <img src={{$row->file_name}}  alt="pictures" >
                @endforeach
            @endif
    </div>
@endsection