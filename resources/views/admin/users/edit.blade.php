@extends('admin.layout')
@section('title','Edit Customer')

@section('content')
<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    </svg>
    Edit Customer
</h2>

<form method="POST"
    action="{{ route('admin.users.update',$user->id) }}"
    class="bg-white p-8 rounded-xl shadow max-w-xl">
    @csrf
    @method('PUT')

    {{-- NAMA --}}
    <div class="mb-5">
        <label class="block text-sm font-semibold text-gray-600 mb-2">
            Nama
        </label>
        <input name="name" value="{{ $user->name }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"
            required>
    </div>

    {{-- EMAIL --}}
    <div class="mb-5">
        <label class="block text-sm font-semibold text-gray-600 mb-2">
            Email
        </label>
        <input name="email" value="{{ $user->email }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"
            required>
    </div>

    {{-- STATUS --}}
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-600 mb-2">
            Status
        </label>
        <select name="status"
            class="w-full border rounded-lg px-4 py-2">
            <option value="1" {{ $user->status ? 'selected' : '' }}>
                Aktif
            </option>
            <option value="0" {{ !$user->status ? 'selected' : '' }}>
                Nonaktif
            </option>
        </select>
    </div>

    {{-- ACTION --}}
    <div class="flex items-center gap-4">
        <button class="inline-flex items-center gap-2
            bg-blue-600 hover:bg-blue-700
            text-white px-6 py-2 rounded-lg font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Perubahan
        </button>

        <a href="{{ route('admin.users') }}"
            class="text-gray-600 hover:underline font-semibold">
            Batal
        </a>
    </div>
</form>
@endsection
