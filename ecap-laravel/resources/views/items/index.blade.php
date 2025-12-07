@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/index.css">
@endpush

@push('scripts')
    <script src="/js/index.js" defer></script>
@endpush

@section('content')
    <div class="notice">
        Attention: This page is currently under maintenance. If you find any mistakes, please reach out to inform us.
    </div>
    <div class="banner">
        <img src="/images/index/index_banner.png" alt="Banner Image">
    </div>
    <div class="intro">
        <p>ECAP is dedicated to promoting sustainable living through a diverse range of eco-friendly products. Our mission is to make a positive impact on the environment by offering innovative solutions that help reduce waste and conserve resources. Join us in our journey towards a greener future and discover how you can contribute to a healthier planet.</p>
    </div>

    @php $counterMain = 0; @endphp
    @if($types->isNotEmpty())
        @foreach($types as $type)
            @if($counterMain > 0)
                <hr>
            @endif
            <div class="topic">
                <h3><a href="{{ route('listall', ['type' => $type->no]) }}">{{ $type->name }}</a></h3>
                <div class="arrow-btns">
                    <button class="scroll-btn left" onclick="scrollLeft('card-container-{{ $type->no }}')">&lt;</button>
                    <button class="scroll-btn right" onclick="scrollRight('card-container-{{ $type->no }}')">&gt;</button>
                    <a href="{{ route('listall', ['type' => $type->no]) }}" class="all-btn">Show all</a>
                </div>
            </div>
            <div class="card-container-wrapper">
                <div class="card-container" id="card-container-{{ $type->no }}">
                    @php $counter = 0; @endphp
                    @forelse($items as $item)
                        @if($item->type === $type->no && $counter < 8)
                            @php
                                $firstImage = optional($item->images->first())->image;
                                $imgSrc = $firstImage ? str_replace('./','/',$firstImage) : '';
                                $imgPath = $imgSrc ? public_path(ltrim($imgSrc, '/')) : null;
                                if (! $imgSrc || ! ($imgPath && file_exists($imgPath))) {
                                    $imgSrc = '/images/products/logo.png';
                                }
                            @endphp
                            <a href="{{ route('item.show', ['no' => $item->no]) }}">
                                <div class="card">
                                    @if(optional($item->created)->isFuture())
                                        <div class="newcard">
                                            <p>New</p>
                                        </div>
                                    @endif
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" alt="Item Image">
                                    @endif
                                    <div class="card-details">
                                        <p>{{ $item->name }}</p>
                                        <p>{{ $item->short_dis }}</p>
                                        <hr>
                                        <p>Rs. {{ $item->price }}</p>
                                    </div>
                                </div>
                            </a>
                            @php $counter++; @endphp
                        @endif
                    @empty
                        <div class="no-results">
                            <p>No items available in this category.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="line"></div>
            @php $counterMain++; @endphp
        @endforeach
    @else
        <div class="no-results">
            <p>We apologize for the inconvenience. Currently, there are no results to display. Please check back later or feel free to explore other categories. Thank you for your understanding.</p>
        </div>
    @endif
@endsection
