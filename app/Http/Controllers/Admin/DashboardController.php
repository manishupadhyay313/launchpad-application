<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function editProfile(){
        $user = auth()->user();
        //dd($user);
        return view('admin.edit-profile', ['user' => $user]);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        //dd($request->parent_details[0]['name']);
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->address = $request->address;
        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $destinationPath = public_path('/images');
            $request->file('profile_picture')->move($destinationPath, $fileNameToStore);
            $user->profile_picture = $fileNameToStore;
        }
        $user->save();
        session()->flash('success', 'You are successfully updated');
        return redirect()->to('/admin/profile');
    }

    public function dashboard()
    {
        $users = User::whereNotIn('role_id', [1])->orderby('id', 'desc')->paginate(5);
        return view('admin.dashboard', ['users' => $users]);
    }

    public function editStudent($userId)
    {
        $user = User::find($userId);
        return view('admin.edit-student', ['user' => $user]);
    }
    public function editTeacher($userId)
    {
        $user = User::find($userId);
        return view('admin.edit-teacher', ['user' => $user]);
    }
    public function updateStaudent(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->assigned_teacher = $request->assigned_teacher;
        $user->status = $request->status;
        $user->save();
        $teacherData = User::find($user->assigned_teacher);
        $data['teacher'] = '<br>Yo have a teacher'.$teacherData->name;
        $data['name'] = $user->name;
        $data['status'] = $user->status;
        Mail::send('email/approval',$data, function($message) use ($user){
            $message->to('manishupadhyay.hestabit@gmail.com');
            $message->subject('Yor are approval by admin with assign a teacher');
        });
        session()->flash('success', 'Student are successfully updated');
        return redirect()->to('/admin/dashboard');
    }
    public function updateTeacher(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $request->status;
        $user->save();
        $data['name'] = $user->name;
        $data['teacher'] = '';
        $data['status'] = $user->status;
        Mail::send('email/approval',$data, function($message) use ($user){
            $message->to('manishupadhyay.hestabit@gmail.com');
            $message->subject('Yor are approval by admin');
        });
        session()->flash('success', 'Teacher are successfully updated');
        return redirect()->to('/admin/dashboard');
    }
}
