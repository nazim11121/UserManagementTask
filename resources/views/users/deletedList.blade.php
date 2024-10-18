@extends('layouts.app')

@section('content')
<div class="container">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif
    <a href="{{ route('users.create') }}" class="btn btn-primary m-2 float-end">Create User</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userList as $key=>$user)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" width="50" />
                    @else
                        <img src="{{asset('images/default.jpg')}}" width="50">
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.deleted.restore', $user->id) }}" class="btn btn-warning">Resote</a>
                    <a href="{{ route('users.deleted.permanently', $user->id) }}" class="btn btn-danger">Permanently Delete</a>
                    <!-- <form action="{{ route('users.deleted.permanently', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Permanently Delete</button>
                    </form> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
