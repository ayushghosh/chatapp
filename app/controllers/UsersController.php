<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
			'Email' => 'required|email'
			]);
	 	if($validator->fails()){
	 		echo json_encode(['status' => '0', 'message' => 'Invalid inputs']);
	 		return;
	 	}
		 $user = new User;

		 $user->username = Input::get('Username');
		 $user->password = Hash::make(Input::get('Password'));
		 $user->email = Input::get('Email');
		 $user->team = Input::get('Team');

		 try{
		 	$user->save();
		 }
		 catch(Exception $e){
		 	echo json_encode(['status' => '401', 'message' => 'Error saving data']);
		 	return;
		 }
		 if (Auth::attempt(array('username' => Input::get('Username'), 'password' => Input::get('Password'))))
			{
			    //return Redirect::intended('dashboard');
			    echo json_encode(['status' => '201', 'message' => 'User created & Logged In']); return;
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
			    echo json_encode(['status' => '200', 'message' => 'Logged In','team_id' => 'a']); return;
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
	public function destroy($id)
	{
		//
	}


}
