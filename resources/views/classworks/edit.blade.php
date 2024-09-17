<x-main-layout title="{{__('Update')}} {{__($type)}}">

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{__('Classworks')}}</h1>
                <h3> {{ $classroom->name }} (#{{ $classroom->id }})</h3>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('classrooms.classworks.update',[$classroom->id, $classwork->id,'type'=>$type]) }}"
                    method="post">
                    @csrf
                    @method('put')

                    @include('classworks._form',[
                    "btn_type" => "Update"
                    ])
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
