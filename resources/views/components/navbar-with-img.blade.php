<div class="p-2 mb-2 border rounded" style="">
    <div class="rounded" style="background-image: url('{{Storage::disk('public')->url($classroomCoverImg)}}') ; background : cover;height: 300px;background-repeat: no-repeat;
                        background-size: cover; color:#fff">
        <div style="height: 100%;padding:20px" class="d-flex justify-content-between align-items-end">
            <div>
                <h1> {{$title}} </h1>
                <h4 class="pb-3">{{ $classroomName }}</h3>
            </div>
            <p><a href="{{ route('classrooms.classworks.index',$classroomId) }}" class="me-2 btn btn-dark" style="">
                    {{__("Classworks")}}
                </a>
                <a href="{{ route('classrooms.topics.create',$classroomId) }}"
                    class="me-2 btn btn-dark">{{__('Topics')}}</a>
                <a href="{{ route('classrooms.people',$classroomId) }}" class="btn btn-dark me-2">{{__('People')}}</a>
                <a href="{{ route('classrooms.chat',$classroomId) }}" class="btn btn-dark">{{__('Chating')}}</a>
            </p>
        </div>

    </div>
</div>
