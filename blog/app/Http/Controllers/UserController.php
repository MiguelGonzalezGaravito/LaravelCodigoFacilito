<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Laracasts\Flash\Flash;

use App\Http\Requests\UserRequest;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users = User::orderBy('id', 'ASC')->paginate(3);
		return view('admin.users.index')->with('users', $users);
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UserRequest $request)
	{
		//
		$user = new User($request->all());
		$user->password = bcrypt($request->password);
		$user->save();
		Flash::success("Se ha registrado ". $user->name ." de manera exitosa !" );

		return redirect()->route('admin.users.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//

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
		$user = User::find($id);
		return view('admin.users.edit')->with('user', $user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$user = User::find($id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->type = $request->type;
		$user->save();

		Flash::warning('El usuario '. $user->name .' ha sido editado con exito');
		return redirect()->route('admin.users.index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();

		Flash::error('El usuario '. $user->name ." ha sido borrado de forma exitosa");
		return redirect()->route('admin.users.index');
	}

}
