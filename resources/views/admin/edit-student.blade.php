@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
        @endif
            <div class="card">
                <div class="card-header">{{ __('Update Student') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('admin.update-student',['userId' => $user->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" disabled type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="email">
                                 @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>
                            <div class="col-md-6">
                                <select disabled onchange="setMoreFields(this)" class="form-control @error('role_id') is-invalid @enderror" name="role_id" autocomplete="role_id">
                                    <option value="3" {{ ($user->role_id == 3)?'selected':'' }}>Student</option>
                                    <option value="2" {{ ($user->role_id == 2)?'selected':'' }}>Teacher</option>
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>
                            <div class="col-md-6">
                                <img id="preview-image-before-upload" src="{{ asset('images/'.$user->profile_picture) }}" alt="preview image" style="max-height: 200px;">
                                <input type="file" disabled id="profile_picture" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" placeholder="Choose profile picture" autocomplete="profile_picture" >
                                @error('profile_picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_school" class="col-md-4 col-form-label text-md-right">{{ __('Current School') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('current_school') is-invalid @enderror" name="current_school" disabled value="{{ $user->current_school }}" autocomplete="current_school">
                                @error('current_school')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previous_school" class="col-md-4 col-form-label text-md-right">{{ __('Previous School') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('previous_school') is-invalid @enderror" name="previous_school" disabled value="{{ $user->previous_school }}" autocomplete="previous_school">
                                @error('previous_school')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" disabled  autocomplete="address">{{ $user->address }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="parent_details" class="col-md-4 col-form-label text-md-right">{{ __('Parent Details') }}</label>
                                <div class="col-md-6" id="addMoreStudentFields">
                                   
                                    @foreach ($user->parent_details as $parentDetail)
                                        <div class="form-row" id="field0">
                                        <div class="col">
                                            <input type="text" disabled value="{{ $parentDetail['name'] }}" name="parent_details[0][name]" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="col">
                                            <input type="text" disabled value="{{ $parentDetail['value'] }}" name="parent_details[0][value]" class="form-control" placeholder="Value">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        <div class="form-group row">
                                <label for="assigned_teacher" class="col-md-4 col-form-label text-md-right">{{ __('Select Teacher') }}</label>
                                <div class="col-md-6">
                                    @php $teachers  = \App\Models\User::where('role_id',2)->get();  @endphp
                                    <select class="form-control" id="assigned_teacher" name="assigned_teacher">
                                        <option value="">Please select Teacher</option>
                                        @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ ($teacher->id == $user->assigned_teacher)?'selected':'' }}>{{ $teacher->name }}</option>  
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="status" name="status">
                                        <option value="inactive" {{ ('inactive' == $user->status)?'selected':'' }}>Inactive</option>  
                                        <option value="active" {{ ('active' == $user->status)?'selected':'' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
