@extends('layouts.app')

@section('content')
<div class="container">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users View') }}
        </h2>
    </x-slot>
    <div class="row text-center mt-4">
        <div class="col d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
            @if($user->avatar)
                <img src="{{asset('storage/' .$user->avatar)}}" class="card-img-top" alt="...">
            @else
                <img src="{{asset('storage/default.jpg')}}" class="card-img-top" alt="...">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{$user->name}}</h5>
                <p class="card-text">{{$user->email}}</p>
            </div>
            <ul class="list-group list-group-flush">
                @if($user->addresses)
                    @foreach($user->addresses as $value)
                        <li class="list-group-item">{{$value['village']}}<span> </span>{{$value['district']}}<span> </span>{{$value['division']}}</li>
                    @endforeach
                @endif
            </ul>
            </div>
        </div>    
    </div>
</div>
@endsection
