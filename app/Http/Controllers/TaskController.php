<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $paginate = 5;

    protected function getPagesCount($table, $count = null)
    {
        $count = $count ?? DB::select("SELECT count(`id`) as `count` FROM `$table`")[0]->count;
        return ['pages' => ceil($count / $this->paginate), 'count' => $count];
    }

    protected function getCurrentPageData($table)
    {
        $page = request()->page ?? 1;
        $page_first_result = ($page - 1) * $this->paginate;
        return DB::select("SELECT * FROM `$table` ORDER BY `id` DESC LIMIT $page_first_result , $this->paginate");
    }
}
