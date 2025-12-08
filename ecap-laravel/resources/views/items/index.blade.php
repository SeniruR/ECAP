@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/index.css">
@endpush

@push('scripts')
    <script src="/js/index.js" defer></script>
@endpush

@section('content')
    @php
        $announcement = \App\Models\Announcement::where('is_enabled', true)->latest()->first();
    @endphp
    @if($announcement)
        <div class="notice announcement-banner">
            @if(!empty($announcement->image))
                @php
                    $img = $announcement->image;
                    if ($img && !\Illuminate\Support\Str::startsWith($img, ['http://','https://','/storage/'])) {
                        $img = \Illuminate\Support\Facades\Storage::url($img);
                    }
                @endphp
                <div class="announcement-media">
                    <img src="{{ $img }}" alt="{{ $announcement->title ?? 'Announcement' }}">
                </div>
            @endif
            <div class="announcement-body">
                @if(!empty($announcement->title))
                    <h3 class="announcement-title">{{ $announcement->title }}</h3>
                @endif
                @if(!empty($announcement->content))
                    <div class="announcement-content">{!! $announcement->content !!}</div>
                @endif
            </div>
        </div>
    @endif
    <div class="banner">
        <img src="/images/index/index_banner.png" alt="Banner Image" loading="lazy">
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
                    <button class="scroll-btn left" data-target="card-wrapper-{{ $type->no }}">&lt;</button>
                    <button class="scroll-btn right" data-target="card-wrapper-{{ $type->no }}">&gt;</button>
                    <a href="{{ route('listall', ['type' => $type->no]) }}" class="all-btn">Show all</a>
                </div>
            </div>
            <div class="card-container-wrapper" id="card-wrapper-{{ $type->no }}">
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
                                        <div class="badge-new">New</div>
                                    @endif
                                    @if($imgSrc)
                                        <div class="media">
                                            <img src="{{ $imgSrc }}" alt="Item Image" loading="lazy">
                                        </div>
                                    @endif
                                    <div class="card-details">
                                        <h4 class="card-title">{{ $item->name }}</h4>
                                        <p class="card-desc">{{ $item->short_dis }}</p>
                                        <div class="card-divider"></div>
                                        <p class="card-price">LKR {{ number_format($item->price, 2) }}</p>
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
            <!-- <div class="line"></div> -->
            @php $counterMain++; @endphp
        @endforeach
    @else
        <div class="no-results">
            <p>We apologize for the inconvenience. Currently, there are no results to display. Please check back later or feel free to explore other categories. Thank you for your understanding.</p>
        </div>
    @endif
@endsection
