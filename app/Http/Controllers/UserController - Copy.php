<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userList = User::all();
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validatedData['password'] = '12345678';

        User::create($validatedData);

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
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
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::where("id", $id)->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Selected Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($id) {

            User::find($id)->delete();
            return redirect()->route('users.index')->with('success','Selected Data Deleted Successfully');
        
        } else {

            return redirect()->route('users.index')->with('success','Selected Data Deleted Failed');
        }
    }

    public function deletedDataList()
    {
        $userList = User::onlyTrashed()->get();
        return view('users.deletedList', compact('userList'));
    }
    public function restore($id)
    {
        User::onlyTrashed()->find($id)->restore();
        return redirect()->route('users.index')->with('success', 'Restore data successfully');
    }

    public function forceDelete($id)
    {
        User::withTrashed()->find($id)->forceDelete();
        return redirect()->route('users.index')->with('success', 'Data permanently deleted');
    }

}
