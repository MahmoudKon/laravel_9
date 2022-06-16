<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark">
    <div class="main-menu-content">
        <ul class="navigation navigation-main mb-5 pb-5" id="main-menu-navigation">

            @foreach ($list_menus as $row)
                @include('layouts.includes.backend.sections.list-menu', ['menu' => $row])
            @endforeach

            {{-- START LOGOUT LINK --}}
            <li class="nav-item text-center">
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="d-block w-100 btn btn-danger text-center" data-toggle="tooltip" title="@lang('menu.logout')"><i class="ft-power"></i></button>
                </form>
            </li>
            {{-- END LOGOUT LINK --}}

        </ul>
    </div>
</div>
