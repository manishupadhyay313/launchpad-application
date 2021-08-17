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
                <div class="card-header">{{ __('Admin Dashboard') }}</div>
                <div class="card-body">
                   <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">email</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->role_name }}</td>
                                    <td>{{ $user->status }}</td>
                                    @if ($user->role->role_name == 'Student')
                                        <td><a href="{{ route('admin.edit-student', ['userId'=>$user->id]) }}" class="btn btn-info btn-sm">Edit</a></td>
                                    @else
                                        <td><a href="{{ route('admin.edit-teacher', ['userId'=>$user->id]) }}" class="btn btn-info btn-sm">Edit</a></td>
                                    @endif
                                </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection