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
                <div class="card-header">{{ __('Change Student Status') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('admin.change-status',['userId' => $user->id])}}">
                        @csrf
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
