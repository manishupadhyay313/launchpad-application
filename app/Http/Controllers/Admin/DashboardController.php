<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $users = User::whereNotIn('role_id', [1])->orderby('id', 'desc')->get();
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
        session()->flash('success', 'You are successfully updated');
        return redirect()->to('/admin/dashboard');
    }
    public function updateTeacher(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $request->status;
        $user->save();
        session()->flash('success', 'You are successfully updated');
        return redirect()->to('/admin/dashboard');
    }
}
