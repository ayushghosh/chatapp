@extends('layouts.master')

@section('header__menuToggle')

@stop

@section('content')
<div class="page-header">
  <h1>Welcome to ChatApp <small>chat for dummies</small></h1>
</div>
<div class="content__buttons">
	<div class="content__buttons__loginForm" style="display:none;width:100%;text-align:left">
		<!--<form id="loginForm" action="/login" style="display:none;">-->
		<span class="col-sm-12">
			<label for="inputUsername1" class="col-sm-4">Username</label>
			<input type="text" class="col-sm-8" id="inputUsername1" placeholder="Username">	
		</span>
		<br><br>
		<span class="col-sm-12">
    		<label for="inputPassword1" class="col-sm-4">Password</label>
      		<input type="password" class="col-sm-8" id="inputPassword1" placeholder="Password">
		</span>
		<!--</form>-->	
	</div>
	<div class="content__buttons__signupForm" style="display:none;width:100%;text-align:left">
<!-- 	<form id="signupForm" action="/login" style="display:none;">
 -->		<span class="col-sm-12">
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
			<label for="inputTeam2" class="col-sm-4">Team name</label>
			<input type="text" class="col-sm-8" id="inputTeam2" name="inputTeam2" placeholder="Team name">	
		</span>
<!-- 		</form>
 -->	</div>
	<br><br>
	<div class="content__buttons__login grass1 wf">Login</div>
	<div class="content__buttons__signup aqua1 wf">Sign up</div>
	<div class="content__buttons__cancel" style="display:none;">Cancel</div>
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
					history.pushState(null, 'Login | ChatApp', 'login');
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
					history.pushState(null, 'Signup | ChatApp', 'signup');
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
					$('.content__buttons__login,.content__buttons__signup').fadeIn('slow');
				}
			});

			if(location.pathname=='/login')
			{
				$('.content__buttons__login').click();
			}
			if(location.pathname=='/signup')
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
				o2 = ajax('POST','/login','Username='+iUsername1+'&Password='+iPassword1);
				if(o2.status==200){
					window.location.href=location.protocol+'//'+o2.team_id+'.'+location.hostname+'/';
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
				o1 = ajax('POST','/signup','Username='+iUsername2+'&Password='+iPassword2+'&Email='+iEmail2+'&Type=2&Team='+iTeam2);
				if(o1.status==201){
					window.location.href=location.protocol+'//'+iTeam2+'.'+location.hostname+'/';
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

@stop