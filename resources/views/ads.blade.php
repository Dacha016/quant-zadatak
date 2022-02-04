@extends("layout.main")
<?php
if (!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="width: 500px;  background:white;  border-radius: 15px; border:black 1px solid; margin: 20px auto">
        <form action="/ads" method="post" class="p-2" style="overflow:hidden">
            <h2 class="mb-5 pt-4" style="text-align:center">Create Ad</h2>
            @if(isset($error))
                <p>{{$error}}</p>
            @endif
            <div class="mb-3 mt-3">
                <label for="advertiser" class="form-label" style="font-size:18px; margin-left:15px;">Advertiser:</label>
                <input type="text" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px"
                       id="advertiser" name="advertiser">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label" style="font-size:18px; margin-left:15px;">Content:</label>
                <input id="content" type="content" class="form- control d-block p-2"
                       style="width:95%;margin:10px auto; border-radius:10px" name="content">
            </div>
            <button class="btn btn-secondary d-inline-block" type="submit"><a style="float:right; color: white"
                                                                              href="/profile">Cancel</a></button>
            <button type="submit" class="btn btn-primary"
                    style="border-radius:10px; width:20%;float:right; margin-right:15px">Create
            </button>
        </form>
    </div>

    @if( isset($result))
        <div class="float-right">
            <h2 style="text-align: center;">Ads</h2>
            <table style="text-align: center; margin: 0 auto">
                <tr>
                    <th style=" border: 1px solid black ">Advertiser</th>
                    <th style=" border: 1px solid black ">Content</th>
                </tr>
                @foreach($result as $row)
                    <tr>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->advertiser}}</p>
                        </td>
                        <td style="text-align: center; border: 1px solid black ">
                            <p>{{$row->content}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif
        </div>
@endsection