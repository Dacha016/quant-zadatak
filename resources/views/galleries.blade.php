@extends("layout.main")
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
                    @if($row->userId === $_SESSION["id"])
                    <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/galleries/{{$row->galleryId}}">{{$row->name}}</a></td>
                    @endif
                    @if($row->userId !== $_SESSION["id"])
                        <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/users/{{$row->userId}}/{{$row->galleryId}}">{{$row->name}}</a></td>
                    @endif
                    @if($_SESSION["role"] === "admin" )
                        <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                            <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                            <input type="hidden" name="userId" value="{{$row->userId}}">
                            <td style="text-align: center; border: 1px solid black ">
                                <input name="description" value="{{$row->description}}">
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <input name="slug" value="{{$row->slug}}">
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                @if($row->hidden)
                                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                @endif
                                @if(!$row->hidden)
                                    <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$row->hidden}}">
                                @endif
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                @if($row->nsfw)
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                @endif
                                @if(!$row->nsfw)
                                    <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$row->nsfw}}">
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </td>
                        </form>
                        <form action ="/delete/gallery/{{$row->galleryId}}" method="post" class="d-inline-block m-1">
                            <td>
                                <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                                <input type="hidden" value="{{$row->userId}}" name="userId">
                                <button class="btn btn-danger" type="submit">DELETE</button>
                            </td>
                        </form>
                    @endif
                    @if($_SESSION["role"] === "moderator" )
                        @if($row->userId === $_SESSION["id"])
                            <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                                <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="description" value="{{$row->description}}">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="slug" value="{{$row->slug}}">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                    @endif
                                    @if(!$row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$row->hidden}}">
                                    @endif
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                    @endif
                                    @if(!$row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$row->nsfw}}">
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                            </form>
                            <form action ="/delete/gallery/{{$row->galleryId}}" method="post" class="d-inline-block m-1">
                                <td>
                                    <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                                    <input type="hidden" value="{{$row->userId}}" name="userId">
                                    <button class="btn btn-danger" type="submit">DELETE</button>
                                </td>
                            </form>
                        @endif
                        @if($row->userId != $_SESSION["id"])
                            <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                                <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <input type="hidden" name="userUsername" value="{{$row->username}}">
                                <td style="text-align: center; border: 1px solid black ">
                                    <p>{{$row->description}}</p>
                                    <input type="hidden" name="description" value="{{$row->description}}">
                                </td>

                                <td style="text-align: center; border: 1px solid black ">
                                    <p>{{$row->slug}}</p>
                                    <input type="hidden" name="description" value="{{$row->slug}}">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                    @endif
                                    @if(!$row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$row->hidden}}">
                                    @endif
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                    @endif
                                    @if(!$row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$row->nsfw}}">
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                            </form>
                        @endif
                    @endif
                    @if($_SESSION["role"] === "user")
                        @if($row->userId === $_SESSION["id"])
                            <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                                <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                                <input type="hidden" name="userId" value="{{$row->userId}}">
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="description" value="{{$row->description}}">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    <input name="slug" value="{{$row->slug}}">
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value={{$row->hidden}} checked>
                                    @endif
                                    @if(!$row->hidden)
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{{$row->hidden}}">
                                    @endif
                                </td>
                                <td style="text-align: center; border: 1px solid black ">
                                    @if($row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value={{$row->nsfw}} checked>
                                    @endif
                                    @if(!$row->nsfw)
                                        <input class="form-check-input" type="checkbox" id="nsfw" name="nsfw" value="{{$row->nsfw}}">
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                                </td>
                            </form>
                            <form action ="/delete/gallery/{{$row->galleryId}}" method="post" class="d-inline-block m-1">
                                <td>
                                    <input type="hidden" value="{{$row->galleryId}}" name="galleryId">
                                    <input type="hidden" value="{{$row->userId}}" name="userId">
                                    <button class="btn btn-danger" type="submit">DELETE</button>
                                </td>
                            </form>
                        @endif
                        @if($row->userId != $_SESSION["id"])
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->description}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->description}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->hidden}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->nsfw}}</p>
                            </td>
                        @endif
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
