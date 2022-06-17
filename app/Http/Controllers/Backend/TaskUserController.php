<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\DB;

class TaskUserController extends TaskController
{
    public function index()
    {
        if (request()->ajax()) {
            $permissions = DB::table('task_permissions')->pluck('name', 'id');
            return response()->json(view('tasks.users.table-data', ['users' => $this->getCurrentPageData('users'), 'permissions' => $permissions])->render());
        }
        return view('tasks.users.index', $this->getPagesCount('users'));
    }

    public function togglePermissions()
    {
        $message = 'Something is error!';
        if (userHasPermission(request()->user_id, request()->permission_id)) {
            DB::select('DELETE FROM `task_user_permissions` WHERE `user_id` = '.request()->user_id.' AND `task_permission_id` = ' . request()->permission_id);
            $message = 'Permissions Deleted!';
        } else {
            DB::select('INSERT INTO `task_user_permissions`(`user_id`, `task_permission_id`) VALUES ('.request()->user_id.','.request()->permission_id.')');
            $message = 'Permissions Added!';
        }
        return response()->json(['message' => $message]);
    }
}
