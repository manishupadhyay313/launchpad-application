@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Please Update your profile') }}</div>

                <div class="card-body">
                    @if (Session::has('success'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('success') }}</div>
                    @endif 
                    <form method="POST" action="{{ route('update.teacher.profile') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($teacherProfile->id)
                            <input name="id" type="hidden" value="{{ $teacherProfile->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $teacherProfile->address ?? '' }}"  autocomplete="address" autofocus>
                                @error('address')
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
                            <label for="experience" class="col-md-4 col-form-label text-md-right">{{ __('Experience') }}</label>
                            <div class="col-md-6">
                                <input id="experience" type="number" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ $teacherProfile->experience ?? old('experience') }}"  autocomplete="experience">
                                 @error('experience')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expertise_in_subjects" class="col-md-4 col-form-label text-md-right">{{ __('Expertise In subjects') }}</label>
                            <div class="col-md-6">
                                <select multiple class="form-control @error('expertise_in_subjects') is-invalid @enderror" id="expertise_in_subjects" name="expertise_in_subjects[]">
                                    <option value="">Please select subjects</option>
                                    @foreach ($subjects as $subject)
                                      <option value="{{ $subject->id }}" {{ in_array($subject->id, $teacherSubjects)?'selected':'' }}>{{ $subject->name }}</option>  
                                    @endforeach
                                </select>
                                @error('expertise_in_subjects')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile') }}
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
 
</script>
@endsection