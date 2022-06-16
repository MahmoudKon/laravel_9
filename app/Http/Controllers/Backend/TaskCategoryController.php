<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;

class TaskCategoryController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            return response()->json(view('tasks.categories.table-data', ['categories' => $this->getCurrentPageData('categories')])->render());
        }
        return view('tasks.categories.index', $this->getPagesCount('categories'));
    }

}
