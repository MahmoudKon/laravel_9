<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">{{ strtoupper(trans('menu.'.getModel())) }}</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    @php $full_url = ""; @endphp
                    @foreach (convertUrlToArray() as $link)
                        @php $full_url .= "/$link"; @endphp

                        @if($loop->last || stripos($link, '{') !== false)
                            <li class="breadcrumb-item active">
                                @if ($link == "")
                                    @lang('menu.dashboard')
                                @elseif (stripos($link, "{") !== false)
                                @php $full_url = str_replace($link, getModelSlug($link, true), $full_url); @endphp
                                    {{ getModelSlug($link) }}
                                @else
                                    @lang("menu.$link")
                                @endif
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ url($full_url) }}">
                                    {{ $link == "" ? trans('menu.dashboard') : trans("menu.$link") }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
