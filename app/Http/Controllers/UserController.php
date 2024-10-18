<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\UserManagementServiceInterface;
use App\Http\Requests\UserManagementRequest;

class UserController extends Controller
{
    
    protected $userManagementService;

    public function __construct(UserManagementServiceInterface $userManagementService)
    {
        $this->userManagementService = $userManagementService;
    }
    public function index()
    {
        $userList = $this->userManagementService->getAllUsers();
        return view('users.index', compact('userList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserManagementRequest $request)
    {
       
        $user = $this->userManagementService->createUser($request->validated());
        event(new UserCreated($user));
        return redirect()->route('users.index')->with('success', 'New user created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userManagementService->getUserById($id);
        return view('users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->userManagementService->updateUser($user, $request->all());
        event(new UserCreated($user));
        return redirect()->route('users.index')->with('success', 'Selected Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userManagementService->deleteUser($user);
        return redirect()->route('users.index')->with('success','Selected Data Deleted Successfully');
    }

    public function deletedDataList()
    {
        $userList = $this->userManagementService->getTrashedUsers();
        return view('users.deletedList', compact('userList'));
    }
    public function restore($id)
    {
        $this->userManagementService->restoreUser($id);
        return redirect()->route('users.index')->with('success', 'Restore data successfully');
    }

    public function forceDelete($id)
    {
        $this->userManagementService->forceDeleteUser($id);
        return redirect()->route('users.deleted-list')->with('success', 'Data permanently deleted');
    }

}
