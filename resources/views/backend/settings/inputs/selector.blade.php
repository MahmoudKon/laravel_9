{{-- START SELECTOR --}}
<div class="col-md-6">
    <div class="form-group">
        <label class="required">@lang('inputs.value')</label>
        <select class="select2 form-control" name="value" data-placeholder="--- @lang('inputs.value') ---" required>
            @foreach ([1 => 'TRUE', 0 => 'FALSE'] as $index => $name)
                <option value="{{ $index }}" @selected(isset($row) && $row->value === $index || old('value') == $index)>{{ $name }}</option>
            @endforeach
        </select>
        @include('layouts.includes.backend.validation_error', ['input' => 'value'])
    </div>
</div>
{{-- END SELECTOR --}}
