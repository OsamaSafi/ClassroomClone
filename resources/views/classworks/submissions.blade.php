<x-main-layout title="Submissions">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Submissions for {{__($classwork->type) . " " .  __($classwork->title)}}</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="text-center table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{__('Student')}}</th>
                            <th>{{__('Classwork Type')}}</th>
                            <th>{{__('File')}}</th>
                            @if( $classwork->type == 'assignment' )
                            <th>{{__('Grade From')}}</th>
                            @endif
                            {{-- <th colspan="2">{{__('Action')}}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $classwork->users()->wherePivot('status','=','submitted')->get() as $user )
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $classwork->type }}</td>
                            <td>
                                @foreach ($user->submissions as $submission)
                                <a class="badge bg-danger" href="{{ route('submissions.file',$submission->id) }}">File
                                    #{{$loop->index}}</a>
                                @endforeach
                            </td>
                            @if( $classwork->type == 'assignment' )
                            <td>
                                {{ $classwork->options['grade'] }}
                            </td>
                            @endif
                            {{-- <td>{{ $user-> }}</td> --}}
                        </tr>
                        @empty
                        <td colspan="10" class="text-left">{{__('Dont have any submissions')}}</td>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-main-layout>
