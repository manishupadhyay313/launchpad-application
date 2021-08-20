<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class StudentApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'address' => 'required',
            'current_school' => 'required',
            'previous_school' => 'required',
            'parent_details' => 'required',
            'assigned_teacher' => 'required',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 202);
        }
        $input = $request->all();
        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = public_path('/images');
            $request->file('profile_picture')->move($destinationPath, $fileNameToStore);
        }
        $input['profile_picture'] = $fileNameToStore;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $responseArr = [];
        $responseArr['msg'] = "You are successfully register and wait for admin approval";
        $responseArr['student'] = $user;
        return response()->json($responseArr, 200);
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 202);
        }

        $credentials = request(['email', 'password']);
        
        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $userStatus = Auth::User()->status;
        if ($userStatus == 'inactive') {
            return response()->json(['error' => 'You are not active. please contact to admin'], 203);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function updateStudent(Request $request, $userId){
        $user = User::find($userId);
        if($user->id == Auth::user()->id){
          dd($request->all());
        }else{
            return response()->json(['error'=>'You are not login']);
        }
    }
    public function profile(Request $request){
        $user = Auth::user();
        if($user){
          return response()->json(['profile'=>$user],200);
        }else{
            return response()->json(['error'=>'You are not login']);
        }
    }
}
