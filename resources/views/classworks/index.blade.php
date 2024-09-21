<x-main-layout :title="$classroom->name">
    <div class="container">
        <x-navbar-with-img title="Classworks" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    @can('classworks.create', $classroom)
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            + {{__('Create')}}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('classrooms.classworks.create',[$classroom->id, 'type' => 'assignment']) }}">{{__('Assignment')}}</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('classrooms.classworks.create',[$classroom->id, 'type' => 'material']) }}">{{__('Material')}}</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('classrooms.classworks.create',[$classroom->id, 'type' => 'question']) }}">{{__('Question')}}</a>
                            </li>
                        </ul>
                    </div>
                    @endcan
                    <form class="row mt-3" action="{{ URL::current() }}" method="GET">
                        <div class="col-6 mb-2">
                            <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}"
                                placeholder="{{__('Search')}}" aria-label="Search">
                        </div>
                        <div class="col-3">
                            <select name="type" id="type" class="form-select">
                                <option value="">{{__('All Type')}}!</option>
                                <option value="assignment" @selected(request('type')=='assignment' )>
                                    {{__('Assignment')}}</option>
                                <option value="material" @selected(request('type')=='material' )>{{__('Material')}}
                                </option>
                                <option value="question" @selected(request('type')=='question' )>{{__('Question')}}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-success" type="submit">{{__('Search')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <hr>
        <x-alert name='success' />
        @foreach ($classworks as $group)
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="mb-3 text-success "> {{$group->first()->topic->name ?? "Unkown Topic"}} </h2>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($group as $classwork)
                    <section class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{$classwork->id}}" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                {{ $classwork->title }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{$classwork->id}}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">{!! $classwork->description !!}</div>
                                    <div class="col-md-6 row text-success">
                                        <div class="col-md-4 text-center ">
                                            <b class="text-center fs-4 ">{{ $classwork->users_count }}</b>
                                            <br>
                                            <p class="text-muted">Assigned</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <b class="text-center fs-4">{{ $classwork->turnedin_count }}</b>
                                            <br>
                                            <p class="text-muted">Turned-in</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <b class="text-center fs-4">{{ $classwork->graded_count }}</b>
                                            <br>
                                            <p class="text-muted">Graded</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start gap-3">
                                    @can('submissions.index', $classroom)
                                    <a href="{{ route('submissions.index',[$classwork->id]) }}"
                                        class="btn btn-sm btn-outline-dark">{{__('Submissions')}}</a>
                                    @endcan
                                    <a href="{{ route('classrooms.classworks.show',[$classroom->id,$classwork->id]) }}"
                                        class="btn btn-sm btn-outline-success">{{__('Show')}}</a>
                                    @can('classworks.update', $classroom)
                                    <a href="{{ route('classrooms.classworks.edit',[$classroom->id,$classwork->id]) }}"
                                        class="btn btn-sm btn-outline-primary">{{__('Edit')}}</a>
                                    @endcan
                                    @can('classworks.delete', $classroom)
                                    {{-- <form
                                        action="{{ route('classrooms.classworks.destroy',[$classroom->id,$classwork->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('delete') --}}
                                    <a href="#"
                                        onclick="confirmDelete('{{ $classroom->id }}','{{ $classwork->id }}', this)"
                                        class="btn btn-sm btn-outline-danger">{{__('Delete')}}</a>
                                    {{-- </form> --}}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </section>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @push('scripts')
    <script>
        classroomId = {{ $classwork->classroom_id ?? ""}};


        function confirmDelete(classroom_id,classwork_id,ref){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    destroy(classroom_id,classwork_id,ref)
                }
            });
        }
        function destroy(classroom_id,classwork_id,ref){
            axios.delete(`/classrooms/${classroom_id}/classworks/${classwork_id}`)
                .then(function (response) {
                    console.log(response.data);
                    ref.closest('div').parentNode.parentNode.parentNode.remove();
                    showMessage(response.data);
            })
            .catch(function (error) {
                console.log(error.response);
                showMessage(error.response.data);
            })
        }
        function showMessage(data){
            Swal.fire({
            icon: data.icon,
            title: data.message,
            showConfirmButton: false,
            timer: 3500
            });
        }
    </script>
    @endpush
</x-main-layout>
