<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\DB;

class TaskCommentController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            $comments = DB::select($this->filterRequest());
            return response()->json(view('tasks.comments.table-data', ['comments' => $comments])->render());
        }
        return view('tasks.comments.index', $this->getPagesCount('task_comments'));
    }


    protected function filterRequest()
    {
        $page = request()->page ?? 1;
        $page_first_result = ($page - 1) * $this->paginate;
        $query = "SELECT task_comments.*, task_posts.title AS 'post_title', users.name AS 'user_name', categories.name AS 'category_name' FROM `task_comments`";

        if (request()->user_id)
            $query .= " AND `users`.`id` = " . request()->user_id . " AND";

        if (request()->post_id)
            $query .= " AND `posts`.`id` = " . request()->post_id . " AND";

        if (request()->category_id)
            $query .= " AND `categories`.`id` = " . request()->category_id . " AND";

        if (request()->start_date && request()->end_date)
            $query .= " AND DATE(`task_comments`.`created_at`) BETWEEN '" . request()->start_date . "' AND '". request()->end_date ."' AND";

        if (request()->start_date && !request()->end_date)
            $query .= " AND `task_comments`.`created_at` = '" . request()->start_date ."' AND";

        if (!request()->start_date && request()->end_date)
            $query .= " AND `task_comments`.`created_at` = '" . request()->end_date ."' AND";

        $query = rtrim($query, 'AND');

        $query .= "INNER JOIN task_posts ON task_posts.id = task_comments.task_post_id
            INNER JOIN users ON users.id = task_posts.user_id
            INNER JOIN categories ON categories.id = task_posts.category_id
            ORDER BY `task_comments`.`created_at` DESC
            LIMIT $page_first_result , $this->paginate";

        return $query;
    }

}
