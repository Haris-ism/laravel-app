@props(['tag' => 'button'])

@if ($tag === 'a')
    <a
        {{ $attributes->merge([
            'class' => 'btn-primary inline-flex items-center justify-center px-5 py-2 rounded-md font-medium transition',
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'button',
            'class' => 'btn-primary inline-flex items-center justify-center px-5 py-2 rounded-md font-medium transition',
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
