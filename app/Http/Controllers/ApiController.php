<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 202);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $responseArr = [];
        $responseArr['token'] = $user->createToken('myLaunchpad')->accessToken;
        $responseArr['name'] = $user->name;
        return response()->json($responseArr, 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $responseArr = [];
            $responseArr['token'] = $user->createToken('myLaunchpad')->accessToken;
            $responseArr['name'] = $user->name;
            return response()->json($responseArr, 200);
        } else {
            return response()->json(['error' => 'UN AUTHORIZED'], 203);
        }
    }

    public function getStudents()
    {
        $students = User::where('role_id', 3)->get();
        $responseArr = ['status' => 'ok', 'data' => $students];
        return response()->json($responseArr, 200);
    }
}
