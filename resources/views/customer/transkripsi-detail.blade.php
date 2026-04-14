@extends('layouts.app')
@section('title','Verifikasi Transkriptor')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M9 12h6m-6 4h6M9 8h6M5 3h14a2 2 0
                    012 2v14a2 2 0
                    01-2 2H5a2 2 0
                    01-2-2V5a2 2 0
                    012-2z"/>
            </svg>
        </div>

        <div>
            <h2 class="text-xl font-bold">
                Verifikasi Transkriptor
            </h2>
            <p class="text-sm text-gray-500">
                Pesanan #{{ $pesanan->order_number }}
            </p>
        </div>
    </div>

    {{-- HASIL TRANSKRIPTOR --}}
    <div class="bg-purple-50 border-l-4 border-purple-500
                p-5 rounded-lg text-sm leading-relaxed">
        {{ $revisi->hasil_revisi }}
    </div>

    {{-- CATATAN --}}
    @if($revisi->catatan)
        <div class="mt-4 text-sm text-gray-600">
            <strong>Catatan Transkriptor:</strong>
            {{ $revisi->catatan }}
        </div>
    @endif

    {{-- DOWNLOAD --}}
    <div class="flex gap-3 mt-6">
        <a href="{{ route('customer.transcript.word', $pesanan->id) }}"
            class="inline-flex items-center gap-2 px-4 py-2
                bg-blue-600 text-white rounded-lg text-sm">

            {{-- Heroicon download --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M12 4v12m0 0l4-4m-4 4l-4-4M4 20h16"/>
            </svg>
            Download Word
        </a>

        <a href="{{ route('customer.transcript.pdf', $pesanan->id) }}"
            class="inline-flex items-center gap-2 px-4 py-2
                bg-red-600 text-white rounded-lg text-sm">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M12 4v12m0 0l4-4m-4 4l-4-4M4 20h16"/>
            </svg>
            Download PDF
        </a>
    </div>

    {{-- BACK --}}
    <a href="{{ url()->previous() }}"
        class="inline-flex items-center gap-1 mt-6
            text-blue-600 hover:underline text-sm">
        ← Kembali
    </a>

</div>
@endsection
