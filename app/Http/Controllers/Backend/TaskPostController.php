<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\DB;

class TaskPostController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            $page = request()->page ?? 1;
            $page_first_result = ($page - 1) * $this->paginate;
            $posts = DB::select("SELECT task_posts.*, users.name as 'user_name', categories.name AS 'category_name' FROM `task_posts`
                                INNER JOIN users ON users.id = task_posts.user_id
                                INNER JOIN categories ON categories.id = task_posts.category_id
                                ORDER BY `task_posts`.`id` DESC
                                LIMIT $page_first_result , $this->paginate");
            return response()->json(view('tasks.posts.table-data', ['posts' => $posts])->render());
        }
        return view('tasks.posts.index', $this->getPagesCount('task_posts'));
    }
}
