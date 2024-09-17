<x-main-layout :title="__('Classrooms')">
    <div class="container">
        <x-navbar-with-img title="People" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <x-alert name='success' />
        <x-alert name='danger' />
        <!-- /.card-header -->
        <div class="card">
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse" aria-expanded="false" aria-controls="flush-collaps">
                                <div class="d-flex justify-content-between" style="width: 100%">
                                    <span>{{__('Teachers')}}</span>
                                    <span class="me-5" style="color: rgb(153, 85, 85)">{{__('number of teachers')}} :
                                        {{ $teachers->count() }}</span>
                                </div>
                            </button>
                        </h2>
                        @forelse($teachers as $teacher)
                        <div id="flush-collapse" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionFlush">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between">
                                    <p>{{ __($teacher->name) }}</p>
                                    <span>{{ __($teacher->email) }}</span>
                                    @if ($teacher->id !== $classroom->user_id)
                                    <form action="{{ route('classrooms.people.destroy',$classroom->id) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="user_id" value="{{ $teacher->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Leave') }}</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="mx-3 my-3">{{ __('Not Found Teashers') }}</p>
                        @endforelse
                    </div>
                </div>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse" aria-expanded="false" aria-controls="flush-collapse">
                                <div class="d-flex justify-content-between" style="width: 100%">
                                    <span>{{__("Students")}}</span>
                                    <span class="me-5" style="color: rgb(153, 85, 85)">{{__('number of students')}} :
                                        {{ $students->count() }}</span>
                                </div>
                            </button>
                        </h2>
                        @foreach ($students as $student)
                        <div id="flush-collapse" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionFlush">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between">
                                    <p>{{ __($student->name) }}</p>
                                    <span>{{ __($student->email) }}</span>
                                    @can('people.delete', $classroom)
                                    <form action="{{ route('classrooms.people.destroy',$classroom->id) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="user_id" value="{{ $student->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">{{__('Delete')}}</button>
                                    </form>
                                    @endcan
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- /.card-body -->
    </div>
</x-main-layout>
