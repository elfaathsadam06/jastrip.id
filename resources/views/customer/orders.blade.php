@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')

<h1 class="text-3xl font-bold mb-6">📁 Daftar Pesanan Anda</h1>

@if($pesanan->count() == 0)
    <p class="text-gray-600">Belum ada pesanan.</p>
@else

<table class="w-full bg-white rounded-xl shadow">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Durasi</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($pesanan as $ps)
        <tr class="border-t">
            <td class="p-3">{{ $ps->id }}</td>
            <td class="p-3">{{ $ps->durasi }} menit</td>
            <td class="p-3">Rp{{ number_format($ps->total_biaya,0,',','.') }}</td>
            <td class="p-3 capitalize">{{ $ps->status }}</td>
            <td class="p-3 space-x-2">

                {{-- BAYAR --}}
                @if($ps->status == 'waiting_payment')
                    <a href="{{ route('payment.pay',$ps->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                        Bayar
                    </a>
                @endif

                {{-- LIHAT TRANSKRIP --}}
                @if($ps->status == 'completed')
                    <a href="{{ route('customer.transcript',$ps->id) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded">
                        Lihat Transkrip
                    </a>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endif

@endsection
