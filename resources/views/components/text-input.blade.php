@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-black-400 focus:border-[#00B7B5] focus:ring-[#00B7B5] rounded-md shadow-sm']) }}>
