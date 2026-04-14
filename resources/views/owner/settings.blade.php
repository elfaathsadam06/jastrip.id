@extends('owner.layout')
@section('title','Pengaturan Owner')

@section('content')

{{-- HEADER --}}
<div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
    <h2 class="text-2xl font-bold">Pengaturan Owner</h2>
</div>

@if ($errors->any())
<div class="bg-red-100 text-red-700 border border-red-200
    px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
    </svg>

    {{ $errors->first('password') }}
</div>
@endif

{{-- ALERT --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 border border-green-200
    px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>

    {{ session('success') }}
</div>
@endif

{{-- FORM --}}
<div class="bg-white rounded-xl shadow p-6 max-w-xl">
<form method="POST" action="{{ route('owner.settings.update') }}" class="space-y-5">
    @csrf

    <div>
        <label class="text-sm font-medium text-gray-600">Nama</label>
        <input name="name" value="{{ $owner->name }}"
            class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-purple-200" required>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-600">Email</label>
        <input name="email" value="{{ $owner->email }}"
            class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-purple-200" required>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-600">
            Password Baru <span class="text-xs text-gray-400">(Opsional)</span>
        </label>
        <input type="password" name="password"
            class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-purple-200">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-600">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
            class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-purple-200">
    </div>

    <button
        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2
        rounded-lg font-semibold flex items-center gap-2 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Simpan Perubahan
    </button>
</form>
</div>

@endsection
