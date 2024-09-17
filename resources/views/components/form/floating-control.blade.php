<div class="form-floating mb-3">
    {{ $slot }}
    <label for="{{$name}}">{{$label}}</label>
    <x-form.error name="{{$name}}" />
</div>