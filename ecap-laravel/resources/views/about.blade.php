@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/about.css">
@endpush

@section('content')
    <main class="about-page">
        <header class="about-hero">
            <div class="container">
                <h1>About Eco Creations &amp; Products</h1>
                <p class="lead">Connecting Sri Lanka's eco-conscious producers with buyers worldwide — sustainable, transparent, and community-driven.</p>
                <p class="hero-cta"><a class="btn btn-primary" href="{{ route('listall') }}">Browse Products</a></p>
            </div>
        </header>

        <section class="container about-grid">
            <article class="card">
                <h3>Who We Are</h3>
                <p>We are a platform dedicated to showcasing Sri Lanka's eco-friendly produce and handcrafted goods. We partner with small and medium-scale farmers and artisans who use sustainable practices and take pride in their craft.</p>
            </article>

            <article class="card">
                <h3>Our Mission</h3>
                <p>To empower local producers by providing visibility and access to ethical consumers worldwide. We promote sustainability, fair trade, and community resilience through transparent connections between buyers and sellers.</p>
            </article>

            <article class="card">
                <h3>What We Offer</h3>
                <p>A curated catalog of eco-friendly products, direct contact options to sellers, and growing tools to help producers reach new markets. Online payments and advanced commerce features are coming soon.</p>
            </article>
        </section>

        <section class="container about-team">
            <div class="team-intro">
                <h2>Our Values</h2>
                <p>We believe in sustainability, transparency, and community. Every product on our site reflects these values — from soil-friendly farming methods to ethical supply chains.</p>
            </div>
            <div class="team-cta">
                <a class="btn btn-ghost" href="{{ route('contact') }}">Contact Us</a>
            </div>
        </section>
    </main>
@endsection
