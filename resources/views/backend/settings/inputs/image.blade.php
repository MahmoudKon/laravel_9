<div class="col-md-3">
    {{-- START SETTING IMAGE --}}
    <div class="form-group">
        <label class="{{ $class ?? '' }}">@lang('inputs.value')</label>
        <div id="file-preview">
            <input type="file" name="value" class="form-control input-image" accept="image/*" onchange="previewFile(this)" {{ isset($required) && $required ? "required" : "" }}>
            <div>
                <img src="{{ isset($row) ? asset("$row->value") : 'https://www.lifewire.com/thmb/2KYEaloqH6P4xz3c9Ot2GlPLuds=/1920x1080/smart/filters:no_upscale()/cloud-upload-a30f385a928e44e199a62210d578375a.jpg' }}"
                    class="img-border img-thumbnail" id="show-file" alt="{{ $row->title ?? "Image" }}">
            </div>
        </div>
        @include('layouts.includes.backend.validation_error', ['input' => "value"])
    </div>
    {{-- START SETTING IMAGE --}}
</div>
