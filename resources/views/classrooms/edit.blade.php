<x-main-layout title="Edit Classrooms">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('classrooms.index') }}">Home</a></li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">
                <h1>{{__('Edit')}} - {{ $classroom->id }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('classrooms.update',$classroom->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('classrooms._form',[
                    'button' => 'Update',
                    ])
                </form>
            </div>
        </div>

    </div>
</x-main-layout>