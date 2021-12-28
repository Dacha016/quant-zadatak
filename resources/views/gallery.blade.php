<?php
if (!isset($_SESSION["id"])) {
    header("Location: http://localhost/home");
}
?>
@extends("layout.main")
@section("content")
    <h1 class="d-block " style="text-align:center">IMGUR Clone</h1>
    <div style="margin: 20px auto; max-width: 1000px; text-align: center">
        <table>
            <tr>
                <th style="width: 20%">Gallery name</th>
                <th style="width: 20%">Gallery description</th>
            </tr>
            @foreach($result as $row)
                <tr>
                    <td><a href="/gallery/{{$row->slug}}">{{$row->name}}</a></td>
                    <td><p>{{$row->description}}</p></td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection