<?php

namespace App\Http\Controllers;

use App\Http\Service\TokenService;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllTokens(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Token::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $token = new Token();
            $token->expiration_date = TokenService::getExpirationDate();
            $token->fill($request->all());
            $token->save();
        } catch (\Exception $th) {
            dd($th->getMessage());
        }

        return response()->json(['Message' => 'CREATED', 'token' => $token], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOneToken($id): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(Token::findOrFail($id));
        } catch (\Throwable $th) {
            return response()->json(['Message' => 'Not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $token = Token::findOrFail($id);
        $token->update($request->all());
        return response()->json($token);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Token::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
