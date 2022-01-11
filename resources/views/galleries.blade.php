@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
header("Location: http://localhost/home");
}
?>
@section("content")
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        <table style="text-align: center;">
            <tr>
                <th style=" border: 1px solid black ">Name</th>
                <th style="border: 1px solid black">Description</th>
                <th style="border: 1px solid black">Slug</th>
                <th style="border: 1px solid black">Hidden</th>
                <th style="border: 1px solid black">Nsfw</th>
            </tr>
            @foreach($result as $row)
                <tr>
                    @if($_SESSION["role"] === "admin" && $row->userId === $_SESSION["id"])

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/{{$row->galleryId}}">{{$row->name}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->description}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->slug}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->hidden}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    @endif
                        @if($_SESSION["role"] === "admin" && $row->userId !== $_SESSION["id"])

                            <td style="margin: 0 auto; border: 1px solid black">
                                <a href="/profile/users/{{$row->userId}}/{{$row->galleryId}}?page=0">{{$row->name}}</a>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->description}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->slug}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->hidden}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->nsfw}}</p>
                            </td>
                            <td>
                                <button class="btn btn-info d-inline-block" type="submit">
                                    <a style="color: white" href="http://localhost/profile/update/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-pen"></i></a>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger d-inline-block" type="submit">
                                    <a style="color: white" href="http://localhost/delete/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-trash"></i></a>
                                </button>
                            </td>
                        @endif
                    @if($row->userId === $_SESSION["id"] && $_SESSION["role"] === "moderator")

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/{{$row->galleryId}}">{{$row->name}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->description}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->slug}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->hidden}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    @endif
                    @if($row->userId !== $_SESSION["id"] && $_SESSION["role"] === "moderator")
                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/users/{{$row->userId}}/{{$row->galleryId}}?page=0">{{$row->name}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->description}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->slug}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->hidden}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>

                    @endif
                    @if($row->userId === $_SESSION["id"] && $_SESSION["role"] === "user")

                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/galleries/{{$row->galleryId}}">{{$row->name}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->description}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->slug}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->hidden}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                        <td>
                            <button class="btn btn-info d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/profile/update/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-pen"></i></a>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger d-inline-block" type="submit">
                                <a style="color: white" href="http://localhost/delete/gallery/{{$row->galleryId}}?page={{$_GET['page']}}"><i class="fas fa-trash"></i></a>
                            </button>
                        </td>
                    @endif
                    @if($row->userId !== $_SESSION["id"] && $_SESSION["role"] === "user")
                        <td style="margin: 0 auto; border: 1px solid black">
                            <a href="/profile/users/{{$row->userId}}/{{$row->galleryId}}">{{$row->name}}</a>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->description}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->slug}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->hidden}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->nsfw}}</p>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
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
