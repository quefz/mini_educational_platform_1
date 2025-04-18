@php
    $type = $type ?? 'text';
    $value = $value ?? null;
@endphp

<div class = 'form-group'>
    <label for = '{{ $name }}'>{{ $label }}</label>
    <input
        type = '{{ $type }}'
        class = 'form-control' @error($name) is-invalid @enderror
        id = '{{ $name }}'
        name = '{{ $name }}'
        value = '{{ $type !== 'file' ? (old( $name ) ?? ($value ?? '')) : ''}}'
        @if($type === 'file') accept = 'image/*' @endif
    >
</div>
