@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="margin: 20px auto; max-width: 1200px;">
        <div>
            <h1 class="d-block mb-5 " style="text-align:center">IMGUR Clone</h1>
            <form id="imageForm" action ="/addImage" method="post" class=" d-inline-block p-2 align-self-center" style=" border:black 1px solid;  width:500px; background:white; border-radius: 15px; overflow:hidden" >
                <input type="file" id="fileName" name="fileName" />
                <input class="float-right" type="submit" id="submit" name="submit" value="Upload" />
            </form>
            <a href="/profile/subscription" class="btn-light btn float-right">Subscription plan</a>
        </div>
        <div>
            @if(!$result)
                <h3 class="d-block " style="text-align:center">ADD IMAGE</h3>
            @endif
            @if($result)
                    <h2 class="m-5" style="text-align:center">Profile images</h2>
                @foreach($result as $row)
                    <div class="d-inline-block m-3" >
                        <div>
                            <a href="/profile/comments/images/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px">
                                <img src={{$row->file_name}} class="mt-2" alt="{{$row->file_name}}">
                            </a>
                        </div>
                        <div class="text-center">
                            <a href="/profile/images/{{$row->imageId}}" class="btn btn-info d-inline-block" style="padding: 10px"><i class="fas fa-pen"></i></a>

                            <form action ="/delete/image/{{$row->imageId}}" method="post" class="d-inline-block m-1">
                                <input type="hidden" value="{{$row->imageId}}" name="imageId">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
<script type="text/javascript" src="../js/index.js"></script>