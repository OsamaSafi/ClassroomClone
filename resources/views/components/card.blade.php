<div class="card mb-4">
    <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}" class="card-img-top" alt="">
    <div class="card-header">
        {{-- <p>{{ $user->name ?? "" }}</p> --}}
        <a href="{{ route('profile.show',[$user->id,$classroom->id]) }}" class="mb-3" style="text-decoration: none">
            <div class="d-flex justify-content-between align-items-center ">
                <div>
                    @if ($classroom->teachers()->first()->profile->user_img_path)
                    <img style="height: 60px;width: 60px;border-radius: 100%;"
                        src="{{ Storage::disk('public')->url($classroom->teachers()->first()->profile->user_img_path) }}"
                        class="card-img-top" alt="">
                    @endif
                </div>
                <div><span>{{ $classroom->teachers()->first()->profile->full_name }}</span></div>
            </div>
        </a>
    </div>
    <div class="card-body">
        <h5 class="card-title mt-3">{{ $classroom->name }}</h5>
        <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
        <div class="d-flex justify-content-start gap-2">
            <a href="{{ route('classrooms.show',$classroom->id) }}" class="btn btn-outline-primary"><i class="fa-solid fa-square-up-right"></i></a>
            @can('classroom.manage', $classroom)
            <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-outline-success"><i class="fa-solid fa-pen-to-square"></i></a>
            @endcan
            <form action="{{ route('classrooms.destroy',$classroom->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    </div>
</div>
