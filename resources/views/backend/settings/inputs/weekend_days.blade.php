{{-- START WEEKEND DAYS --}}
<div class="col-md-6">
    <div class="form-group">
        <label class="required">@lang('inputs.value')</label>
        <select class="select2 form-control" name="value[]" multiple data-placeholder="--- @lang('inputs.value') ---" required>
            @foreach (Carbon\Carbon::getDays() as $index => $day)
                <option value="{{ $index }}" {{ isset($row) && in_array($index, explode(',', $row->value)) ? "selected" : '' }}>{{ $day }}</option>
            @endforeach ($i = 0; $i < 7; $i++)
        </select>
        @include('layouts.includes.backend.validation_error', ['input' => 'value'])
    </div>
</div>
{{-- END WEEKEND DAYS --}}
