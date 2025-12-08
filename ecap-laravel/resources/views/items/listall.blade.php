@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/listall.css">
@endpush

@push('scripts')
    <script src="/js/index.js" defer></script>
@endpush

@section('content')
<main class="listall-main">
    <div class="topic">
        <h2>{{ $type?->name ?? 'Items' }}</h2>
        <div class="topic-discription">
            <p>{{ $type?->discription ?? 'Browse our items.' }}</p>
        </div>
    </div>
    <div class="card-container-wrapper">
        <div class="card-container" id="card-container">
            @forelse($items as $item)
                @php
                    $firstImage = optional($item->images->first())->image;
                    $imgSrc = $firstImage ? str_replace('./','/',$firstImage) : '';
                    $imgPath = $imgSrc ? public_path(ltrim($imgSrc, '/')) : null;
                    if (! $imgSrc || ! ($imgPath && file_exists($imgPath))) {
                        $imgSrc = '/images/products/logo.png';
                    }
                @endphp
                    <a href="{{ route('item.show', ['no' => $item->no]) }}" data-type="{{ $item->type }}">
                    <div class="card">
                        @if($imgSrc)
                            <div class="media">
                                <img src="{{ $imgSrc }}" alt="Item Image" loading="lazy">
                            </div>
                        @endif
                        <div class="card-details">
                            <h2 class="card-title">{{ $item->name }}</h2>
                            <p class="card-desc">{{ $item->short_dis }}</p>
                            <div class="card-divider"></div>
                            <p class="card-price">LKR {{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <p>No results found.</p>
            @endforelse
        </div>
    </div>
</main>
@endsection
