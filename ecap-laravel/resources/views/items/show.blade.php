@extends('layouts.app')

@section('content')
    <style>
        .container { display: flex; flex-wrap: wrap; margin: 4%; }
        .image-container { flex: 1 1 35%; box-sizing: border-box; text-align: center; margin-bottom: 20px; }
        .text-container { flex: 3 1 65%; box-sizing: border-box; padding: 0 20px; text-align: justify; }
        .image-container img { width: 80%; height: auto; border-radius: 20px; }
        .thumbnail-container { display: flex; justify-content: center; margin-top: 10px; }
        .thumbnail-container img { width: 60px; height: 60px; margin: 0 5px; cursor: pointer; border-radius: 10px; border: 2px solid transparent; }
        .thumbnail-container img:hover { border-color: #000; }
        @media (max-width: 768px) { .image-container, .text-container { flex: 1 1 100%; } }
        .itemname { text-align: center; margin: 40px 0; }
        .priceline { display: flex; justify-content: space-between; align-items: center; }
        .trademark { font-size: 12px; color: #888; margin-top: 10px; }
        .text-container p{ font-size: 14px; margin-top:0px; }
        .priceline p{ font-weight: bold; }
    </style>
    <div class="itemname">
        <h1>{{ $item->name }}</h1>
    </div>
    <div class="container">
        <div class="image-container">
            @php
                $firstImage = optional($images->first())->image;
                $mainSrc = $firstImage ? str_replace('./','/',$firstImage) : '';
                $imgPath = $mainSrc ? public_path(ltrim($mainSrc, '/')) : null;
                if (! $mainSrc || ! ($imgPath && file_exists($imgPath))) {
                    $mainSrc = '/images/products/logo.png';
                }
            @endphp
            <img id="mainImage" src="{{ $mainSrc }}" alt="Image">
            @if($images->count() > 1)
                <div class="thumbnail-container">
                    @foreach($images as $img)
                        @php $thumb = str_replace('./','/',$img->image); @endphp
                        <img src="{{ $thumb }}" alt="Thumbnail" onclick="changeImage('{{ $thumb }}')">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="text-container">
            <p>{!! $item->long_dis !!}</p>
            <h4>Contents</h4>
            <p>{!! $item->content !!}</p>
            <h4>Benefits</h4>
            <p>{!! $item->benefits !!}</p>
            <hr>
            <div class="priceline">
                <h4>Price</h4>
                <p>Rs. {{ $item->price }}</p>
            </div>
            @if(!empty($item->trademark))
                <br>
                <p class="trademark">{{ $item->trademark }}</p>
            @endif
        </div>
    </div>

    <script>
        function changeImage(imageSrc) {
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = imageSrc;
            }
        }
    </script>
@endsection
