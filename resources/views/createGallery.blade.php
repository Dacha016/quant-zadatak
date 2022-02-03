@extends("layout.main")
@section("content")
    <div style="width: 500px;  background:white;  border-radius: 15px; border:black 1px solid; margin: 20px auto">
        <form action="/profile/galleries/newGallery" method="post" class="p-2 " style="overflow:hidden">
            <h2 class="mb-5 pt-4" style="text-align:center">Create gallery</h2>
            <div>
                @if(isset($error))
                    <p>{{$error}}</p>
                @endif
            </div>
            <div class="mb-3 mt-3 b">
                <label for="name" class="form-label" style="font-size:18px; margin-left:15px;">Name:</label>
                <input type="text" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px"
                       id="name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="description" class="form-label"
                       style="font-size:18px; margin-left:15px;">Description:</label>
                <input type="text" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px"
                       id="description" name="description">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="hidden" name="hidden" checked>
                <label class="form-check-label" for="hidden">
                    Hidden
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="nsfw" name="nsfw" checked>
                <label class="form-check-label" for="nsfw">
                    Nsfw
                </label>
            </div>
            <a class="btn btn-secondary" style="color: white" href="/profile">Cancel</a>
            <button type="submit" class="btn btn-primary"
                    style="border-radius:10px; width:20%;float:right; margin-right:15px">Create
            </button>
        </form>
    </div>
@endsection