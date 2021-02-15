<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\API\UserRequest;
use App\Http\Requests\API\UpdateUserDetailsRequest;
use App\Http\Resources\API\UserResource;

class Users extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(UserRequest $request)
    {   
        $data = $request->all();

        $newUser = User::create($data);

        return new UserResource($newUser);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserDetailsRequest $request, User $user)
    {
        $data = $request->all();

        $user->fill($data)->save();
        
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return response(null, 204);
    }
}
