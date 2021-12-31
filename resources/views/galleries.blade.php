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
                    @if($row->user_id === $_SESSION["id"])
                    <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/galleries/{{$row->galleryId}}">{{$row->name}}</a></td>
                    @endif
                    @if($row->user_id !== $_SESSION["id"])
                        <td style="margin: 0 auto; border: 1px solid black"><a href="/profile/users/{{$row->user_id}}/{{$row->galleryId}}">{{$row->name}}</a></td>
                    @endif
                    @if($_SESSION["role"] === "admin" )
                        <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                            <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                            <input type="hidden" name="user_id" value="{{$row->user_id}}">
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
                            <td>
                                <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                            </td>
                        </form>
                    @endif
                    @if($_SESSION["role"] === "moderator" )
                        <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                            <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                            <input type="hidden" name="user_id" value="{{$row->user_id}}">
                            @if($row->user_id === $_SESSION["id"])
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
                                <td>
                                    <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                                </td>
                            @endif
                            @if($row->user_id != $_SESSION["id"])
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
                            @endif
                        </form>
                    @endif
                    @if($_SESSION["role"] === "user")
                        <form action="/profile/update/gallery/{{$row->galleryId}}" method="post" >
                            <input type="hidden" name="galleryId" value="{{$row->galleryId}}">
                            <input type="hidden" name="user_id" value="{{$row->user_id}}">
                            @if($row->user_id === $_SESSION["id"])
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
                                        <input class="form-check-input" type="checkbox" id="hidden" name="hidden" value="{$row->hidden}}">
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
                                <td>
                                    <button class="btn btn-danger d-inline-block" type="submit">DELETE</button>
                                </td>
                            @endif
                            @if($row->user_id != $_SESSION["id"])
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
                        </form>
                    @endif
                </tr>
            @endforeach
        </table>
        @if($row->user_id !== $_SESSION["id"])
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item ">
                        <a class="page-link" href="?page= {{abs($_GET["page"]-1) }}" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page= {{abs($_GET["page"]+1) }}">Next</a>
                    </li>
                </ul>
            </nav>
        @endif


        @if($row->user_id === $_SESSION["id"])
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item ">
                        <a class="page-link" href="/profile/galleries?page= {{abs($_GET["page"]-1) }}" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="/profile/galleries?page={{$_GET["page"]+1 }}">Next</a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
@endsection
