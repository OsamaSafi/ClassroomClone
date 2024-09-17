<x-main-layout title="{{__('Classrooms Trached')}}">
    <div class="container">
        <x-alert name='success' />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="">{{ __('Classrooms Trached') }}</h1>
                    <div class="">
                        <a href="{{ route('classrooms.index') }}" class="btn btn-outline-dark">{{__('back')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row gy-3 mb-3">
                    @if ($classrooms->count())
                    @foreach ($classrooms as $classroom)
                    <div class=" col-md-3">
                        <div class="card">
                            <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}"
                                class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $classroom->name }}</h5>
                                <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('classrooms.restore',$classroom->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-success">{{__("Restore")}}</button>
                                    </form>
                                    <form action="{{ route('classrooms.force-delete',$classroom->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">{{__("Delete Forever")}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-danger mt-5">
                        {{__("Not Found Classrooms Trached")}}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    @push('styles')

    @endpush

    @push('scripts')

    @endpush
</x-main-layout>
