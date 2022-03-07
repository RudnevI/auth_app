<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllRoles(): \Illuminate\Http\JsonResponse
    {
        try {

            return response()->json(Role::all());
        }
        catch(Exception $exception) {

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {

        $role = Role::create($request->all());
        return response()->json(['Message' => 'CREATED', 'role' => $role], 201);
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
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());

        return response()->json($role, 200);
    }

    public function showOneRole($id): JsonResponse {

        if(Role::where('id', $id)->first() === null) {
            return response()->json(["Message" => "Not found"], 404);
        }
        return response()->json(Role::where('id', $id)->first());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function delete($id): \Illuminate\Http\Response
    {
        Role::where('id', $id)->first()->delete();
        return response('Deleted Successfully', 200);
    }
}
