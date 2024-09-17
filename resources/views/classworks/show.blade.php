<x-main-layout title="Show_Classwork">

    <div class="container">
        <x-alert name='success' />
        <x-alert name='danger' />
        <div class="card shadow mb-3">
            <div class="card-header">
                <h1>{{__('Classworks')}}</h1>
                <h3> {{ $classwork->title }} (#{{ $classwork->id }})</h3>
                <p>{{__('By')}}: {{ $userAssignment->first()->name ?? ""}} . {{ $classwork->created_at }}</p>
                <p>{{__('Grade')}}: {{ $classwork->options['grade'] ?? "0" }}</p>
            </div>
            <div class="card-body">
                <div>
                    <p>{!!$classwork->description!!}</p>
                </div>
                <hr>
            </div>


        </div>
        <div class="row">
            <div class="col-md-8 ">
                <div class="card shadow">
                    <div class="card-header">
                        <h2>{{__('Comments Classwork')}}</h2>
                    </div>
                    <div class="card-body">
                        <form class="mb-4" action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <div class="d-flex align-items-center gap-3">
                                <input type="hidden" name="comentable_type" value="classwork">
                                <input type="hidden" name="comentable_id" value="{{ $classwork->id }}">
                                <img class="me-2" style="border-radius: 100%;width:45px;height: 45px;"
                                    src="/images/user.jpg" alt="">
                                <x-form.floating-control name="content" label="{{__('Comment')}}">
                                    <x-form.textarea name="content" id="content" placeholder="Comment" />
                                </x-form.floating-control>
                                <button type="submit" class="btn btn-dark mt-3">{{__('Comment')}}</button>
                            </div>
                        </form>
                        <div>
                            @foreach ($classwork->comments()->with('user')->get() as $comment)
                            <div class="d-flex justify-content-start mb-4">
                                <img class="me-2" style="border-radius: 100%;width:30px;height: 30px;"
                                    src="/images/user.jpg" alt="">
                                <div class="p-3" style="background: #f4f4f9;border-radius:6px;width:100%">
                                    <div class="d-flex justify-content-between align-items-center gap-4">
                                        <div>
                                            <span style="font-size: 1.1rem">{{$comment->user?->name }}</span> .
                                            <span
                                                style="color: #74788d;font-size: .9rem">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div>
                                            @if (Auth::id() == $comment->user->id)
                                            <form action="{{ route('comments.delete',$comment->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">{{__('Delete')}}</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2" style="color: #74788d">
                                        {{ $comment->content }}
                                    </div>
                                </div>

                                <hr>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @can('submissions.create', $classwork)
            <div class="col-md-4 ">
                <div class="card shadow">
                    <div class="card-header">
                        <h2>
                            {{__('Submission')}}
                        </h2>
                    </div>
                    <div class="card-body">
                        @if ($submissions->count())
                        <ul>
                            @foreach ($submissions as $submission)
                            <li>
                                <a href="{{ route('submissions.file',$submission->id) }}">File
                                    #{{$loop->index}}</a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <form action="{{ route('submissions.store',$classwork->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <x-form.floating-control name="file" label="Classwork submission">
                                <x-form.input type="file" name="files[]" multiple id="files" placeholder="files" />
                            </x-form.floating-control>
                            <button type="submit" class="btn btn-success">{{__('Submit')}}</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endcan
        </div>


    </div>

</x-main-layout>
