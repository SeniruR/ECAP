@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/forms.css">
@endpush

@section('content')
    <main class="form-page">
        <div class="form-container">
            <div class="form-card">
                <div class="left">
                    <h1>Contact Us</h1>
                    <p class="lead">We invite you to inquire about any product or service you are interested in. We aim to respond to all inquiries within regular business hours on weekdays.</p>
                    <p class="form-note"><a href="#details" onclick="document.getElementById('details').scrollIntoView({behavior:'smooth'})">Click here for more details</a></p>
                </div>
                <div class="right">
                    @if(session('status'))
                        <div class="alert">{{ session('status') }}</div>
                    @endif

                    <form name="contactus" action="{{ route('contact.send') }}" method="post">
                        @csrf
                        <div class="form-field">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name">
                        </div>
                        <div class="form-field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                        <div class="form-field">
                            <label for="contactno">Phone (optional)</label>
                            <input type="text" id="contactno" name="contactno" value="{{ old('contactno') }}" placeholder="(Optional)">
                        </div>
                        <div class="form-field">
                            <label for="type">Type</label>
                            <select name="type" id="type">
                                <option value="">Choose Option</option>
                                <option value="feedback" {{ old('type')=='feedback' ? 'selected' : '' }}>Feedback</option>
                                <option value="question" {{ old('type')=='question' ? 'selected' : '' }}>Question</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="message">Message</label>
                            <textarea class="myTextarea" id="message" name="message" rows="4" placeholder="Enter your message">{{ old('message') }}</textarea>
                        </div>

                        @if($errors->any())
                            <div class="alert">{{ $errors->first() }}</div>
                        @endif

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="details" class="contact-details container" style="margin-top:18px">
            <h2>Contact Details</h2>
            <p>241 /6 /1, Sama Mawatha, Mattegoda<br>Sri Lanka</p>
            <p>+94 (71) 5286-XXX</p>
            <p>support@ecap.com</p>
        </div>

        <div class="map" style="margin-top:12px">
            <iframe src="https://www.google.com/maps?q=Colombo,+Sri+Lanka&z=12&output=embed" width="100%" height="400" style="border:0;border-radius:10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        @push('scripts')
            <script src="/js/contactus.js" defer></script>
        @endpush
    </main>
@endsection
