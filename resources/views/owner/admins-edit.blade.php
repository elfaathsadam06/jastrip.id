@extends('owner.layout')
@section('title','Edit Admin')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="p-2 text-red-600 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M11 5h2m-1 0v14m7-7H5"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold">Edit Admin</h2>
    </div>

    {{-- BACK --}}
    <a href="{{ route('owner.admins') }}"
        class="flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2"
                d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

{{-- FORM CARD --}}
<div class="bg-white rounded-xl shadow p-8 max-w-2xl w-full">

<form method="POST"
    action="{{ route('owner.admins.update',$admin->id) }}"
    class="space-y-6">
    @csrf
    @method('PUT')

    {{-- NAMA --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Nama Admin
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-4">
                    <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                </svg>
            </span>
            <input name="name"
                value="{{ $admin->name }}"
                class="w-full pl-10 pr-4 py-2.5 border rounded-lg
                    focus:ring focus:ring-purple-200 focus:border-purple-400"
                required>
        </div>
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Email
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M5.404 14.596A6.5 6.5 0 1 1 16.5 10a1.25 1.25 0 0 1-2.5 0 4 4 0 1 0-.571 2.06A2.75 2.75 0 0 0 18 10a8 8 0 1 0-2.343 5.657.75.75 0 0 0-1.06-1.06 6.5 6.5 0 0 1-9.193 0ZM10 7.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd" />
                </svg>
            </span>
            <input name="email"
                value="{{ $admin->email }}"
                class="w-full pl-10 pr-4 py-2.5 border rounded-lg
                    focus:ring focus:ring-purple-200 focus:border-purple-400"
                required>
        </div>
    </div>

    {{-- PASSWORD --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Password Baru <span class="text-xs text-gray-400">(Opsional)</span>
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                    fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M8 1a3.5 3.5 0 0 0-3.5 3.5V7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7V4.5A3.5 3.5 0 0 0 8 1Zm2 6V4.5a2 2 0 1 0-4 0V7h4Z" clip-rule="evenodd" />
                </svg>
            </span>
            <input type="password"
                name="password"
                placeholder="Kosongkan jika tidak diubah"
                class="w-full pl-10 pr-4 py-2.5 border rounded-lg
                    focus:ring focus:ring-purple-200 focus:border-purple-400">
        </div>
    </div>

    {{-- ACTION --}}
    <div class="flex justify-end pt-4">
        <button
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700
                text-white px-6 py-2.5 rounded-lg font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Perubahan
        </button>
    </div>
</form>
</div>

@endsection
