<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
//use Intervention\Image\ImageManagerStatic as Image;
use App\User;


class UserCOntroller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        return User::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|min:6',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $currentPhoto = $user->photo;

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
        ]);

        if($request->photo != $currentPhoto){
            $name = time().'.'.explode('/', explode(':', substr($request->photo, 0 ,strpos( $request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if(file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        };

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user ->update($request->all());
        return ['message' => 'Sucessfully Updated'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
        ]);

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user ->update($request->all());
        return ['message' => 'User Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        $user -> delete();

        return ['message' => 'User deleted successfully'];
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $this->authorize('isAdmin');
        if($search = \Request::get('q')) {
            $users = User::where(function($query) use($search) {
                $query->where('name','LIKE',"%$search%")
                ->orWhere('email','LIKE',"%$search%")
                ->orWhere('type','LIKE',"%$search%");
            })->paginate(20);
        } else {
            $users = User::latest()->paginate(20);
        }

        return $users;
    }
}
