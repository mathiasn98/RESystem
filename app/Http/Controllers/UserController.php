<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;

class UserController extends Controller
{
    public function getAllUser(Request $request)
    {
        $response = User::where('username', 'like', '%' . $request->getContent() . '%')->get();
        $response = json_decode($response, true);
        return $response;
    }
}
