@php
    $label = $label ?? 'level';
    $selected = old('level', $selected ?? '');
@endphp

<div class = 'form-group mb-4'>
    <label for = 'level'>{{ $label}}</label>
    <select
        class = 'form-control' @error('level') is-invalid @enderror
        id = 'level'
        name = 'level'
    >

        <option value = '' disabled {{ $selected == '' ? 'selected' : ''}}>Select a level</option>
        <option value = 'beginner' {{ $selected == 'beginner' ? 'selected' : ''}}>Beginner</option>
        <option value = 'intermediate' {{ $selected == 'intermediate' ? 'selected' : ''}}>Intermediate</option>
        <option value = 'advanced' {{ $selected == 'advanced' ? 'selected' : ''}}>Advanced</option>
    </select>
    @error('level')
        <div class = 'invalid-feedback'>{{ $message }}</div>
    @enderror
</div>
