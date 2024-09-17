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
                                <button class="btn btn-outline-dark" type="submit">{{__('Search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($classrooms->count())
                    @foreach ($classrooms as $classroom)
                    <div class=" col-md-3">
                        <x-card :classroom="$classroom" :user="$classroom->user" />
                    </div>
                    @endforeach
                    @else
                    <p class="text-center fs-4">{{__('No Classroom Found')}}</p>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('classrooms.create') }}"
                            class="btn btn-outline-success me-2">{{__('Add')}}</a>
                        <a href="{{ route('classrooms.trached') }}" class="btn btn-outline-dark">{{__('Trached')}}</a>
                    </div>
                    {{ $classrooms->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('styles')

    @endpush

    @push('scripts')

    @endpush
</x-main-layout>
