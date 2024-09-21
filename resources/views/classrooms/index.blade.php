<x-main-layout :title="__('Classrooms')">
    <div class="container">
        <x-alert name='success' />
        <x-alert name='danger' />
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h1 class="me-3">{{__('Classrooms')}}
                            {{-- <span><a href="{{ route('classrooms.trached') }}" class="btn
                            btn-primary">Trached</a></span>
                            --}}
                        </h1>
                    </div>
                    <div class="me-3 p-2">
                        <form action="{{ URL::current() }}" method="get" class="row">
                            <div class="col-9">
                                <input type="search" class="form-control" name="filter" id="search"
                                    value="{{ request('filter') }}" placeholder="{{ __('search...') }}">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-dark" type="submit"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($classrooms->count())
                    @foreach ($classrooms as $classroom)
                    <section class=" col-md-3">
                        <div class="card mb-4">
                            <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}"
                                class="card-img-top" alt="">
                            <div class="card-header">
                                {{-- <p>{{ $user->name ?? "" }}</p> --}}
                                <a href="{{ route('profile.show',[$classroom->user->id,$classroom->id]) }}" class="mb-3"
                                    style="text-decoration: none">
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <div>
                                            @if ($classroom->teachers()->first()->profile->user_img_path)
                                            <img style="height: 60px;width: 60px;border-radius: 100%;"
                                                src="{{ Storage::disk('public')->url($classroom->teachers()->first()->profile->user_img_path) }}"
                                                class="card-img-top" alt="">
                                            @endif
                                        </div>
                                        <div class="text-dark">
                                            <i class="fa-solid fa-user"></i> .
                                            <span> {{ $classroom->teachers()->first()->profile->full_name }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mt-3">{{ $classroom->name }}</h5>
                                <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                                <div class="d-flex justify-content-start gap-2">
                                    <a href="{{ route('classrooms.show',$classroom->id) }}"
                                        class="btn btn-outline-primary"><i class="fa-solid fa-square-up-right"></i></a>
                                    @can('classroom.manage', $classroom)
                                    <a href="{{ route('classrooms.edit', $classroom->id) }}"
                                        class="btn btn-outline-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @endcan
                                    {{-- <form action="{{ route('classrooms.destroy',$classroom->id) }}" method="POST">
                                    @csrf
                                    @method('delete') --}}
                                    <a href="#" onclick="confirmDelete('{{$classroom->id}}',this)"
                                        class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </section>
                    @endforeach
                    @else
                    <p class="text-center fs-4">{{__('No Classroom Found')}}</p>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('classrooms.create') }}" class="btn btn-outline-success me-2">
                            <i class="fa-solid fa-square-plus"></i>
                            {{__('Add')}}</a>
                        <a href="{{ route('classrooms.trached') }}" class="btn btn-outline-dark">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            {{__('Trached')}}</a>
                    </div>
                    {{ $classrooms->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('styles')

    @endpush

    @push('scripts')
    <script>
        function confirmDelete(id,ref){
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
                destroy(id,ref)
            }
            });
        }

        function destroy(id,ref){
            axios.delete('classrooms/' + id)
            .then(function (response) {
                console.log(response.data);
                ref.closest('section').remove();
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
                timer: 1500
            });
        }
    </script>
    <script>



    </script>

    @endpush
</x-main-layout>
