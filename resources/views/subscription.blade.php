@extends("layout.main")
<?php
if(!isset($_SESSION["id"])) {
    header("Location: /home");
}
?>
@section("content")
    <div style="width: 1200px; margin: 10px auto">
        <h1  style="text-align: center">Subscription</h1>
        @if( isset($noData) )
            <h2  style="text-align: center">{{$noData}}</h2>
        @endif
        @if(!isset($user) && isset($result))
            <form action="/profile/subscription" method="post" class="p-2 float-left" style=" margin:50px ; border:black 1px solid;
            width:500px; background:white; border-radius: 15px; overflow:hidden">
                <h2 class="mb-5 pt-4" style="text-align:center">Subscription</h2>
                <div>
                    <label for="subscription">Choose a plan:</label>
                    <select id="subscription" name="subscription">
                        @if($_SESSION["plan"] == "Free" )
                            <option value="Free" selected>Free</option>
                        @endif
                        <option value="Free">Free</option>
                        @if($_SESSION["plan"] == "Month" )
                            <option value="Month" selected>1 Month</option>
                        @endif
                        <option value="Month">1 Month</option>
                        @if($_SESSION["plan"] == "6 months" )
                            <option value="6 months" selected>6 Months</option>
                        @endif
                        <option value="6 months">6 Months</option>
                        @if($_SESSION["plan"] == "Year")
                            <option value="Year" selected>1 Year</option>
                        @endif
                        <option value="Year">1 Year</option>
                    </select>
                </div>
                <div class="m-3">
                    <a class="btn btn-secondary" style="color: white" href="/profile">Cancel</a>
                    <button class="btn btn-success d-inline-block float-right" type="submit">Update</button>
                </div>
                @if(isset($error))
                    <p>{{$error}}</p>
                @endif
            </form>
        @endif
        @if( isset($result))
            <div class="float-right">
                <h2 style="text-align: center;">Subscription plan</h2>
                <table style="text-align: center; margin: 0 auto">
                    <tr>
                        <th style=" border: 1px solid black ">Subscription plan</th>
                        <th style=" border: 1px solid black ">Start</th>
                        <th style=" border: 1px solid black ">End</th>
                        <th style=" border: 1px solid black ">Active</th>
                    </tr>
                    @foreach($result as $row)
                        <tr>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->plan}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->start}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->end}}</p>
                            </td>
                            <td style="text-align: center; border: 1px solid black ">
                                <p>{{$row->active}}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>
@endsection