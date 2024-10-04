<x-main-layout title="Submissions">
    <div class="container">
        <x-alert name='success' />
        <x-alert name='danger' />
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
                            <th>{{__('Grade')}}</th>
                            @endif
                            {{-- <th colspan="2">{{__('Action')}}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (
                        $classwork->users()->wherePivot('status','=','submitted')->orWherePivot('status','=','returned')->get()
                        as $user )
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
                            <td>
                                <form action="{{ route('grade-submission',$submission->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <input type="number" min="0" max="{{$classwork->options['grade']}}" name="grade"
                                            id="grade"
                                            value="{{DB::table('classwork_user')->where('user_id',$submission->user_id)->where('classwork_id',$submission->classwork_id)->first()->grade}}">
                                        <button type="submit" class="btn btn-sm btn-success"><i
                                                class="fa-solid fa-check"></i></button>
                                    </div>
                                </form>
                            </td>

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

    @push('scripts')
    {{-- <script>
        function updateGrade(submissionId){
            axios.put(`/submissions/${submissionId}/grade`)
                .then(function (response) {
                console.log(response.data);
                toastr.success(response.data.message)
                window.location.href = `/submissions/${submissionId}/grade`
                })
                .catch(function (error) {
                console.log(error.response);
                toastr.error(error.response.data.message)
        })
        }
    </script> --}}
    @endpush
</x-main-layout>
