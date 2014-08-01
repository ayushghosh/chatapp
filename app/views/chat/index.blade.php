@extends('layouts.master')

@section('header__menuToggle')
<div style="display:inline-block;float:right;min-width:150px;"><a href="/logout" class="wf">logout ({{ Auth::user()->username}})</a></div>
@stop

@section('content')
<div class="page-header">
  <h1>Welcome to ChattApp <small>chat for dummies</small></h1>
</div>
<div class="content__buttons">
    <div class="content__buttons__loginForm" style="display:none;width:100%;text-align:left">
        <!--<form id="loginForm" action="/login" style="display:none;">-->
        <span class="col-sm-12">
            <label for="inputUsername1" class="col-sm-4">Room Name</label>
            <input type="text" class="col-sm-8" id="inputUsername1" placeholder="Room Name"> 
        </span>
        <br><br>
        <span class="col-sm-12">
            <label for="inputPassword1" class="col-sm-4">Topic</label>
            <input type="text" class="col-sm-8" id="inputPassword1" placeholder="Topic">
        </span>
        <!--</form>-->  
    </div>
    @if(Auth::user()->utype ==2 )
    <div class="content__buttons__signupForm" style="display:none;width:100%;text-align:left">
<!--    <form id="signupForm" action="/login" style="display:none;">
 -->        <span class="col-sm-12">
            <label for="inputUsername2" class="col-sm-4">Username</label>
            <input type="text" class="col-sm-8" id="inputUsername2" name="inputUsername2" placeholder="Username">   
        </span>
        <br><br>
        <span class="col-sm-12">
            <label for="inputPassword2" class="col-sm-4">Password</label>
            <input type="password" class="col-sm-8" id="inputPassword2" name="inputPassword2" placeholder="Password">   
        </span>
        <br><br>
        <span class="col-sm-12">
            <label for="inputEmail2" class="col-sm-4">Work email</label>
            <input type="email" class="col-sm-8" id="inputEmail2" name="inputEmail2" placeholder="Work Email">  
        </span>
        <br><br>
        <span class="col-sm-12">
            <label for="inputTeam2" class="col-sm-4">User Type</label>
            <input type="text" class="col-sm-8" id="inputTeam2" name="inputTeam2" placeholder="User Type" value="normal" disabled="true">  
        </span>
<!--        </form>
 -->    </div>
    @endif
    <br><br>

    <div class="content__buttons__login sunflower1 wf">Add Rooms</div>
    @if(Auth::user()->utype ==2 )
    
        <div class="content__buttons__signup darkgray1 wf">Add User</div>
    
    @endif
    <div class="content__buttons__cancel" style="display:none;">Cancel</div>
    <br><br><br><br><br>
    <div class="content__buttons__chat bittersweet1 wf" style="margin:0 auto; display:block; width:100px;">Chat</div>

</div>
@stop

@section('inlineJS')
@parent
<script type="text/javascript">
var formActive = 0;
        $('document').ready(function(){
            $('.content__buttons__login').click(function(){
                if(formActive==0)
                {
                    history.pushState(null, 'Login | ChatApp', 'addRoom');
                    formActive=1;
                    $('.content__buttons div').hide();
                    $('.content__buttons__loginForm,.content__buttons__login,.content__buttons__cancel').fadeIn('slow');
                }
                else
                {
                    login();
                }
            });
            $('.content__buttons__signup').click(function(){
                if(formActive==0)
                {
                    history.pushState(null, 'Signup | ChatApp', 'addUser');
                    formActive=1;
                    $('.content__buttons div').hide();
                    $('.content__buttons__signup').css('float','left');
                    $('.content__buttons__signupForm,.content__buttons__signup,.content__buttons__cancel').fadeIn('slow');
                }
                else
                {
                    signup();
                }
            });

            $('.content__buttons__cancel').click(function(){
                if(formActive==1)
                {
                    history.pushState(null, 'ChatApp', '/home');
                    formActive=0;
                    $('.content__buttons div').hide();
                    $('.content__buttons__signup').css('float','right');
                    $('.content__buttons__login,.content__buttons__signup,.content__buttons__chat').fadeIn('slow');
                }
            });

            $('.content__buttons__chat').click(function(){
                window.location.href='chat';
            });



            if(location.pathname=='/addRoom')
            {
                $('.content__buttons__login').click();
            }
            if(location.pathname=='/addUser')
            {
                $('.content__buttons__signup').click();
            }
        });

        function login()
        {
            //Should use jquery serialize, not using as form was breaking CSS and no time to fix
            var iUsername1 = $('#inputUsername1').val();
            var iPassword1 = $('#inputPassword1').val();
            var o2='';

            if(iUsername1=='' || iPassword1=='')
            {
                alert('input all');
            }
            else
            {
                o2 = ajax('POST','/addRoom','Username='+iUsername1+'&Password='+iPassword1);
                if(o2.status==201){
                   // window.location.href=location.protocol+'//'+o2.team_id+'.'+location.hostname+'/';
                   $('#inputUsername1').val(''); $('#inputPassword1').val('');
                   alert('Room Created');
                }
                else
                {
                    alert('Invalid Login');
                }
            }
        }
        function signup()
        {
            //Should use jquery serialize, not using as form was breaking CSS and no time to fix
            var iUsername2 = $('#inputUsername2').val();
            var iPassword2 = $('#inputPassword2').val();
            var iEmail2 = $('#inputEmail2').val();
            var iTeam2 = $('#inputTeam2').val();
            var o1='';

            if(iUsername2=='' || iPassword2=='' || iEmail2=='' || iTeam2=='' )
            {
                alert('input all');
            }
            else
            {
                o1 = ajax('POST','/signup','Username='+iUsername2+'&Password='+iPassword2+'&Email='+iEmail2+'&Type=1&Team='+'{{ Auth::user()->team }}');
                if(o1.status==201){
                    //window.location.href=location.protocol+'//'+iTeam2+'.'+location.hostname+'/';
                    $('#inputUsername2').val('');
                    $('#inputPassword2').val('');
                    $('#inputEmail2').val('');
                    $('#inputTeam2').val('');
                    alert('User Created');
                }
                else
                {
                    alert('Invalid data');
                }
            }
        }

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
@stop

@section('footer')
@parent
@stop