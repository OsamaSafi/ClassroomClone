@props([
'name' ,
'value' => "",
'id'
])


<textarea name="{{ $name }}" id="{{ $id }}" cols="30" rows="80" {{ $attributes->class(['form-control', 'is-invalid'=>$errors->has($name)]) }}>{{ old($name,$value) }}
</textarea>
