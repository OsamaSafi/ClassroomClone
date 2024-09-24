<x-main-layout title="{{__('Topics')}}">
    <div class="container">
        <x-navbar-with-img title="Topics" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <x-alert name='success' />
        <div class="card">
            <div class="card-header">
                <h2>Topics <a href="{{ route('classrooms.topics.create',[$classroom->id]) }}" class="btn btn-primary"><i
                            class="fa-solid fa-square-plus"></i></a></h2>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="text-center table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Classroom')}}</th>
                            <th>{{__('User_id')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    @if ($topics->count())
                    <tbody>
                        @foreach ($topics as $topic)
                        <tr>
                            <td>{{ $topic->id }}</td>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $classroom->name }}</td>
                            <td>{{ $topic->user_id}}</td>
                            @can('topic.manage', $classroom)
                            <td class="d-flex justify-content-center">

                                <a href="{{ route('classrooms.topics.edit',[$classroom->id,$topic->id]) }}"
                                    class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>

                                @endcan
                                <form>
                                    <button onclick="confirmDelete('{{$classroom->id}}','{{$topic->id}}',this)"
                                        type="button" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endforeach
                    </tbody>
                    @else
                    <td colspan="10" class="text-left">{{__('Topic not found')}}</td>
                    @endif
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(classroom,topic,ref){
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
            destroy(classroom,topic,ref)
            }
            });
        }

        function destroy(classroom,topic,ref){
            axios.delete(`/classrooms/${classroom}/topics/${topic}`)
            .then(function (response) {
            console.log(response.data);
            ref.closest('tr').remove();
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

    @endpush
</x-main-layout>
