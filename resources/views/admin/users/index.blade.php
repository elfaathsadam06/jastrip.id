@extends('admin.layout')
@section('title','Data Customer')

@section('content')
<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
    </svg>
    Data Customer
</h2>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="2"
            d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-6 py-4">Nama</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4 text-center">Status</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y">
        @foreach($users as $u)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 font-semibold text-gray-800">
                {{ $u->name }}
            </td>

            <td class="px-6 py-4 text-gray-600">
                {{ $u->email }}
            </td>

            <td class="px-6 py-4 text-center">
                @if($u->status)
                    <span class="inline-flex items-center gap-1 px-3 py-1
                        text-xs font-semibold rounded-full
                        bg-green-100 text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1
                        text-xs font-semibold rounded-full
                        bg-red-100 text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Nonaktif
                    </span>
                @endif
            </td>

            <td class="px-6 py-4 flex gap-3 justify-center">
                <a href="{{ route('admin.users.edit',$u->id) }}"
                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11
                                a2 2 0 002 2h11a2 2 0 002-2v-5
                                M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </a>

                <form method="POST"
                    action="{{ route('admin.users.delete',$u->id) }}"
                    onsubmit="return confirm('Hapus customer ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center gap-1
                        text-red-600 hover:text-red-800 text-sm font-semibold">
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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
