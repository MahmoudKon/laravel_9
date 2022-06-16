<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;

class TaskUserController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            return response()->json(view('tasks.users.table-data', ['users' => $this->getCurrentPageData('users')])->render());
        }
        return view('tasks.users.index', $this->getPagesCount('users'));
    }
}
