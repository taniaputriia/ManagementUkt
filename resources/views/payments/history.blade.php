@extends('layouts.app')

@section('content')
    <!-- Section: Timeline -->
    <section class="py-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Riwayat Pembayaran UKT</h4>
            </div>
            <div class="card-body">
                <ul class="timeline">
                    @forelse ($data as $item)
                        <li class="timeline-item mb-5">
                            <h5 class="fw-bold">{{ $item->payment->student->name }}</h5>
                            <p class="text-muted mb-2 fw-bold">
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, j F Y, H:i') }}</p>
                            <p class="text-muted">
                                {{ $item->description }}
                            </p>
                        </li>
                    @empty
                        <h5 class="text-center">Tidak Ada Data</h5>
                    @endforelse
                </ul>
                {{ $data->links() }}
            </div>
        </div>

    </section>
    <!-- Section: Timeline -->
@endsection
