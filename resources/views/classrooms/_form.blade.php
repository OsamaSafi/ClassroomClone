<x-form.floating-control name="name" label="{{__('Classroom Name')}}">
    <x-form.input name="name" type="text" id="name" value="{{ $classroom->name }}" placeholder="Name" />
</x-form.floating-control>

<x-form.floating-control name="section" label="{{__('Classroom Section')}}">
    <x-form.input type="text" name="section" id="section" value="{{ $classroom->section }}" placeholder="Section" />
</x-form.floating-control>

<x-form.floating-control name="subject" label="{{__('Classroom Subject')}}">
    <x-form.input type="text" name="subject" id="subject" value="{{ $classroom->subject }}" placeholder="subject" />
</x-form.floating-control>

<x-form.floating-control name="room" label="{{__('Classroom Room')}}">
    <x-form.input type="text" name="room" id="room" value="{{ $classroom->room }}" placeholder="room" />
</x-form.floating-control>

<x-form.floating-control name="cover_image" label="{{__('Classroom cover_image')}}">
    @if ($classroom->cover_image_path)
    <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}" width="600" alt="">
    @endif
    <x-form.input type="file" name="cover_image" id="cover_image" value="{{ $classroom->cover_image_path }}"
        placeholder="cover_image" />
</x-form.floating-control>

<button type="submit" class="btn btn-primary"> {{ __($button) }} </button>
