<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UserDataTable;
use App\Exports\UsersExport;
use App\Http\Controllers\BackendController;
use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Imports\UsersImport;
use App\Models\Aggregator;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends BackendController
{
    public $use_form_ajax = true;

    public function __construct(UserDataTable $dataTable, User $user)
    {
        parent::__construct($dataTable, $user);
    }

    public function store(UserRequest $request, UserService $UserService)
    {
        $user = $UserService->handle($request->except('image'));
        if (is_string($user)) return $this->throwException($user);
        return $this->redirect("User Created Successfully!");
    }

    public function update(UserRequest $request, UserService $UserService, $id)
    {
        $user = $UserService->handle($request->except('image'), $id);
        if (is_string($user)) return $this->throwException($user);
        return $this->redirect("User Updated Successfully!");
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import()
    {
        return view('backend.users.import');
    }

    public function saveImport(Request $request)
    {
        Excel::import(new UsersImport, $request->file);
        return response()->json(['message' => "Data Saved Successfully!", 'icon' => 'success']);
    }

    public function append()
    {
        return [
            'departments' => Department::when(request('department'), function($query) {
                                $query->where('id', request('department'));
                            })->pluck('title', 'id'),
            'users' => User::pluck('name', 'id'),
            'aggregators' => Aggregator::pluck('title', 'id'),
            'roles' => Role::pluck('name', 'id')
        ];
    }

    public function query($id): object
    {
        return $this->model::with(['department', 'aggregator', 'behalf'])->findOrFail($id);
    }
}
