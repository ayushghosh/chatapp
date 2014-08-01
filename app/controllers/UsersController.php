<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function doChat()
	{
		Input::merge(array_map('trim', Input::all()));
		$chat = Input::get('chat');
		$chat = json_decode($chat);
		$pusher = new Pusher('bd51255b63e4d2408538', '7841a925632e5a93c1ed','83817');
		$pusher->trigger('chatApp', 'chatGroup'.$chat->room,['from'=> $chat->from , 'message' => $chat->message]);
		echo json_encode(['status'=>1]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function addRoom()
	{
		Input::merge(array_map('trim', Input::all()));
	 	$validator = Validator::make(Input::all(),
	 		[
			'Username' => 'required|unique:users|alpha_dash',
			'Password' => 'required|alpha_dash'
			]);
	 	if($validator->fails()){
	 		echo json_encode(['status' => '0', 'message' => 'Invalid inputs']);
	 		return;
	 	}
	 	$room = new Room;
	 	$room->team = Auth::user()->team;
	 	$room->room = Input::get('Username');
	 	$room->topic = Input::get('Password');
	 	try{
			$room->save();
	 	}
	 	
	 	catch(Exception $e){
		 	echo json_encode(['status' => '401', 'message' => 'Error saving data']);
		 	return;
		 }
		echo json_encode(['status' => '201', 'message' => 'Room created']);

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Input::merge(array_map('trim', Input::all()));
	 	$validator = Validator::make(Input::all(),
	 		[
			'Username' => 'required|unique:users|alpha_dash|min:5',
			'Password' => 'required|alpha_num|between:4,32',
			'Email' => 'required|email',
			'Team' => 'required|unique:teams|alpha_dash'
			]);
	 	if($validator->fails()){
	 		echo json_encode(['status' => '0', 'message' => 'Invalid inputs']);
	 		return;
	 	}
		 $user = new User;

		 $user->username = Input::get('Username');
		 $user->password = Hash::make(Input::get('Password'));
		 $user->email = Input::get('Email');
		 
		 if(Input::get('Type')==2) {$user->team = '-1';}
		 else {$user->team = Input::get('Team');}
		 $user->remember_token = '';
		 $user->utype = Input::get('Type');


		 try{
		 	$user->save();

		 	if(Input::get('Type')==2)
			 {
			 	$team = new Team;
			 	$team->user = $user->id;
			 	$team->team = Input::get('Team');
			 	$team->save();
				$user->team = $team->id;
				$user->save();
			 }

		 }
		 catch(Exception $e){
		 	echo json_encode(['status' => '401', 'message' => 'Error saving data'.$validator->messages()]);
		 	return;
		 }
		 if(Input::get('Type')==2)
		 {
		 	if (Auth::attempt(array('username' => Input::get('Username'), 'password' => Input::get('Password'))))
			{
			    //return Redirect::intended('dashboard');
			    echo json_encode(['status' => '201', 'message' => 'User created & Logged In']); return;
			}
		}
			    echo json_encode(['status' => '201', 'message' => 'User created']);

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function login()
	{
		Input::merge(array_map('trim', Input::all()));
	 	$validator = Validator::make(Input::all(),
	 		[
			'Username' => 'required|alpha_dash|min:5',
			'Password' => 'required|alpha_num|between:4,32'			
			]);
	 	if($validator->fails()){
	 		echo json_encode(['status' => '0', 'message' => 'Invalid inputs']);
	 		return;
	 	}
	 	if (Auth::attempt(array('username' => Input::get('Username'), 'password' => Input::get('Password'))))
			{
				$team_id = Team::find(Auth::user()->team);
				
			    echo json_encode(['status' => '200', 'message' => 'Logged In','team_id' =>$team_id->team]); return;
			}
			else
			{
				echo json_encode(['status' => '403', 'message' => 'Invalid Login']); return;
			}


	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function logout()
	{
		//
	}


}
