<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    use UploadFile;

    public function index()
    {
        $user = auth()->user();
        $roles = Role::pluck('name', 'id')->toArray();
        $behalfs = User::where('department_id', auth()->user()->department_id)->where('id', '!=', auth()->id())->pluck('name', 'id')->toArray();
        $permissions = Permission::pluck('name', 'id')->toArray();
        return view('backend.profile.index', compact('user', 'roles', 'permissions', 'behalfs'));
    }

    public function info(ProfileRequest $request)
    {
        auth()->user()->update($request->validated());
        toast("Your information has been Changed!", 'success');
        return response()->json(['reload' => true]);
    }

    public function avatar(ProfileRequest $request)
    {
        $this->remove(auth()->user()->image);
        auth()->user()->update(['image' => $this->uploadImage($request->image, 'users')]);
        return response()->json(['message' => "Your avatar has been Updated!", 'icon' => 'success']);
    }

    public function password(ProfileRequest $request)
    {
        auth()->user()->update(['password' => $request->new_password]);
        return response()->json(['message' => "Your password has been Changed!", 'icon' => 'success']);
    }

    public function roles(ProfileRequest $request)
    {
        auth()->user()->roles()->sync($request->roles);
        toast("Your roles has been Updated!", 'success');
        return response()->json(['reload' => true]);
    }

    public function permissions(ProfileRequest $request)
    {
        auth()->user()->permissions()->sync($request->permissions);
        toast("Your permissions has been Updated!", 'success');
        return response()->json(['reload' => true]);
    }
}
