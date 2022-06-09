<div class="row">

    {{-- START KEY --}}
    <div class="col-md-12">
        <div class="form-group">
            <label class="required">@lang('inputs.key')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="la la-pencil"></i> </span>
                </div>
                <input type="text" class="form-control badge-text-maxlength" maxlength="30" name="key"
                    value="{{ $row->key ?? old('key') }}" placeholder="@lang('inputs.key')" autocomplete="off" required>
            </div>
            @include('layouts.includes.backend.validation_error', ['input' => "key"])
        </div>
    </div>
    {{-- END KEY --}}

    {{-- START SYSTEM --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="required">@lang('inputs.select-data', ['data' => trans('inputs.system')])</label>
            <select class="select2 form-control" name="system" id="system" data-placeholder="--- @lang('inputs.select-data', ['data' => trans('menu.content_type')]) ---" >
                @foreach ([1 => 'System 1'] as $index => $name)
                    <option value="{{ $index }}" @selected(isset($row) && $row->system == $index || old('system') == $index)>{{ $name }}</option>
                @endforeach
            </select>
            @include('layouts.includes.backend.validation_error', ['input' => 'system'])
        </div>
    </div>
    {{-- END SYSTEM --}}

    {{-- START CONTENT TYPE --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="required">@lang('inputs.select-data', ['data' => trans('menu.content_type')])</label>
            <select class="select2 form-control" name="content_type_id" id="content_type_id" data-placeholder="--- @lang('inputs.select-data', ['data' => trans('menu.content_type')]) ---" >
                <option value="">@lang('inputs.please-select')</option>
                @foreach ($types as $id => $name)
                    <option value="{{ $id }}" @selected(isset($row) && $row->content_type_id == $id || old('content_type_id') == $id)>{{ $name }}</option>
                @endforeach
            </select>
            @include('layouts.includes.backend.validation_error', ['input' => 'content_type_id'])
        </div>
    </div>
    {{-- END CONTENT TYPE --}}
</div>

<div id="load-content-type-input" class="pt-2" style="border-top: 1px solid #d5d5d5"></div>

@push('script')
    <script>
        $(function() {
            $(document).ready(function() {
                if ($('#content_type_id').val() > 0) { $('#content_type_id').change() }
            });

            let content_type_input = $('#load-content-type-input');
            let content_id = "{{ $row->id ?? null }}";
            $('body').on('change', '#content_type_id', function() {
                let url = "{{ routeHelper('settings.type.input') }}";
                let content_type_id = $(this).val();
                content_type_input.addClass('load').fadeOut(300, function () { $(this).empty() });

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {content_type_id: content_type_id, content_id: content_id},
                    success: function (response, textStatus, jqXHR) {
                        $('.select2').select2();
                        content_type_input.fadeIn(300, function() { $(this).html(response); });
                    },
                    error: function (jqXHR, textStatus, errorMessage) {
                        handleErrors(jqXHR);
                    },
                    complete: function() { content_type_input.removeClass('load'); }
                });

            });
        });
    </script>
@endpush
