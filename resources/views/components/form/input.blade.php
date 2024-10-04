@props([
'type' => 'text' ,
'name' ,
'value' => ""
])


<input type="{{ $type }}" id="{{ $id ?? $name }}" value='{{ old($name,$value) }}' name="{{$name}}"
    {{ $attributes->class(['form-control', 'is-invalid'=>$errors->has($name)]) }}>
