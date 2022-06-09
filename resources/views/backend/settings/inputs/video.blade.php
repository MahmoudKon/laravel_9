<div class="form-group">
    <label class="required">@lang('inputs.value')</label>
    <input type="file" class="form-control" name="value" accept="video/*">
    <small class="warning"><i class="fa fa-warning"></i> Only <b>mp4</b> Extentions <i class="fa fa-warning"></i></small>
    @include('layouts.includes.backend.validation_error', ['input' => "value"])
</div>


<div class="row">
    @if ($row)
        <div class="col-md-3">
            {!! $row->value() !!}
        </div>
    @endif
</div>
