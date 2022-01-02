@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        @if($_SESSION["role"] === "user" )
            <table style="text-align: center;">
                <tr>
                    <th style=" border: 1px solid black ">Username</th>
                    <th style="border: 1px solid black">Email</th>
                </tr>
                @foreach($result as $row)
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <a href="/profile/users/{{$row->id}}?page=0"> {{$row->username}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->username}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if($_SESSION["role"] === "admin" || $_SESSION["role"] === "moderator")
            <table style="text-align: center;">
                <tr>
                    <th style=" border: 1px solid black ">Username</th>
                    <th style="border: 1px solid black">Email</th>
                    <th style="border: 1px solid black">Role</th>
                    <th style="border: 1px solid black">Nsfw</th>
                    <th style="border: 1px solid black">Active</th>
                </tr>
                @foreach($result as $row)
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <a href="/profile/users/{{$row->id}}?page=0"> {{$row->username}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->username}}</p>
                        </td>
                        <form action="/profile/update/users/{{$row->id}}" method="post" >
                            <input type="hidden" name = "userId" value={{$row->id}}>
                            <input type="hidden" name = "username" value={{$row->username}}>
                            <td style="text-align: center; border: 1px solid black ">
                                <input name="role" value="{{$row->role}}">
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                @if($row->nsfw)
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                @endif
                                @if(!$row->nsfw)
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$row->nsfw}}">
                                @endif
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                @if($row->active)
                                    <input class="form-check-input" type="checkbox" id="active" name="active" value={{$row->active}} checked>
                                @endif
                                @if(!$row->active)
                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="{{$row->active}}">
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </table>
        @endif
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                @if($_GET["page"] > 0)
                    <li class="page-item" >
                        <a class="page-link" href="?page=0" > << </a>
                    </li>
                @endif
                @if($_GET["page"] === 0)
                    <li class="page-item" disabled>
                        <a class="page-link" href="?page=0" > << </a>
                    </li>
                @endif
                @if($_GET["page"] < 0)
                    <li class="page-item disabled">
                        <a class="page-link" href="?page=0">Previous</a>
                    </li>
                @endif
                @if($_GET["page"] > 0)
                    <li class="page-item">
                        <a class="page-link" href="?page= {{$_GET["page"] - 1 }}">Previous</a>
                    </li>
                @endif
                @if($_GET["page"] > $pages)
                    <li class="page-item disabled">
                        <a class="page-link" href="?page= {{$_GET["page"]=$pages }}">Next</a>
                    </li>
                @endif
                @if($_GET["page"] < $pages)
                    <li class="page-item">
                        <a class="page-link" href="?page= {{$_GET["page"] + 1 }}">Next</a>
                    </li>
                @endif
                @if($_GET["page"] < $pages)
                    <li class="page-item" >
                        <a class="page-link" href="?page={{$pages}}" > >> </a>
                    </li>
                @endif
                @if($_GET["page"] === $pages)
                    <li class="page-item" disabled>
                        <a class="page-link" href="?page={{$pages}}" > >> </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endsection