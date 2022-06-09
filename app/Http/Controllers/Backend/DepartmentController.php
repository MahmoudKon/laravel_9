<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DepartmentDataTable;
use App\Http\Controllers\BackendController;
use App\Http\Requests\DepartmentRequest;
use App\Http\Services\DepartmentService;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends BackendController
{
    public $use_form_ajax = true;

    public function __construct(DepartmentDataTable $dataTable, Department $department)
    {
        parent::__construct($dataTable, $department, true);
    }

    public function store(DepartmentRequest $request, DepartmentService $DepartmentService)
    {
        $department = $DepartmentService->handle($request->validated());
        if (is_string($department)) return $this->throwException($department);
        return $this->redirect("Department Created Successfully!");
    }

    public function update(DepartmentRequest $request, DepartmentService $DepartmentService, $id)
    {
        $department = $DepartmentService->handle($request->validated(), $id);
        if (is_string($department)) return $this->throwException($department);
        return $this->redirect("Department Updated Successfully!");
    }

    public function append()
    {
        return [
            'users' => User::pluck('name', 'id')
        ];
    }
}
