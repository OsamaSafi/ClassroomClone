<li class="nav-item dropdown scrollable">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Notifications
        @if ($unreadCount)
        <span class="badge bg-primary">{{$unreadCount}}</span>
        @endif
    </a>
    <ul class="dropdown-menu">
        <li class="p-3 border-bottom rounded mb-2">
            Notifications
        </li>
        @foreach ($notifications as $notification)
        <li class="">
            <a class="dropdown-item" href="{{$notification->data['link']}}?nid={{$notification->id}}">
                <div class="d-flex justify-content-start align-items-center gap-1">
                    @if ($notification->unread())
                    <div style="background: blue;border-radius:100%;width:10px;height: 10px;"></div>
                    @endif
                    <div>
                        <img class="me-2" style="height: 30px;width: 30px; border-radius: 100%"
                            src="{{$notification->data['image']}}" alt="">
                        {{$notification->data['body']}}
                    </div>
                </div>
                <small class="text-muted">{{$notification->created_at->diffForHumans()}}</small>
            </a>
            <hr>
        </li>
        @endforeach
        @if($notifications->count() > 4)
        <div class="text-center">
            <a href="{{route('notifications')}}" class="btn btn-sm btn-success my-2 mx-2">see all</a>
        </div>
        @endif
    </ul>

</li>