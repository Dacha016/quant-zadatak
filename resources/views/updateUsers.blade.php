@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <?php  $page = $_GET["page"] ?>
    <form action="/profile/update/users/{{$result->username}}?page={{$page}}" method="post"
          class="p-2 align-self-center"
          style="margin-left: 35vw; margin-top:20Vh; border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden">
        <h2 class="mb-2 pt-4" style="text-align:center">Update</h2>
        <h3 style="text-align:center">{{$result->username}}</h3>
        @if(isset($error))
            <div class="mb-3 mt-3 b">
                <p>{{$error}}</p>

            </div>
        @endif
        <input type="hidden" name="userId" value={{$result->id}}>
        <input type="hidden" name="username" value={{$result->username}}>
        <input type="hidden" name="page" value={{$page}}>
        <div>
            <label for="role">Choose a role:</label>
            <select id="role" name="role">
                <option value="">Select</option>
                <option value="admin">Admin</option>
                <option value="moderator">Moderator</option>
                <option value="user">User</option>
            </select>
        </div>
        <div class="form-check mb-3 ml-3">
            <label class="form-check-label" for="nsfw">
                @if($result->nsfw)
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw"
                           value={{$result->nsfw}} checked>
                @endif
                @if(!$result->nsfw)
                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw"
                           value="{{$result->nsfw}}">
                @endif
                <label>Nsfw</label>
            </label>
        </div>

        <div class="form-check ml-3 ">
            <label class="form-check-label" for="active">
                @if($result->active)
                    <input class="form-check-input" type="checkbox" id="active" name="active"
                           value={{$result->active}} checked>
                @endif
                @if(!$result->active)
                    <input class="form-check-input" type="checkbox" id="active" name="active"
                           value="{{$result->active}}">
                @endif
                <label>Active</label>
            </label>
        </div>

        <div class="m-3">
            <a class="btn btn-secondary" style="color: white" href="/profile/users?page={{$page}}">Cancel</a>
            <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
        </div>
    </form>
@endsection