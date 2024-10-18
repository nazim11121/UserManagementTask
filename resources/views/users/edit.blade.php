@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card mt-2">
                <div class="card-body">
                    <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="col-sm-6">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" width="100" />
                            @else
                                <img src="{{asset('storage/default.jpg')}}" width="100" />
                            @endif
                            <label for="avatar">Avatar</label>
                            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" autofocus/>
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name">Name<span class="requiredStar">*</span></label>
                                <x-text-input id="name" name="name" type="text" value="{{$user->name}}" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="col-sm-6">
                                <label for="email" :value="__('Email')">Email<span class="requiredStar">*</span></label>
                                <x-text-input id="email" name="email" type="email" value="{{$user->email}}" class="mt-1 block w-full" required autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="row" id="addresses">
                            
                            <input type="hidden" name="addresses[0][id]" value="{{$user->addresses->first()->id??''}}">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="addresses[0][village]" value="{{$user->addresses->first()->village??''}}" placeholder="village">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="addresses[0][district]" value="{{$user->addresses->first()->district??''}}" placeholder="district">
                            </div>
                            <div class="col-sm-4">                           
                                <input type="text" class="form-control" name="addresses[0][division]" value="{{$user->addresses->first()->division??''}}" placeholder="division">
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif

                            <a href="{{route('users.index')}}" class="btn btn-info text-sm text-white">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .requiredStar{
        color: red;
    }
</style>
@endpush