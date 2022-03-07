<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showAllUsers(): \Illuminate\Http\JsonResponse
    {
        try {
        return response()->json(User::with("role")->get());
        }
        catch(Exception $e) {

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
        $user = User::create($request->all());
        return response()->json(['Message' => 'CREATED', 'user' => $user], 201);
        }
        catch(Exception $e) {

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    public function showOneUser($id): JsonResponse {

        try {
            $user = User::findOrFail($id)->first();
            return response()->json($user->toArray());
        }
        catch(Exception $e) {
            return response()->json(["Message" => "Not found"], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function delete($id): \Illuminate\Http\Response
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function findByRoleName($roleId): \Illuminate\Http\JsonResponse
    {
        return response()->json(User::with("roles")->find($roleId));
    }

    public function getUserRoleByToken(Request $request) {
        $bearerToken = $request->bearerToken();
        try {
            $userId = Token::where("access_token", '=', $bearerToken)->get()->firstOrFail()->user_id;
            $user = User::findOrFail($userId);

        }
        catch(Exception $e) {

        }
    }

    public function getUserById($id) {

    }
}
