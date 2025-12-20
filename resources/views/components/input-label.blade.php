@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#005461]']) }}>
    {{ $value ?? $slot }}
</label>
