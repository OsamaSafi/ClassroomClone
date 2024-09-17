<x-main-layout title="Create Topics">
    <div class="container">
        <form action="{{ route('classrooms.topics.update',[$classroom->id,$topic->id]) }}" method="post">
            @csrf
            @method('put')
            <x-form.floating-control name="name" label="Topic name">
                <x-form.input type="text" name="name" id="name" placeholder="name" value="{{ $topic->name }}" />
            </x-form.floating-control>
            <x-form.error name='name' />
            <button type="submit" class="btn btn-primary mt-3">Update Topic</button>
        </form>
    </div>
</x-main-layout>
