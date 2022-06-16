{{-- START WEEKEND DAYS --}}
<div class="col-md-6">
    <div class="form-group">
        <label class="required">@lang('inputs.value')</label>
        <input type="time" name="value" class="form-control" value="{{ $row->getOriginal('value') ?? old('value') }}">
        @include('layouts.includes.backend.validation_error', ['input' => 'value'])
    </div>
</div>
{{-- END WEEKEND DAYS --}}

