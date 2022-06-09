<div class="form-group">
    <label class="required">@lang('inputs.value')</label>
    <input type="text" class="form-control" name="value" value="{{ $row->value ?? old("value") }}" placeholder="@lang('inputs.value')" required>
    @include('layouts.includes.backend.validation_error', ['input' => "value"])
</div>
