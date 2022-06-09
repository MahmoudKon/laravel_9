<span class="dropdown">
    <button id="table-optins" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
    <span aria-labelledby="table-optins" class="dropdown-menu mt-1 dropdown-menu-left" x-placement="bottom-end">

        @if (canUser(getModel()."-edit"))
            <a href="{{ routeHelper(getModel().'.edit', $id) }}"
                class="btn btn-outline-primary {{ $use_button_ajax ? 'show-modal-form' : '' }} dropdown-item">
                <i class="ft-edit"></i> @lang('buttons.edit')
            </a>
        @endif

        @yield('table-buttons')

        @if (canUser(getModel()."-destroy"))
            <form action="{{ routeHelper(getModel().'.destroy', $id) }}" method="POST" class="form-destroy">
                {{ csrf_field() }}
                @method('delete')
                <button type="submit" class="btn btn-outline-danger dropdown-item delete">
                    <i class="ft-trash-2"></i> @lang('buttons.delete')
                </button>
            </form>
        @endif

    </span>
</span>
