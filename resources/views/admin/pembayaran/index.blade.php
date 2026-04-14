@extends('admin.layout')
@section('title','Pembayaran')

@section('content')
<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    {{-- Check Circle Heroicon --}}
    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="w-6 h-6 text-blue-600">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75 11.25 15 15 9.75
                M21 12a9 9 0 1 1-18 0
                9 9 0 0 1 18 0Z"/>
    </svg>
    Verifikasi Pembayaran
</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow">
<table class="min-w-full text-sm">
    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Customer</th>
            <th class="px-4 py-3">Metode</th>
            <th class="px-4 py-3">Total</th>
            <th class="px-4 py-3 text-center">Status</th>
            <th class="px-4 py-3 text-center">Bukti</th>
            <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody class="divide-y">
    @forelse($pesanan as $p)
        @php
            $pembayaran = $p->pembayaran;
        @endphp

        <tr class="hover:bg-gray-50">

            {{-- ID --}}
            <td class="px-4 py-3 font-semibold">
                #{{ $p->id }}
            </td>

            {{-- CUSTOMER --}}
            <td class="px-4 py-3">
                <div class="font-semibold">{{ $p->user->name }}</div>
                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
            </td>

            {{-- METODE --}}
            <td class="px-4 py-3">
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                    {{ strtoupper($pembayaran->method ?? '-') }}
                </span>
            </td>

            {{-- TOTAL --}}
            <td class="px-4 py-3 font-semibold text-blue-600">
                Rp{{ number_format($p->total_biaya,0,',','.') }}
            </td>

            {{-- STATUS --}}
            <td class="px-4 py-3 text-center">
                @php
                    $statusColor = match($p->status) {
                        'waiting_verification' => 'bg-yellow-100 text-yellow-700',
                        'paid' => 'bg-green-100 text-green-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-emerald-100 text-emerald-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                    {{ str_replace('_',' ', ucfirst($p->status)) }}
                </span>
            </td>

            {{-- BUKTI --}}
            <td class="px-4 py-3 text-center">
                @if($pembayaran && $pembayaran->bukti)
                    <a href="{{ asset('storage/'.$pembayaran->bukti) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1 text-blue-600 font-semibold hover:underline">
                        {{-- Eye Heroicon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12s3.75-7.5
                                    9.75-7.5 9.75 7.5
                                    9.75 7.5-3.75 7.5
                                    -9.75 7.5S2.25 12 2.25 12Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0
                                    3 3 0 0 1 6 0Z"/>
                        </svg>
                        Lihat
                    </a>
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td class="px-4 py-3 text-center">
                <a href="{{ route('pembayaran.detail', $p->id) }}"
                    class="inline-flex items-center gap-1
                        bg-blue-600 hover:bg-blue-700 text-white
                        px-4 py-1.5 rounded-lg text-xs font-semibold transition">

                    {{-- Document Text Heroicon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 4.5h7.5
                            A2.25 2.25 0 0 1 18 6.75v10.5
                            A2.25 2.25 0 0 1 15.75 19.5h-7.5
                            A2.25 2.25 0 0 1 6 17.25V6.75
                            A2.25 2.25 0 0 1 8.25 4.5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 9h6M9 12h6M9 15h3"/>
                    </svg>

                    Detail
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                Belum ada pembayaran
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="mt-6">
    {{ $pesanan->links() }}
</div>
@endsection
