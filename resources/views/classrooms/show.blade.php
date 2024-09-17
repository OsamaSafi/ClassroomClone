<x-main-layout title="{{__('Classroom')}} - {{$classroom->name}}">
    <div class="container">

        {{-- <div class="p-2 border rounded" style="">
            <div class="rounded" style="background-image: url('{{Storage::disk('public')->url($classroom->cover_image_path)}}') ; background : cover;height: 300px;background-repeat: no-repeat;
                background-size: cover; color:#fff">
                <div style="height: 100%;padding:20px" class="d-flex justify-content-between align-items-end">
                    <div>
                        <h1> {{ $classroom->name }} - ({{ $classroom->id }})</h1>
                        <h4 class="pb-3">{{ $classroom->section }}</h3>
                    </div>
                    <p><a href="{{ route('classrooms.classworks.index',$classroom->id) }}" class="me-2 btn btn-dark"
                            style="">
                            {{__("Classworks")}}
                        </a>
                        <a href="{{ route('classrooms.topics.create',$classroom->id) }}"
                            class="me-2 btn btn-dark">{{__('Topics')}}</a>
                        <a href="{{ route('classrooms.people',$classroom->id) }}"
                            class="btn btn-dark">{{__('People')}}</a>
                    </p>
                </div>

            </div>
        </div> --}}
        <x-navbar-with-img title="Classroom" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="rounded border p-3 text-center">
                    <span class="fs-3 text-success">{{ $classroom->code }}</span>
                </div>
            </div>
            <div class="col-md-9">
                @foreach ($classroom->streams()->latest()->get() as $stream)
                <a href="{{ $stream->link }}" style="text-decoration: none;color:#000">
                    <div class="rounded border p-3 mb-3">
                        <p class="fs-5 text-success">{{$stream->content}}</p>
                        <span style="font-size: 15px ;color:#00000093">{{$stream->created_at->diffForHumans()}}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</x-main-layout>
