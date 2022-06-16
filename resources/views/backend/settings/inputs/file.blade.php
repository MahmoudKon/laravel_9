<div class="form-group">
    <label class="required">@lang('inputs.value')</label>
    <input type="file" name="value" class="form-control" accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.csv, application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
    <small class="warning"><i class="fa fa-warning"></i> Only <b>docx,excel,pdf,csv</b> Extentions <i class="fa fa-warning"></i></small>
    @include('layouts.includes.backend.validation_error', ['input' => "value"])
</div>

@if ($row)
    {!! $row->getDataHtml() !!}
@endif
