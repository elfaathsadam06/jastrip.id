@extends('owner.layout')
@section('title','Kelola Transkriptor')

@section('content')

{{-- HEADER --}}
<div class="flex items-center gap-3 mb-6">
    <!-- Headphones Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="2" d="M4 15v-3a8 8 0 0116 0v3M4 15a2 2 0 002 2h1v-4H6a2 2 0 00-2 2zm16 0a2 2 0 01-2 2h-1v-4h1a2 2 0 012 2z"/>
    </svg>
    <h2 class="text-2xl font-bold">Kelola Transkriptor</h2>
</div>

{{-- ALERT --}}
@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
    <!-- Check Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>

    {{ session('success') }}
</div>
@endif

{{-- FORM TAMBAH TRANSKRIPTOR --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h3 class="font-semibold mb-4 flex items-center gap-2">
        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-red-600"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Transkriptor
    </h3>

    <form method="POST" action="{{ route('owner.transkriptors.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        <input name="name" placeholder="Nama Transkriptor"
            class="border rounded-lg px-3 py-2 focus:ring focus:ring-red-200" required>
        <input name="email" placeholder="Email Transkriptor"
            class="border rounded-lg px-3 py-2 focus:ring focus:ring-red-200" required>
        <button class="bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-2 font-semibold flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </button>
    </form>
</div>

{{-- TABLE TRANSKRIPTOR --}}
<div class="bg-white rounded-xl shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
            <th class="px-6 py-4 text-left">Nama</th>
            <th class="px-6 py-4 text-left">Email</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y">
    @foreach($transkriptors as $t)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-medium">{{ $t->name }}</td>
            <td class="px-6 py-4 text-gray-600">{{ $t->email }}</td>
            <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-4">
                    {{-- EDIT --}}
                    <a href="{{ route('owner.transkriptors.edit',$t->id) }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form method="POST"
                        action="{{ route('owner.transkriptors.delete',$t->id) }}"
                        onsubmit="return confirm('Hapus transkriptor ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                    a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                    M1 7h22m-5-3H6a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2z"/>
                        </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

@endsection
