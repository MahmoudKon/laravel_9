<div class="form-group">
    <label class="required">@lang('inputs.value')</label>
    <input type="file" class="form-control" name="value" accept="audio/*">
    <small class="warning"><i class="fa fa-warning"></i> Only <b>mp3</b> Extentions <i class="fa fa-warning"></i></small>
    @include('layouts.includes.backend.validation_error', ['input' => "value"])
</div>

@if ($row)
    {!! $row->getDataHtml() !!}
@endif
