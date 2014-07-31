@extends('layouts.master')

@section('header__menuToggle')
	<div class="header__menuToggle"><i class="glyphicon glyphicon-tasks">&nbsp;</i>{{{ $account }}} </div>
@stop

@section('content')
<div class="page-header">
  <h1>Welcome to ChattApp <small>chat for dummies</small></h1>
</div>
@stop

@section('inlineJS')
@parent
<script type="text/javascript">
var formActive = 0;
		
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
@stop

@section('footer')
@parent
@stop