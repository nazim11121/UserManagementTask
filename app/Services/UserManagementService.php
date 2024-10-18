<?php

namespace App\Services;

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

class UserManagementService implements UserManagementServiceInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        if (isset($data['avatar'])) {
            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }
        $data['password'] = Hash::make('12345678');

        return User::create($data);

    }

    public function updateUser(User $user, array $data)
    {
        if (isset($data['avatar'])) {
            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }
        if (isset($data['password'])) {
            $data['password'] = Hash::make('12345678');
        }

        $addressId = Address::where('user_id', $user->id)->get()->pluck('id')->first();

        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function restoreUser($id)
    {
        return User::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDeleteUser($id)
    {
        return User::withTrashed()->findOrFail($id)->forceDelete();
    }

    public function getTrashedUsers()
    {
        return User::onlyTrashed()->get();
    }
}
