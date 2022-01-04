@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@section("content")
    <div style="margin: 20px auto; width: 1200px;">
        <h1 style="text-align:center; margin: 0 auto">Galleries</h1>
        @if($_SESSION["role"] === "user" )
            <table class="justify-content-center" style="text-align: center;">
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
            <table style="text-align: center; margin: 0 auto">
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
                            <a href="http://localhost/profile/users/{{$row->id}}?page=0"> {{$row->username}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->email}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->role}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->active}}</p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit"><a style="color: white" href="http://localhost/profile/update/users/{{$row->id}}?page={{$_GET['page']}}">Update</a></button>
                        </td>
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
                        <a class="page-link" href="?page=0" disabled> << </a>
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