<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">Galleries</h1>
    <div style="margin: 20px auto; max-width: 1000px;" >
        <table style="text-align: center;">
            <tr >
                <th style="width: 33%; border: 1px solid black ">Gallery name</th>
                <th style="width: 33%; border: 1px solid black">Gallery description</th>
            </tr>
            @foreach($result as $row)
                <tr>
                    <td style="margin: 0 auto; border: 1px solid black"><a href="/gallery/{{$row->slug}}">{{$row->name}}</a></td>
                    <td style="text-align: center; border: 1px solid black "><p>{{$row->description}}</p></td>
                    @if($row->user_id === $_SESSION["id"] || $_SESSION["role"] !== "user")
                        <td style="border: 1px solid black">
                            <form action ="#" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->slug}}" name="adminModeratorUpdate">
                                <button class="btn btn-info d-inline-block" type="submit">UPDATE</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

    </div>
@endsection