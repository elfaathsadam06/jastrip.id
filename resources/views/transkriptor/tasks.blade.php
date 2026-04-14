@extends('transkriptor.layout')
@section('title','Tugas Saya')

@section('content')

<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
    </svg>
    Tugas Transkripsi
</h2>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white shadow rounded-xl overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-4 text-left">Pesanan</th>
            <th class="p-4 text-center">Status</th>
            <th class="p-4 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody class="divide-y">
        @forelse($tasks as $task)

        @php
            $map = [
                'waiting'   => ['Waiting', 'bg-yellow-100 text-yellow-700', 'ClockIcon'],
                'working'   => ['Working', 'bg-blue-100 text-blue-700', 'PencilIcon'],
                'submitted' => ['Completed', 'bg-green-100 text-green-700', 'CheckIcon'],
            ];
            [$label, $color] = $map[$task->status_transkriptor] ?? ['-', 'bg-gray-100'];
        @endphp

        <tr>
            <td class="p-4 font-semibold">
                Pesanan #{{ $task->order_number }}
            </td>

            <td class="p-4 text-center">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                    {{ $label }}
                </span>
            </td>

            <td class="p-4 text-center">
                <a href="{{ route('transkriptor.tasks.show',$task->id) }}"
                    class="bg-blue-600 hover:bg-blue-700
                    text-white px-4 py-2 rounded-lg text-xs font-semibold">
                    Detail
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="p-6 text-center text-gray-500">
                Tidak ada tugas
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
