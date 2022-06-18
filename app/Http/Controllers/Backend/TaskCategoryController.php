<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Gate;

class TaskCategoryController extends TaskController
{
    public function index()
    {
        abort_if(Gate::denies('list categories'), 403, 'Don\'t have access');

        if (request()->ajax()) {
            return response()->json(view('tasks.categories.table-data', ['categories' => $this->getCurrentPageData('categories')])->render());
        }
        return view('tasks.categories.index', $this->getPagesCount('categories'));
    }

}
