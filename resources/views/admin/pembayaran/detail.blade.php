@extends('admin.layout')
@section('title','Detail Pembayaran')

@section('content')
@php
    $pembayaran = $pesanan->pembayaran;
@endphp

@if(session('warning'))
    <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ session('warning') }}
    </div>
    @endif

    @if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<div class="mb-4">
    <a href="{{ session('admin_payment_back', route('admin.dashboard')) }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

<h2 class="text-2xl font-bold mb-6">
    Verifikasi Pembayaran Pesanan #{{ $pesanan->id }}
</h2>

<div class="bg-white rounded-xl shadow p-6 space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <p class="text-sm text-gray-500">Customer</p>
            <p class="font-semibold">{{ $pesanan->user->name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Total Pembayaran</p>
            <p class="font-bold text-blue-600">
                Rp{{ number_format($pesanan->total_biaya,0,',','.') }}
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Metode Pembayaran</p>
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                {{ strtoupper($pembayaran->method ?? '-') }}
            </span>
        </div>

        <div>
            <p class="text-sm text-gray-500">Status</p>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                {{ str_replace('_',' ', ucfirst($pesanan->status)) }}
            </span>
        </div>
    </div>

    {{-- BUKTI --}}
    @if($pembayaran && $pembayaran->bukti)
        <div>
            <p class="font-semibold mb-2">Bukti Pembayaran</p>
            <img src="{{ asset('storage/'.$pembayaran->bukti) }}"
                class="max-w-md rounded-lg border shadow">
        </div>
    @endif

    {{-- ACTION --}}
    @if($pesanan->status === 'waiting_verification')
        <div class="flex gap-4 pt-6">
            <form method="POST" action="{{ route('pembayaran.approve', $pesanan->id) }}">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    ✔ Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('pembayaran.reject', $pesanan->id) }}">
                @csrf
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                    ✖ Tolak
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
