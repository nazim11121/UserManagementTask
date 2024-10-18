<?php

namespace App\Services;
use App\Models\User;

interface UserManagementServiceInterface
{
    public function getAllUsers();
    public function getUserById($id);
    public function createUser(array $data);
    public function updateUser(User $user, array $data);
    public function deleteUser(User $user);
    public function restoreUser($id);
    public function forceDeleteUser($id);
    public function getTrashedUsers();
}

