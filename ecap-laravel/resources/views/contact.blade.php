@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/loginformstyle.css">
@endpush

@section('content')
    @extends('layouts.app')

    @section('content')
        <div class="main">
            <div class="main_box">
                <div class="leftside">
                    <h1 style="color:rgb(34, 139, 34);">Contact Us</h1>
                    <h3>We invite you to inquire about any product or service you are interested in.</h3>
                    <h5>We aim to respond to all inquiries within regular business hours on weekdays</h5>
                    <div class="scroll-indicator">
                        <br>
                        <a href="#details" onclick="scrollToDetails(event)">
                            <p>Click here for more details</p>
                            <i class="arrow-down"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="rightside">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form name="contactus" action="{{ route('contact.send') }}" method="post">
                        @csrf
                        <table class="table">
                            <tr>
                                <td class="label-cell"><label for="name">Name</label></td>
                                <td class="input-cell"><input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name"></td>
                            </tr>
                            <tr>
                                <td class="label-cell"><label for="email">Email</label></td>
                                <td class="input-cell"><input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="Email"></td>
                            </tr>
                            <tr>
                                <td class="label-cell"><label for="contactno">Phone</label></td>
                                <td class="input-cell"><input type="text" id="contactno" name="contactno" value="{{ old('contactno') }}" placeholder="(Optional)"></td>
                            </tr>
                            <tr>
                                <td class="label-cell"><label for="type">Type</label></td>
                                <td class="input-cell">
                                    <select name="type">
                                        <option value="">Choose Option</option>
                                        <option value="feedback" {{ old('type')=='feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="question" {{ old('type')=='question' ? 'selected' : '' }}>Question</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell"><label for="message">Message</label></td>
                                <td class="input-cell"><textarea class="myTextarea" id="message" name="message" rows="4" placeholder="Enter your message">{{ old('message') }}</textarea></td>
                            </tr>
                            @if($errors->any())
                                <tr>
                                    <td colspan="2"><div style="color: red; text-align: center; margin-top: 10px; margin-bottom:0px">{{ $errors->first() }}</div></td>
                                </tr>
                            @endif
                            <tr class="button">
                                <td colspan="2"><button type="submit">Submit</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="details" class="contact-details">
            <h2>Contact Details</h2>
            <p>241 /6 /1, Sama Mawatha, Mattegoda<br>Srilanka</p>
            <p>+94 (71) 5286-XXX</p>
            <p>support@ecap.com</p>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1980.76712141372!2d79.96932498299404!3d6.826356661587588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1733332728656!5m2!1sen!2slk" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        @push('scripts')
            <script src="/js/contactus.js" defer></script>
        @endpush
    @endsection
