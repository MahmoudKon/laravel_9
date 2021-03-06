<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header border-bottom-1 border-bottom-white bg-dark">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                        <i class="ft-menu font-large-1"></i>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="navbar-brand py-2" href="{{ routeHelper('/') }}">
                        <img class="brand-logo" alt="@lang('menu.logo')" src="{{ asset(setting('logo', 'uploads/logo/ivas.png')) }}">
                        <h3 class="brand-text white">@lang('menu.logo')</h3>
                    </a>
                </li>

                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" data-toggle="tooltip" title="@lang('title.toggle-menu')" href="#">
                            <i class="ft-menu"></i>
                        </a>
                    </li>

                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link nav-menu-main page-reload hidden-xs" data-toggle="tooltip" title="@lang('title.reload-page')" href="#">
                            <i class="fa fa-rotate-right"></i>
                        </a>
                    </li>

                    {{-- BEGIN SELECT THE LANGUAGES --}}
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="javascript:void(0)" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" title="@lang('title.change-language')">
                            <i class="flag-icon flag-icon-{{ (new App\Helpers\LaravelLocalization)->getCurrentFlagName() }}"></i>
                            <span class="selected-language"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ App::getLocale() !== $localeCode ? LaravelLocalization::getLocalizedURL($localeCode, null, [], true) : 'javascript:void(0)' }}">
                                <i class="flag-icon flag-icon-{{ $properties['flag'] }}"></i>
                                {{ $properties['native'] }}
                            </a>
                            @endforeach
                        </div>
                    </li>
                    {{-- END SELECT THE LANGUAGES --}}
                </ul>

                <ul class="nav navbar-nav float-right">
                    {{-- START AUTH LINKS --}}

                    <a class="nav-link mx-2" href="{{ routeHelper("profile.index") }}" style="line-height: 4;">
                        <span class="mr-1">@lang('menu.hello'),
                            <span class="user-name text-bold-700">{{ auth()->user()->name }}</span>
                        </span>
                        <span class="avatar avatar-online">
                            <img src="{{ asset(auth()->user()->image ?? "app-assets/backend/images/portfolio/portfolio-1.jpg") }}" alt="avatar">
                        </span>
                    </a>

                    {{-- <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">@lang('menu.hello'),
                                <span class="user-name text-bold-700">{{ auth()->user()->name }}</span>
                            </span>
                            <span class="avatar avatar-online">
                                <img src="{{ asset(auth()->user()->image ?? "app-assets/backend/images/portfolio/portfolio-1.jpg") }}" alt="avatar"><i></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ routeHelper("profile.index") }}" class="dropdown-item btn info"><i class="ft-info"></i> @lang('menu.profile')</a>

                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item btn red">
                                    <i class="ft-power"></i> @lang('menu.logout')
                                </button>
                            </form>
                        </div>
                    </li> --}}
                    {{-- END AUTH LINKS --}}

                    {{-- START NOTIFICATIONS --}}
                    @include('layouts.includes.backend.sections.notifications')
                    {{-- END NOTIFICATIONS --}}
                </ul>
            </div>
        </div>
    </div>
</nav>

