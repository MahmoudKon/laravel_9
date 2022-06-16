<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark">
    <div class="main-menu-content">
        <ul class="navigation navigation-main mb-5 pb-5" id="main-menu-navigation">

            <li class="nav-item has-sub">
                <a href="{{ routeHelper('tasks.users') }}">
                    <i class="fa fa-list"></i> <span class="menu-title">Tasks</span>
                </a>

                <ul class="menu-content">
                    <li class="nav-item" data-route="{{ ROUTE_PREFIX."tasks.users" }}">
                        <a href="{{ routeHelper('tasks.users') }}">
                            <i class="fa fa-users"></i> <span class="menu-title">Users</span>
                        </a>
                    </li>
                    <li class="nav-item" data-route="{{ ROUTE_PREFIX."tasks.categories" }}">
                        <a href="{{ routeHelper('tasks.categories') }}">
                            <i class="fa fa-list"></i> <span class="menu-title">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item" data-route="{{ ROUTE_PREFIX."tasks.posts" }}">
                        <a href="{{ routeHelper('tasks.posts') }}">
                            <i class="fa fa-list"></i> <span class="menu-title">Posts</span>
                        </a>
                    </li>
                    <li class="nav-item" data-route="{{ ROUTE_PREFIX."tasks.comments" }}">
                        <a href="{{ routeHelper('tasks.comments') }}">
                            <i class="fa fa-list"></i> <span class="menu-title">Comments</span>
                        </a>
                    </li>
                </ul>
            </li>

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
