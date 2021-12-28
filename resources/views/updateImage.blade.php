@extends("layout.main")
@section("content")
    <form action="/moderator/update" method="post" class="p-2 align-self-center" style="margin:10px auto; margin-top:20Vh; border:black 1px solid;
   width:500px; background:white; border-radius: 15px; overflow:hidden">
        <h2 class="mb-5 pt-4" style="text-align:center">Update image</h2>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="1">
            <label class="form-check-label" for="hidden">Hidden</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="1">
            <label class="form-check-label" for="nsfw">Nsfw</label>
        </div>
        <button type="submit" class="btn btn-primary" style="border-radius:10px; width:20%;float:right; margin-right:15px">Update</button>
    </form>
@endsection