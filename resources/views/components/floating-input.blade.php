@props(['disabled' => false, 'id' => null, 'name' => null, 'label', 'type' => 'text'])

@php
    $id = $id ?? $name;
    $isPassword = $type === 'password';
@endphp

<div class="relative w-full" @if ($isPassword) x-data="{ show: false }" @endif>

    <input @if ($isPassword) :type="show ? 'text' : 'password'" @else type="{{ $type }}" @endif
        id="{{ $id }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' =>
                'block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer ' .
                ($isPassword ? 'pr-10' : ''),
        ]) !!}
        placeholder=" " />

    <label for="{{ $id }}"
        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3  px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 ">
        {{ $label }}
    </label>

    @if ($isPassword)
        <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none"
            tabindex="-1" aria-label="Toggle password visibility">
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-eye" viewBox="0 0 16 16">
                <path
                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
            </svg>

            <svg x-cloak x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="16"
                height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                <path
                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                <path
                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                <path
                    d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
            </svg>
        </button>
    @endif
</div>
