@extends('transkriptor.layout')
@section('title','Kerjakan Tugas')

@section('content')

<a href="{{ route('transkriptor.tasks.show',$pesanan->id) }}"
    class="text-sm text-gray-600 hover:text-blue-600 mb-4 inline-flex items-center gap-1">
    ← Kembali
</a>

<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    </svg>
    Kerjakan Transkripsi
</h2>

<form method="POST" action="{{ route('transkriptor.tasks.update',$pesanan->id) }}">
@csrf

<div class="mb-4">
    <audio controls class="w-full">
        <source src="{{ route('transkriptor.tasks.audio',$pesanan->id) }}" type="audio/mpeg">
    </audio>
</div>

<div class="mb-4">
    <a href="{{ route('transkriptor.tasks.word',$pesanan->id) }}"
        class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        Download Word AI
    </a>
</div>

<textarea name="hasil_transkriptor"
    class="w-full h-72 border p-4 rounded-lg mb-4"
    placeholder="Perbaiki hasil transkripsi AI...">{{
        old(
            'hasil_transkriptor',
            $pesanan->transkripsi?->revisiTerakhir?->hasil_revisi
        )
    }}</textarea>


<div class="flex gap-3">
    <button name="submit" value="0"
        class="bg-yellow-500 hover:bg-yellow-600
        text-white px-6 py-2 rounded-lg font-semibold">
        Simpan
    </button>

    <button name="submit" value="1"
        onclick="return confirm('Kirim ke customer & tandai selesai?')"
        class="bg-green-600 hover:bg-green-700
        text-white px-6 py-2 rounded-lg font-semibold">
        Kirim ke Customer
    </button>
</div>

</form>
@endsection
