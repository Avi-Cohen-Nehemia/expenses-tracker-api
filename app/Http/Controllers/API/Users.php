<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\User;
use App\Http\Requests\API\UserRequest;
use App\Http\Requests\API\UpdateUserDetailsRequest;
use App\Http\Resources\API\UserResource;
use Symfony\Component\HttpFoundation\Response;

class Users extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(UserRequest $request)
    {   
        try {
            $data = $request->all();

            $newUser = User::create($data);

            return new UserResource($newUser);

        } catch (QueryException $error) {

            $title = "";
            $text = "";

            if (isset($request->name)) {
                $title = "Username already taken";
                $text = "Please try a different username";
            }

            return response()->json([
                'errors' => [
                    "title" => $title,
                    "text" => $text
                ]
            ], Response::HTTP_CONFLICT);
        }
        
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserDetailsRequest $request, User $user)
    {
        try {
            $data = $request->all();
            $user->fill($data)->save();

            return new UserResource($user);

        } catch (QueryException $error) {

            if (isset($request->name)) {
                return response()->json([
                    'errors' => [
                        "title" => "Username already taken",
                        "text" => "Please try a different username"
                    ]
                ], Response::HTTP_CONFLICT);
            }

            if (isset($request->email)) {
                return response()->json([
                    'errors' => [
                        "title" => "Email already taken",
                        "text" => "Please try a different email"
                    ]
                ], Response::HTTP_CONFLICT);
            }

            return response()->json([
                'errors' => [
                    "title" => "Oops... Something went wrong",
                    "text" => "Please try again"
                ] 
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return response(null, 204);
    }
}
