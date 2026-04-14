@extends('transkriptor.layout')
@section('title','Detail Tugas')

@section('content')

<a href="{{ route('transkriptor.tasks.index') }}"
    class="text-sm text-gray-600 hover:text-blue-600 mb-4 inline-flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
</a>

<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
    Detail Tugas #{{ $task->id }}
</h2>

<div class="bg-white p-6 rounded-xl shadow space-y-6">

    {{-- Status --}}
    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor" class="size-5">
        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700 font-semibold">Status Tugas:</span>
        <span class="ml-2 inline-block px-3 py-1 rounded-full text-xs
            {{ $task->status_transkriptor === 'submitted'
                ? 'bg-green-100 text-green-700'
                : 'bg-yellow-100 text-yellow-700' }}">
            {{ ucfirst($task->status_transkriptor) }}
        </span>
    </div>

    {{-- Informasi Tugas --}}
    <div class="space-y-2">
        <p class="text-gray-700 font-semibold flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
            </svg>
            Informasi Tugas
        </p>
        <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
            <li><strong>ID Transkripsi Speech:</strong> {{ $task->transkripsi?->id ?? '-' }}</li>
            <li><strong>Dibuat pada:</strong> {{ $task->created_at->format('d M Y H:i') }}</li>
            <li><strong>Deadline:</strong> {{ $task->deadline?->format('d M Y H:i') ?? 'Harus Selesai Hari Ini!' }}</li>
        </ul>
    </div>

    {{-- Catatan / Instruksi --}}
    @if($task->catatan)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded flex items-start gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
        </svg>
        <p class="text-sm text-yellow-800">{{ $task->catatan }}</p>
    </div>
    @endif

    {{-- Kerjakan Tugas Button --}}
    @if($task->status_transkriptor !== 'submitted')
    <div>
        <a href="{{ route('transkriptor.tasks.edit',$task->id) }}"
            class="bg-green-600 hover:bg-green-700
            text-white px-5 py-2 rounded-lg font-semibold inline-flex items-center gap-3 text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                viewBox="0 0 20 20" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4" />
            </svg>
            Kerjakan Tugas
        </a>
    </div>
    @endif

</div>

@endsection
