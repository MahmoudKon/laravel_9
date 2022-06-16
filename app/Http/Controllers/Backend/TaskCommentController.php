<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\DB;

class TaskCommentController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            [$query, $current_page, $pages, $count] = $this->filterRequest();
            $comments = DB::select($query);
            return response()->json(view('tasks.comments.table-data', compact('comments', 'current_page', 'count', 'pages'))->render());
        }

        $users = DB::table('users')->select('name', 'id')->pluck('name', 'id')->toArray();
        $categories = DB::table('categories')->select('name', 'id')->pluck('name', 'id')->toArray();
        return view('tasks.comments.index', compact('users', 'categories'));
    }

    public function getPosts()
    {
        $query = "SELECT task_posts.id, task_posts.title FROM task_posts";
        if (request()->users)
            $query .= " WHERE task_posts.user_id IN (" . implode(',', request()->users) . ") AND";

        if (request()->categories) {
            if (stripos($query, 'where') === false)
                $query .= " WHERE";
            $query .= " task_posts.category_id IN (" . implode(',', request()->categories) . ")";
        }

        $query = rtrim($query, 'AND');
        $query .= " ORDER BY `id` DESC";
        $posts = DB::select($query);
        return response()->json(['posts' => $posts], 200);
    }

    protected function filterRequest()
    {
        $current_page = request()->page ?? 1;
        $page_first_result = ($current_page - 1) * $this->paginate;
        $query = "SELECT task_comments.*, task_posts.title AS 'post_title', users.name AS 'user_name', categories.name AS 'category_name' FROM `task_comments`
                    INNER JOIN task_posts ON task_posts.id = task_comments.task_post_id
                    INNER JOIN users ON users.id = task_posts.user_id
                    INNER JOIN categories ON categories.id = task_posts.category_id";

        if (request()->user_id)
            $query .= " WHERE `users`.`id` IN (" . implode(',', request()->user_id) . ") AND";

        if (request()->post_id)
            $query .= " WHERE `task_posts`.`id` IN (" . implode(',', request()->post_id) . ") AND";

        if (request()->category_id)
            $query .= " WHERE `categories`.`id` IN (" . implode(',', request()->category_id) . ") AND";

        if (request()->start_date && request()->end_date)
            $query .= " WHERE DATE(`task_comments`.`created_at`) BETWEEN '" . request()->start_date . "' AND '". request()->end_date ."' AND";

        if (request()->start_date && !request()->end_date)
            $query .= " WHERE `task_comments`.`created_at` = '" . request()->start_date ."' AND";

        if (!request()->start_date && request()->end_date)
            $query .= " WHERE `task_comments`.`created_at` = '" . request()->end_date ."'";

        $query = str_replace('AND WHERE ', ' AND ', $query);
        $query = $count = rtrim($query, 'AND');

        $result = $this->getPagesCount('task_comments', count(DB::select($count)));

        $query .= " ORDER BY `task_comments`.`created_at` DESC LIMIT $page_first_result , $this->paginate";

        return [$query, $current_page, $result['pages'], $result['count']];
    }

}
