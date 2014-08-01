@extends('layouts.master')

@section('header__menuToggle')
<div style="display:inline-block;float:right;min-width:150px;"><a href="/logout" class="wf">logout ({{ Auth::user()->username}})</a></div>
<div style="display:inline-block;" class="header__menuToggle"><i class="glyphicon glyphicon-tasks">&nbsp;</i>Chat Rooms</div>
<div style="display:inline-block;" class="" onclick="window.location.href='home'"><i class="glyphicon glyphicon-home">&nbsp;</i>home</div>
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
        <ul class="chatWindow{{ $room->id }} chatWindow list-unstyled">
            <!-- <li>
                <span class="chatWindow__userTime">
                    <span class="chatWindow__username">Ayush Ghosh</span> <br>               
                    <span class="chatWindow__chattime">3 mins</span>
                </span>
                <span class="chatWindow__chattext">test is here</span>
            </li> -->
        </ul>
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
        <li class="chatRoom" data-chatRoom="lobby"><i class="glyphicon glyphicon-th">&nbsp;</i>lobby</li>
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
            $('.content__chatWindow').css("height",window.innerHeight-350+'px');

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
      //alert(data.from);
    });
    @foreach($rooms as $room)
    channel.bind('chatGroup{{ $room->id }}', function(data) {
      Notify(data,'{{ $room->id }}');
    });
    @endforeach

    function Notify(chatData,room)
    {
        $('ul.chatWindow'+room).append('<li><span class="chatWindow__userTime"><span class="chatWindow__username">'+chatData.from+'</span><br><span class="chatWindow__chattime">'+'few moments ago'+'</span></span><span class="chatWindow__chattext">'+chatData.message+'</span></li>');
        $(".content__chatWindow").animate({ scrollTop: $('ul.chatWindow'+room).height() },500);
    }
    


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