<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        {{-- START CONTENT --}}
        <div class="form-group">
            <label class="required">@lang('inputs.select-data', ['data' => trans('menu.content')])</label>
            <select class="select2 form-control" name="content_id" data-placeholder="--- @lang('inputs.select-data', ['data' => trans('menu.content')]) ---" >
                @if (count($contents) != 1)<option value="">@lang('inputs.please-select')</option> @endif
                @foreach ($contents as $id => $title)
                    <option value="{{ $id }}" @selected(isset($row) && $row->content_id == $id || old('content_id') == $id)>{{ $title }}</option>
                @endforeach
            </select>
            @include('layouts.includes.backend.validation_error', ['input' => 'content_id'])
        </div>
        {{-- END CONTENT --}}

        {{-- START OPERATOR --}}
        <div class="form-group">
            <label class="required">@lang('inputs.select-data', ['data' => trans('menu.operator')])</label>
            <select class="select2 form-control" name="operator_id" data-placeholder="--- @lang('inputs.select-data', ['data' => trans('menu.operator')]) ---" required>
                <option value="">@lang('inputs.please-select')</option>
                @foreach ($operators as $operator)
                    <option value="{{ $operator->id }}" @selected(isset($row) && $row->operator_id == $operator->id || old('operator_id') == $operator->id)>{{ "$operator->name - {$operator->country->name}" }}</option>
                @endforeach
            </select>
            @include('layouts.includes.backend.validation_error', ['input' => 'operator_id'])
        </div>
        {{-- END OPERATOR --}}

        {{-- START PUBLISHED DATE --}}
        <div class="form-group">
            <label class="required">@lang('inputs.published_date')</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fas fa-share"></i> </span>
                </div>
                <input type="date" class="form-control" name="published_date" placeholder=" @lang('inputs.published_date')" value="{{ $row->published_date ?? (old('published_date') ?? date('Y-m-d')) }}" required>
            </div>
            @include('layouts.includes.backend.validation_error', ['input' => 'published_date'])
        </div>
        {{-- END PUBLISHED DATE --}}

        {{-- START ACTIVE --}}
        <div class="form-group">
            <div>
                <label class="required">@lang('inputs.active')</label>
                <input type="checkbox" name="active" value="1" class="switchery" @checked($row->active ?? (old('active')))>
            </div>
            @include('layouts.includes.backend.validation_error', ['input' => 'active'])
        </div>
        {{-- END ACTIVE --}}

    </div>
</div>
