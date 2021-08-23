@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                            <th scope="col">address</th>
                            <th scope="col">current school</th>
                            <th scope="col">previous school</th>
                            <th scope="col">experience</th>
                            <th scope="col">parent details</th>
                            <th scope="col">assigned teacher</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead> 
                        <tbody>
                        @if(!empty($users) && $users->count())
                            @foreach ($users as $user)
                                <tr>
                                    <td> <img src="/images/{{($user->profile_picture)?$user->profile_picture:'https://via.placeholder.com/150'}}" alt="profile image" style="max-height: 100px;">
                                        <br>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->role_name }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->current_school }}</td>
                                    <td>{{ $user->previous_school }}</td>
                                    <td>{{ $user->experience }}</td>
                                     <td>  
                                        @foreach ($user->parent_details as $parentDetail)
                                        <p>{{$parentDetail['name'] }}:- {{$parentDetail['value'] }}</p>
                                        @endforeach
                                    </td>
                                    <td>@php
                                        if($user->assigned_teacher){
                                            $teacher = \App\Models\User::find($user->assigned_teacher);
                                            echo $teacher->name;
                                        }else {
                                            echo 'Null';
                                        }
                                        
                                    @endphp</td>
                                    <td>{{ $user->status }}</td>
                                    @if ($user->role->role_name == 'Student')
                                        <td><a href="{{ route('admin.edit-student', ['userId'=>$user->id]) }}" class="btn btn-info btn-sm">Edit</a></td>
                                    @else
                                        <td><a href="{{ route('admin.edit-teacher', ['userId'=>$user->id]) }}" class="btn btn-info btn-sm">Edit</a></td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">There are no student or teacher.</td>
                            </tr>
                        @endif
                        
                        </tbody>
                    </table>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection