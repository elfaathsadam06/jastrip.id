@extends('admin.layout')
@section('title','Pesanan')

@section('content')

<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <!-- Box Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99" />
    </svg>
    Daftar Pesanan
</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow">
<table class="min-w-full text-sm">
    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Customer</th>
            <th class="px-4 py-3">Total</th>
            <th class="px-4 py-3 text-center">Status</th>
            <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody class="divide-y">
        @foreach($pesanan as $p)
        <tr class="hover:bg-gray-50">

            <td class="px-4 py-3 font-semibold">#{{ $p->order_number }}</td>

            <td class="px-4 py-3">
                <div class="font-semibold">{{ $p->user->name }}</div>
                <div class="text-xs text-gray-500">{{ $p->user->email }}</div>
            </td>

            <td class="px-4 py-3">
                <div class="font-semibold text-blue-600">
                    Rp {{ number_format($p->total_biaya,0,',','.') }}
                </div>

            @if($p->need_transkriptor_verification)
                <span class="inline-flex items-center gap-1
                    mt-1 text-xs bg-purple-100 text-purple-700
                    px-2 py-0.5 rounded-full font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    Verifikasi Transkriptor
                </span>
            @endif
            </td>

            <td class="px-4 py-3 text-center">
                @php
                    $statusColor = match($p->status) {
                        'waiting_payment' => 'bg-yellow-100 text-yellow-700',
                        'paid' => 'bg-blue-100 text-blue-700',
                        'processing' => 'bg-indigo-100 text-indigo-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                    {{ str_replace('_',' ', ucfirst($p->status)) }}
                </span>
            </td>

            <td class="px-4 py-3 text-center">
                <a href="{{ route('admin.pesanan.detail',$p->id) }}"
                    class="inline-flex items-center gap-1
                    bg-blue-600 hover:bg-blue-700 text-white
                    px-4 py-1.5 rounded-lg text-xs font-semibold transition">
                    Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
