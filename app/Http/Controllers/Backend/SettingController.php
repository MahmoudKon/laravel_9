<?php

namespace App\Http\Controllers\Backend;

use App\Constants\SettingType;
use App\DataTables\SettingDataTable;
use App\Http\Controllers\BackendController;
use App\Http\Requests\SettingRequest;
use App\Http\Services\SettingService;
use App\Models\ContentType;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends BackendController
{
    public $use_form_ajax  = true;

    public function __construct(SettingDataTable $dataTable, Setting $contentType)
    {
        parent::__construct($dataTable, $contentType);
    }

    public function store(SettingRequest $request, SettingService $SettingService)
    {
        $setting = $SettingService->handle($request->validated());
        if (is_string($setting)) return $this->throwException($setting);
        return $this->redirect("Setting Created Successfully!");
    }

    public function update(SettingRequest $request, SettingService $SettingService, $id)
    {
        $setting = $SettingService->handle($request->validated(), $id);
        if (is_string($setting)) return $this->throwException($setting);
        return $this->redirect("Setting Updated Successfully!");
    }

    public function getTypeInput(Request $request)
    {
        $view_path = SettingType::viewHandler($request->content_type_id);
        $row = $this->model::whereId($request->content_id)->first();
        return $view_path ? view($view_path, compact('row'), ['column_name' => 'value']) : '';
    }

    public function append()
    {
        return [
            'types' => ContentType::pluck('name', 'id')
        ];
    }
}
