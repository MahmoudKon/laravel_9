{{-- START HEADER SECTION --}}
@include('layouts.includes.tasks.header')
{{-- END HEADER SECTION --}}


{{-- START NAVBAR SECTION --}}
@include('layouts.includes.tasks.navbar')
{{-- END NAVBAR SECTION --}}


{{-- START SIDEBAR SECTION --}}
@include('layouts.includes.tasks.sidebar')
{{-- END SIDEBAR SECTION --}}


<div class="app-content content">
    <div class="content-wrapper">

        {{-- START BREADCRUMB SECTION --}}
        @include('layouts.includes.tasks.breadcrumb')
        {{-- END BREADCRUMB SECTION --}}

        <div class="content-body">
            {{-- START ALERTS SECTION --}}
            @include('layouts.includes.tasks.alerts')
            {{-- END ALERTS SECTION --}}

            {{-- START CONTENT SECTION --}}
            @yield('content')
            {{-- END CONTENT SECTION --}}
        </div>
    </div>
</div>


{{-- START MODAL SECTION --}}
@include('layouts.includes.tasks.modal')
{{-- END MODAL SECTION --}}


{{-- START FOOTER SECTION --}}
@include('layouts.includes.tasks.footer')
{{-- END FOOTER SECTION --}}
