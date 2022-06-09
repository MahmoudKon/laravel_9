<script type="text/javascript" src="{{ assetHelper('vendors/js/editors/ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function() {CKEDITOR.replaceAll('ckeditor'); });
</script>

<div class="form-group">
    <label>@lang('inputs.value')</label>
    <textarea name="value" cols="30" rows="15" class="ckeditor" placeholder="@lang('inputs.value')" required>{{ $row->value ?? old("value") }}</textarea>
    @include('layouts.includes.backend.validation_error', ['input' => "value"])
</div>

