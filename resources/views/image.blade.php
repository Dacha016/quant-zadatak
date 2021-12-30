
@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <img src={{$result->file_name}} alt="pictures" >
        <div>
            <form action ="/update/{{$result->galleryId}}/{{$result->imageId}}" method="post" class="d-inline-block m-1">
                <input type="hidden" value="{{$result->slug}}" name="slug">
                <input type="hidden" value="{{$result->userId}}" name="userId">
                <input type="hidden" value="{{$result->galleryId}}" name="galleryId">
                <input type="hidden" value="{{$result->imageId}}" name="galleryId">
                <div class="form-check">
                    @if($result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$result->hidden}} checked>
                    @endif
                    @if(!$result->hidden)
                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="0">
                    @endif
                    <label class="form-check-label" for="hidden">Hidden</label>
                </div>
                <div class="form-check">
                    @if($result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$result->nsfw}} checked>
                    @endif
                    @if(!$result->nsfw)
                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="0">
                    @endif
                    <label class="form-check-label" for="nsfw">Nsfw</label>
                </div>
                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
            </form>
        </div>
    </div>
    </div>
@endsection

