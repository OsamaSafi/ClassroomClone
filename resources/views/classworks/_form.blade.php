<div class="row">
    <div class="col-md-8">
        <x-form.floating-control name="title" label="{{__('Classwork title')}}">
            <x-form.input type="text" name="title" value="{{$classwork->title}}" id="title" placeholder="Title" />
        </x-form.floating-control>
        <x-form.error name="title" />

        <x-form.floating-control name="description" label="">
            <x-form.textarea name="description" value="{{$classwork->description}}" id="description"
                placeholder="{{__('description')}}" />
        </x-form.floating-control>
        <x-form.error name="description" />
    </div>
    <div class="col-md-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-dark mb-3 py-2" style="width: 100%;" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            {{__('Students')}}
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Students')}} ({{$classroom->students()->count()}})</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($classroom->students as $student)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="students[]" value="{{$student->id}}"
                                id="std-{{$student->id}}" @checked(!isset($student) || in_array($student->id,$students
                            ?? []))>
                            <label class="form-check-label" for="std-{{$student->id}}">
                                {{$student->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if ($type == "assignment")
        <x-form.floating-control name="published_at" label="published_at">
            <x-form.input name="published_at" type="date" :value="$classwork->published_date" id="published_at"
                placeholder="published_at" />
        </x-form.floating-control>

        <x-form.floating-control name="grade" label="{{__('grade')}}">
            <x-form.input name="grade" :value="$classwork->options['grade'] ?? ''" id="grade" placeholder="grade" />
        </x-form.floating-control>

        <x-form.floating-control name="due" label="due">
            <x-form.input name="due" type="date" :value="$classwork->options['due'] ?? ''" id="due" placeholder="due" />
        </x-form.floating-control>
        @endif
        {{-- ========================================= --}}
        <select class="form-select" name="topic_id" id="topic_id">
            <option value="">{{__('No topic')}}</option>
            @foreach ($classroom->topics as $topic)
            <option @selected($topic->id == $classwork->topic_id)
                value="{{ $topic->id }}">{{ __($topic->name) }}</option>
            @endforeach
        </select>
        <x-form.error name="topic_id" />
    </div>
</div>

<button type="submit" class="btn btn-dark mt-3">{{__($btn_type)}}</button>

@push('scripts')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph,
        Mention,
        SelectAll,
        Autosave,
        AccessibilityHelp,
        Undo
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#description' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ,AccessibilityHelp,Autosave,Mention,SelectAll,Undo],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|', 'selectAll', '|','accessibilityHelp',
                ]
            }
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>
@endpush
