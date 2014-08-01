@extends('layouts.master')

@section('header__menuToggle')
<div style="display:inline-block;float:right;min-width:150px;"><a href="/logout" class="wf">logout ({{ Auth::user()->username}})</a></div>
<div style="display:inline-block;" class="header__menuToggle"><i class="glyphicon glyphicon-tasks">&nbsp;</i>Rooms</div>
@stop

@section('content')
<div class="page-header">
  <h1 class='chatGroup chatGrouplobby'>Welcome to lobby <span style="color:#fc6e51">{{ Auth::user()->username}}</span> <small>{{ $account }} Rooms</small></h1>
  @foreach($rooms as $room)
      <h1 class='chatGroup{{ $room->id }} chatGroup' style="display:none">{{ $room->room }} <span style="color:#fc6e51"> ({{ $room->topic }}) </span> <small> {{ $account }}</small></h1>
  @endforeach

</div>
@foreach($rooms as $room)
<div class='chatGroup{{ $room->id }} chatGroup' style="display:none">
    <div class="content__chatWindow col-lg-10">
        window
    </div>

    <div class="content__chatUsers col-lg-2">
        Users
    </div>
</div>

@endforeach
<div class="content__lobby chatGrouplobby">
    <ul class="list-unstyled">
@foreach($rooms as $room)

        <li class="chatRoom" data-chatRoom="{{ $room->id }}"><i class="glyphicon glyphicon-th-large">&nbsp;</i>{{ $room->room }}</li>

@endforeach
      </ul>
</div>

@stop

@section('outView')
    <div class="header__menu">
      <ul class="list-unstyled">
        <li class="chatRoom" data-chatRoom="lobby"><i class="glyphicon glyphicon-th-large">&nbsp;</i>lobby</li>
@foreach($rooms as $room)

        <li class="chatRoom" data-chatRoom="{{ $room->id }}"><i class="glyphicon glyphicon-th-large">&nbsp;</i>{{ $room->room }}</li>

@endforeach
      </ul>
      

    </div>
@stop
@section('inlineJS')
@parent
<script type="text/javascript">
var formActive = 0;
		
		$('document').ready(function(){
            $('.content').css("min-height",'100px');
            $('.content').css("height",window.innerHeight-180+'px');

            $('.header__menuToggle').click(function(){
                $('.header__menu').animate({left: '0px'},'fast');
            });

            $('.header__menu').mouseleave(function(){
                $('.header__menu').animate({left: '-200px'},'fast');
            });

            $('.chatRoom').click(function(){
                $('.content__lobby,.chatGroup,.chatBox').hide();
                var chatRoom = $(this).attr('data-chatRoom');
                $('.chatGroup'+chatRoom).show();

            });

            $('.footer__chatBox__submit').click(function(){
                var chatRoom = $(this).attr('data-chatRoom');
                var chatText = $('.chatText'+chatRoom).val();
                ajax('GET','/dochat','chat='+'{"from":{{ Auth::user()->id }},"room":'+chatRoom+',"message":"'+chatText+'"}')
            });
        });
		

function ajax(type,url,data)
{
	var returnData='';
	$.ajax({
            type: type,
            url: url,
            dataType: "json",
            async:false,
            data: data,
            success: function (data) {
            	returnData = data;
            },
            error: function (textStatus, errorThrown) {
                
            }

        });
	return returnData;
}

</script>
<script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
      if (window.console && window.console.log) {
        window.console.log(message);
      }
    };

    var pusher = new Pusher('bd51255b63e4d2408538');
    var channel = pusher.subscribe('chatApp');
    channel.bind('myevent', function(data) {
      alert(data.message);
    });
    @foreach($rooms as $room)
    channel.bind('chatGroup{{ $room->id }}', function(data) {
      alert(data.message);
    });
    @endforeach


  </script>
@stop

@section('footer')
<div class="container footer__chatBox">
    <div class="chatBox" data-chatRoom="{{ $room->id }}" style="display:none;">        
    </div>
@foreach($rooms as $room)
    <div class="chatBox chatGroup{{ $room->id }}" data-chatRoom="{{ $room->id }}" style="display:none;">
        <span class="col-lg-10"><textarea rows="3" class="chatText{{ $room->id }}"></textarea></span>
        <span class="col-lg-2"><div class="footer__chatBox__submit aqua1 wf"  data-chatRoom="{{ $room->id }}">Send</div></span>
    </div>
@endforeach
</div>
@stop