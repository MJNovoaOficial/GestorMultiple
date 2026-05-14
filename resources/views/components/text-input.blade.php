@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => '
        border-gray-300
        bg-white
        text-black

        dark:bg-gray-800
        dark:text-white
        dark:border-gray-700

        focus:border-indigo-500
        focus:ring-indigo-500

        rounded-md
        shadow-sm
    '
]) }}>