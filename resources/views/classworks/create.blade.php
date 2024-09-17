<x-main-layout title="{{__('Creat')}} {{$type}}">

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Creat {{$type}}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('classrooms.classworks.store',[$classroom->id,'type'=>$type]) }}" method="post">
                    @csrf

                    @include('classworks._form',[
                    "btn_type" => "Create"
                    ])
                </form>
            </div>
        </div>




    </div>
</x-main-layout>
