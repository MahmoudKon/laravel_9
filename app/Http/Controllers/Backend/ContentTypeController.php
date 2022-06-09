<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ContentTypeDataTable;
use App\Http\Controllers\BackendController;
use App\Http\Requests\ContentTypeRequest;
use App\Http\Services\ContentTypeService;
use App\Models\ContentType;

class ContentTypeController extends BackendController
{
    public $full_page_ajax  = true;

    public function __construct(ContentTypeDataTable $dataTable, ContentType $contentType)
    {
        parent::__construct($dataTable, $contentType);
    }

    public function store(ContentTypeRequest $request, ContentTypeService $contentTypeService)
    {
        $content_type = $contentTypeService->handle($request->validated());
        if (is_string($content_type)) return $this->throwException($content_type);
        return $this->redirect("Content Type Created Successfully!");
    }

    public function update(ContentTypeRequest $request, ContentTypeService $contentTypeService, $id)
    {
        $content_type = $contentTypeService->handle($request->validated(), $id);
        if (is_string($content_type)) return $this->throwException($content_type);
        return $this->redirect("Content Type Updated Successfully!");
    }
}
