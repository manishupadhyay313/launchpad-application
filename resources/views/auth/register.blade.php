@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>
                            <div class="col-md-6">
                                <select onchange="setMoreFields(this)" class="form-control" name="role_id" id="role_id" required>
                                    <option value="3">Student</option>
                                    <option value="2">Teacher</option>
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
                                <img id="preview-image-before-upload" src="{{ $teacherProfile->profile_picture ?? 'https://via.placeholder.com/150' }}" alt="preview image" style="max-height: 250px;">
                                <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" placeholder="Choose profile picture" id="profile_picture" >
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
                                <input id="current_school" type="text" class="form-control" name="current_school" value="{{ $teacherProfile->current_school ?? '' }}" autocomplete="current_school">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previous_school" class="col-md-4 col-form-label text-md-right">{{ __('Previous School') }}</label>
                            <div class="col-md-6">
                                <input id="previous_school" type="text" class="form-control" name="previous_school" value="{{ $teacherProfile->previous_school ?? '' }}" autocomplete="previous_school">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $teacherProfile->address ?? '' }}"  autocomplete="address"></textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div id="studentFields" class="">
                            <div class="form-group row">
                            <label for="assigned_teacher" class="col-md-4 col-form-label text-md-right">{{ __('Select Teacher') }}</label>
                            <div class="col-md-6">
                                @php $teachers  = \App\Models\User::where('role_id',2)->get();  @endphp
                                <select class="form-control" id="assigned_teacher" name="assigned_teacher">
                                    <option value="">Please select Teacher</option>
                                    @foreach ($teachers as $teacher)
                                      <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>  
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="parent_details" class="col-md-4 col-form-label text-md-right">{{ __('Parent Details') }}</label>
                                <div class="col-md-6" id="addMoreStudentFields">
                                    <div class="form-row" id="field0">
                                        <div class="col">
                                            <input type="text" name="parent_details[0]['name']" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="col">
                                            <input type="text" name="parent_details[0]['value']" class="form-control" placeholder="Value">
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-primary" onclick="addMore()">Add More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="teacherFields" class="d-none">
                            <div class="form-group row">
                            <label for="experience" class="col-md-4 col-form-label text-md-right">{{ __('Experience') }}</label>
                            <div class="col-md-6">
                                <input id="experience" type="number" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience') }}"  autocomplete="experience">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expertise_in_subjects" class="col-md-4 col-form-label text-md-right">{{ __('Expertise In subjects') }}</label>
                            <div class="col-md-6">
                                @php $subjects  = \App\Models\Subject::all();  @endphp
                                <select multiple class="form-control @error('expertise_in_subjects') is-invalid @enderror" id="expertise_in_subjects" name="expertise_in_subjects[]">
                                    <option value="">Please select subjects</option>
                                    @foreach ($subjects as $subject)
                                      <option value="{{ $subject->id }}">{{ $subject->name }}</option>  
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#profile_picture').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#preview-image-before-upload').attr('src', e.target.result); 
            }
        reader.readAsDataURL(this.files[0]); 
        });
    });
    let addRow = 1;
    function addMore(){
        let html = '<div class="form-row" id="field'+ addRow +'"><div class="col"><input type="text" name="parent_details['+ addRow +']["name"]" class="form-control" placeholder="Name"> </div><div class="col"><input type="text" name="parent_details['+ addRow +']["value"]" class="form-control" placeholder="Value"></div><div class="col"><button type="button" class="btn btn-danger" onclick="remoreField('+ addRow +')">Remove</button></div></div>';
        $('#addMoreStudentFields').append(html);
        addRow++;
    }
    function remoreField(num){
        $('#field'+num).remove();
    }
    function setMoreFields(obj)
    {
        if(obj.value == 2){
            $('#teacherFields').removeClass('d-none');
            $('#studentFields').addClass('d-none');
        }else{
            $('#teacherFields').addClass('d-none');
            $('#studentFields').removeClass('d-none');
        }
    }
</script>
@endsection
