<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
        <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow unread-notifications-count"> <b>{{ auth()->user()->unreadNotifications->Count() }}</b> </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <h6 class="dropdown-header m-0">
                <span class="grey darken-2">Notifications</span>
            </h6>
            <span class="notification-tag badge badge-default badge-danger float-right m-0 unread-notifications-count"> <b>{{ auth()->user()->unreadNotifications->Count() }}</b> New</span>
        </li>
        
        <li class="scrollable-container media-list w-100">
            @forelse (auth()->user()->unreadNotifications as $notification)
                <a class="read-unread-notifications" href="{{ routeHelper('read.notifications', $notification->id) }}">
                    <div class="media">
                        <div class="media-body">
                            <h6 class="media-heading">{{ $notification->data['title'] }}</h6>
                            <p class="notification-text font-small-3 text-muted"> {{ $notification->data['message'] }} </p>
                            <small>
                                <time class="media-meta text-muted">{{ $notification->created_at }}</time>
                            </small>
                        </div>
                    </div>
                </a>
            @empty
                <div class="media">
                    <p class="notification-text font-small-3 text-muted">No Notifications</p>
                </div>
            @endforelse
        </li>

        <li class="dropdown-menu-footer">
            <a class="dropdown-item text-muted text-center read-unread-notifications" href="{{ routeHelper('read.notifications') }}">Read all notifications</a>
        </li>
    </ul>
</li>
