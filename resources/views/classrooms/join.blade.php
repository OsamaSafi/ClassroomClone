<x-main-layout title="{{__('Join Classrooms')}}">

    <div class="d-flex justify-content-center align-items-center vh100">
        <form action="{{ route('classrooms.join',$classroom->id) }}" method="post" class="border p-5">
            @csrf
            <h2 class="mb-3">{{ __($classroom->name) }}</h2>
            <button type="submit" class="btn btn-primary"> {{ __("Join") }}</button>
        </form>
    </div>

</x-main-layout>
