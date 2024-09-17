<x-main-layout title="{{__('Create Topics')}}">
    <div class="container">
        <x-navbar-with-img title="Topics" :classroom-name="$classroom->name" :classroom-id="$classroom->id"
            :classroom-cover-img="$classroom->cover_image_path" />
        <x-alert name='success' />
        @can('topic.manage', $classroom)
        <form action="{{ route('classrooms.topics.store',$classroom->id) }}" method="post">
            @csrf
            <x-form.floating-control name="name" label="{{__('Topic name')}}">
                <x-form.input type="text" name="name" id="name" placeholder="name" />
            </x-form.floating-control>
            <x-form.error name='name' />
            <button type="submit" class="btn btn-primary mb-3">{{__('Create Topic')}}</button>
        </form>
        @endcan
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="text-center table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Classroom')}}</th>
                            <th>{{__('User_id')}}</th>
                            <th colspan="2">{{__('Action')}}</th>
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
                            <td>
                                <a href="{{ route('classrooms.topics.edit',[$classroom->id,$topic->id]) }}"
                                    class="btn btn-outline-success">{{__('Edit')}}</a>
                            </td>
                            @endcan
                            <td>
                                <form action="{{ route('classrooms.topics.destroy',[$classroom->id,$topic->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger">
                                        {{__('Delete')}}
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
</x-main-layout>
