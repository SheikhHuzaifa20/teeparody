@extends('layouts.main')
@section('content')
    <section class="banner about-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="banner-content animate">
                        <h1><span class="blue">{{ $banner->title }}</span>{{ $banner->text2 }}

                        </h1>
                        {!! $banner->description !!}
                        <a href="{{ route('product') }}" class="btn web-btn">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-girl">
            <img src="{{ asset('asset/images/banner-girl.png') }}" class="img-fluid" alt="">
        </div>
    </section>

    <section class="contact-pg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="client-say">
                        <h2>{{ $page->name }}</h2>
                        {!! $page->content !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="contact-info-pg">
                        <h3>{{ $section[0]->value }} </h3>
                        {!! $section[1]->value !!}
                        <ul>
                            <li>
                                <div class="social-author animate">
                                    <span><i class="fa-brands fa-facebook-f"></i></span>
                                    <h5>Facebook <span class="d-block">Author_Official</span></h5>
                                </div>
                            </li>
                            <li>
                                <div class="social-author animate">
                                    <span><i class="fa-brands fa-instagram"></i></span>
                                    <h5>Instagram <span class="d-block">Author_Official</span></h5>
                                </div>
                            </li>
                            <li>
                                <div class="social-author animate">
                                    <span><i class="fa-brands fa-twitter"></i></span>
                                    <h5>Twitter <span class="d-block">Author_Official</span></h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="contact-form">
                        <form action="{{ route('inquiry.store') }}" method="POST">
                        <div class="form-group">
                            <div class="row">
                                @csrf
                                <div class="col-6">
                                    <label>First Name</label>
                                    <input type="text" name="fname" class="form-control" placeholder="Full name*" required>
                                </div>
                                <div class="col-6">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" class="form-control" placeholder="Last name*" required>
                                </div>
                                <div class="col-6">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Your number*" required>
                                </div>
                                <div class="col-6">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email*" required>
                                </div>
                                <div class="col-12">
                                    <label>Messages</label>
                                    <textarea id="textarea" name="notes" class="form-control" placeholder="Type your message here..." rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn web-btn">Send Message</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <style>

    </style>
@endsection

@section('js')
    <script type="text/javascript"></script>
@endsection
