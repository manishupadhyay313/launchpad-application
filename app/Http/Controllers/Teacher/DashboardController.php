<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTeacherProfileRequest;
use App\Models\Subject;
use App\Models\TeacherProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $teacherProfile = TeacherProfile::where('user_id', Auth::user()->id)->first();
        $teacherSubjects = Auth::user()->expertiseInSubjects()->pluck('subject_id');
        $subjects = Subject::all();
        return view('teacher.dashboard', ['teacherSubjects' => $teacherSubjects, 'subjects' => $subjects, 'teacherProfile' => $teacherProfile]);
    }
    public function updateTeacherProfile(UpdateTeacherProfileRequest $request)
    {
        $validateData = $request->validated();
        $inputs = $request->except('_token', 'expertise_in_subjects');
        Auth::user()->expertiseInSubjects()->sync($request->expertise_in_subjects);

        $path = $request->file('profile_picture')->store('public/images');
        $inputs['profile_picture'] = $path;
        $inputs['user_id'] = Auth::user()->id;
        // dd($inputs);
        TeacherProfile::updateOrInsert($inputs);
        return back()->with('success', 'Teacher profile updated successfully.');
    }
}
