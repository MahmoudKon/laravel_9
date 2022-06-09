<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('subs')->parent()->get();
        return view('backend.menus.index', ['count' => $menus->count(), 'menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::when(request()->menu, function($query) {
            $query->where('id', request()->menu);
        })->get();
        $check = request()->menu ? true : false;
        return view("backend.menus.form", ['title' => "Create New Menu", 'menus' => $menus, 'check' => $check]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());
        toast("Menu has been created!", 'success');
        return response()->json(['redirect' => routeHelper('menus.index')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view("backend.menus.form", ['title' => "Edit Menu", 'row' => $menu, 'menus' => Menu::where('id', '!=', $menu->id)->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        toast("Menu has been updated!", 'success');
        return response()->json(['redirect' => routeHelper('menus.index')]);
    }

    public function destroy(Menu $menu)
    {
        $menu->subs()->delete();
        $menu->delete();
        $this->resetOrders();
        toast("Menu has been deleted!", 'success');
        return response()->json(['redirect' => routeHelper('menus.index')]);
    }

    public function toggleVisible(Menu $menu)
    {
        $status = !$menu->visible;
        $menu->update(['visible' => $status]);
        if (!$status) $menu->subs()->update(['visible' => $status]);
        toast("Menu has been Updated!", 'success');
        return redirect()->back();
    }

    public function reorder(Request $request)
    {
        foreach ($request->orders as $id => $row){
            if (!$row) continue;
            Menu::findOrFail($id)->update(['order' => $row['order'], 'parent_id' => $row['parent_id']]);
        }
        return 'Success';
    }

    protected function resetOrders()
    {
        foreach (Menu::all() as $index => $menu) $menu->update(['order' => $index+1]);
    }
}
