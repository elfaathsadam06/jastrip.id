@extends('owner.layout')
@section('title','Kelola Admin')

@section('content')

{{-- HEADER --}}
<div class="flex items-center gap-3 mb-6">
    <div class="p-2 text-red-600 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2"
                d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"/>
        </svg>
    </div>
    <h2 class="text-2xl font-bold">Kelola Admin</h2>
</div>

{{-- ALERT --}}
@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>

    {{ session('success') }}
</div>
@endif

{{-- FORM TAMBAH ADMIN --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h3 class="font-semibold mb-4 flex items-center gap-2">
        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-red-600"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Admin
    </h3>

    <form method="POST" action="{{ route('owner.admins.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        <input name="name" placeholder="Nama Admin"
            class="border rounded-lg px-3 py-2 focus:ring focus:ring-red-200" required>
        <input name="email" placeholder="Email Admin"
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

{{-- TABLE ADMIN --}}
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
    @foreach($admins as $a)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-medium">{{ $a->name }}</td>
            <td class="px-6 py-4 text-gray-600">{{ $a->email }}</td>
            <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-4">

                    {{-- EDIT --}}
                    <a href="{{ route('owner.admins.edit',$a->id) }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11
                                a2 2 0 002 2h11a2 2 0 002-2v-5
                                M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form method="POST"
                        action="{{ route('owner.admins.delete',$a->id) }}"
                        onsubmit="return confirm('Hapus admin ini?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="text-red-600 hover:text-red-800 flex items-center gap-1">
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
