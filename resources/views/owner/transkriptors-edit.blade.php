@extends('owner.layout')
@section('title','Edit Transkriptor')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M4 15v-3a8 8 0 0116 0v3M4 15a2 2 0 002 2h1v-4H6a2 2 0 00-2 2zm16 0a2 2 0 01-2 2h-1v-4h1a2 2 0 012 2z"/>
        </svg>
        <h2 class="text-2xl font-bold">Edit Transkriptor</h2>
    </div>

    {{-- BACK --}}
    <a href="{{ route('owner.transkriptors') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

{{-- FORM --}}
<div class="bg-white rounded-xl shadow p-6 max-w-xl">
<form method="POST" action="{{ route('owner.transkriptors.update',$transkriptor->id) }}" class="space-y-5">
    @csrf
    @method('PUT')

    {{-- NAMA --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
        <input name="name" value="{{ $transkriptor->name }}" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-red-200" required>
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
        <input name="email" value="{{ $transkriptor->email }}" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-red-200" required>
    </div>

    {{-- PASSWORD --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Password Baru <span class="text-xs text-gray-400">(Opsional)</span>
        </label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-red-200">
    </div>

    {{-- ACTION --}}
    <div class="flex gap-4 pt-4">
        <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Perubahan
        </button>
    </div>
</form>
</div>

@endsection
