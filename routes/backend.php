<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => ROUTE_PREFIX_WITHOUT_DOT,
    'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::get('/','HomeController@index')->name('/');
    Route::post('read/notifications/{id?}', 'NotificationController@readNotification')->name('read.notifications');
    Route::get('file-manager', 'FileManagerController@index')->name('file.manager');

    Route::controller('RouteController')->group(function () {
        Route::get('routes','index')->name('routes.index');
        Route::get('routes/download','download')->name('routes.download');
        Route::get('routes/sync','sync')->name('routes.sync');
        Route::get('routes/{route}/edit','edit')->name('routes.edit');
        Route::put('routes/{route}/update','update')->name('routes.update');
        Route::get('routes/assign-roles','assign')->name('routes.assign');
        Route::post('routes/assign-roles','assignRoles')->name('routes.assign-roles');
    });


    Route::resource('users','UserController');
    Route::controller('UserController')->group(function () {
        Route::post('users/multidelete', 'multidelete')->name('users.multidelete');
        Route::get('users/excel/export', 'export')->name('users.excel.export');
        Route::get('users/excel/import', 'import')->name('users.excel.import.form');
        Route::post('users/excel/import', 'saveImport')->name('users.excel.import');
        Route::get('users/search/form', 'search')->name('users.search.form');
        Route::get('departments/{department}/users','index')->name('departments.users.index');
        Route::get('departments/{department}/users/create','create')->name('departments.users.create');
    });


    Route::controller('ProfileController')->group(function () {
        Route::get('profile', 'index')->name('profile.index');
        Route::put('profile/info', 'info')->name('profile.info');
        Route::put('profile/avatar', 'avatar')->name('profile.avatar');
        Route::put('profile/password', 'password')->name('profile.password');
        Route::put('profile/roles', 'roles')->name('profile.roles');
        Route::put('profile/permissions', 'permissions')->name('profile.permissions');
    });


    Route::resource('departments','DepartmentController');
    Route::post('departments/multidelete', 'DepartmentController@multidelete')->name('departments.multidelete');

    Route::resource('aggregators','AggregatorController');
    Route::post('aggregators/multidelete', 'AggregatorController@multidelete')->name('aggregators.multidelete');

    Route::resource('roles','RoleController');
    Route::controller('RoleController')->group(function () {
        Route::post('roles/get/permissions', 'getPermissions')->name('roles.permissions');
        Route::post('roles/multidelete', 'multidelete')->name('roles.multidelete');
    });


    Route::resource('permissions','PermissionController');
    Route::post('permissions/multidelete', 'PermissionController@multidelete')->name('permissions.multidelete');


    Route::resource('countries','CountryController');
    Route::post('countries/multidelete', 'CountryController@multidelete')->name('countries.multidelete');


    Route::resource('operators','OperatorController');
    Route::controller('OperatorController')->group(function () {
        Route::post('operators/multidelete', 'multidelete')->name('operators.multidelete');
        Route::get('countries/{country}/operators','index')->name('countries.operators.index');
        Route::get('countries/{country}/operators/create','create')->name('countries.operators.create');
    });


    Route::resource('settings','SettingController');
    Route::controller('SettingController')->group(function () {
        Route::post('settings/type/input', 'getTypeInput')->name('settings.type.input');
        Route::post('settings/multidelete', 'multidelete')->name('settings.multidelete');
    });

    Route::resource('categories','CategoryController');
    Route::controller('CategoryController')->group(function () {
        Route::get('categories/{category}/subs', 'index')->name('categories.subs.index');
        Route::get('categories/{category}/subs/create', 'create')->name('categories.subs.create');
        Route::post('categories/multidelete', 'multidelete')->name('categories.multidelete');
    });


    Route::resource('content_types','ContentTypeController');
    Route::post('content_types/multidelete', 'ContentTypeController@multidelete')->name('content_types.multidelete');
    Route::post('content_types/visible/toggle/{content_type}', 'ContentTypeController@toggleVisible')->name('content_types.visible.toggle');

    Route::resource('contents','ContentController');
    Route::controller('ContentController')->group(function () {
        Route::post('contents/type/input', 'getTypeInput')->name('contents.type.input');
        Route::post('contents/multidelete', 'multidelete')->name('contents.multidelete');
    });

    Route::resource('posts','PostController');
    Route::controller('PostController')->group(function () {
        Route::get('contents/{content}/posts', 'index')->name('contents.posts.index');
        Route::get('contents/{content}/posts/create', 'create')->name('contents.posts.create');
        Route::post('posts/multidelete', 'multidelete')->name('posts.multidelete');
        Route::post('posts/active-toggle', 'activeToggle')->name('posts.active.toggle');
        Route::get('posts/{post}/short-url', 'shortUrlForm')->name('posts.short.url');
        Route::post('posts/{post}/short-url', 'shortUrl')->name('posts.short.url');
    });


    Route::resource('menus', 'MenuController');
    Route::controller('MenuController')->group(function () {
        Route::get('menus/{menu}/subs/create', 'create')->name('menus.subs.create');
        Route::post('menus/{menu}/toggle/visible', 'toggleVisible')->name('menus.toggle.visible');
        Route::post('menus/reorder', 'reorder')->name('menus.reorder');
    });


    Route::controller('ImageToolController')->group(function () {
        Route::get('image-cropper', 'imageCrop')->name('image.cropper');
        Route::get('image-quality', 'ChangeQuality')->name('image.quality');
    });


    Route::resource('clients','ClientController');
    Route::post('clients/multidelete', 'ClientController@multidelete')->name('clients.multidelete');

    Route::get('tasks', function() {
        return back();
    });
    Route::get('tasks/users', 'TaskUserController@index')->name('tasks.users');
    Route::get('tasks/categories', 'TaskCategoryController@index')->name('tasks.categories');
    Route::get('tasks/posts', 'TaskPostController@index')->name('tasks.posts');
    Route::any('tasks/comments', 'TaskCommentController@index')->name('tasks.comments');
    Route::post('tasks/comments/get/posts', 'TaskCommentController@getPosts')->name('tasks.comments.get.posts');
});

