<x-main-layout :title="'Notification'|Auth::user()->name">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{__("Notifications")}} @if ($unreadCount)
                    <span class="badge bg-primary">{{$unreadCount}}</span>
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @forelse ($notifications as $notification)
                <div class="my-3 p-2 rounded" style="border:1px solid #0000004c">
                    {{-- <a href="{{ $notification->data['link'] }}" style="text-decoration: none;color:#000">
                    <div class="d-flex gap-2 align-items-center">
                        @if ($notification->unread())
                        <div style="background: blue;border-radius:100%;width:10px;height: 10px;"></div>
                        @endif
                        <div class="d-flex gap-2 align-items-center">
                            <img class="me-2" style="height: 30px;width: 30px; border-radius: 100%"
                                src="{{$notification->data['image']}}" alt="">
                            <p class="fs-5 text-success">{{$notification->data['body']}}</p>
                        </div>
                    </div>
                    <span style="font-size: 15px ;color:#00000093">{{$notification->created_at->diffForHumans()}}</span>
                    </a> --}}
                    <a class="dropdown-item" href="{{$notification->data['link']}}?nid={{$notification->id}}">
                        <div class="d-flex justify-content-start align-items-center gap-1">
                            @if ($notification->unread())
                            <div style="background: blue;border-radius:100%;width:10px;height: 10px;"></div>
                            @endif
                            <div class="d-flex gap-2">
                                <img class="me-2" style="height: 30px;width: 30px; border-radius: 100%"
                                    src="{{$notification->data['image']}}" alt="">
                                <p class="fs-5">{{$notification->data['body']}}</p>
                            </div>
                        </div>
                        <small class="text-muted">{{$notification->created_at->diffForHumans()}}</small>
                    </a>
                </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</x-main-layout>