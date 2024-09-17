@php
$class = $name == 'success' ? 'success': 'danger'
@endphp




@if (session()->has($name))
<div class="alert alert-{{$class}} alert-dismissible fade show" role="alert">
    {{ session($name)}}
</div>
@endif
