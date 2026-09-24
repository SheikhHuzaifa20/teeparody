@php
    $phone = DB::table('m_flag')->where('id' , 1)->first();
    $sales_phone = DB::table('m_flag')->where('id' , 2)->first();
    $company_email = DB::table('m_flag')->where('id' , 3)->first();
    $copyright = DB::table('m_flag')->where('id' , 4)->first();
    $facebook = DB::table('m_flag')->where('id' , 5)->first();
    $twitter = DB::table('m_flag')->where('id' , 6)->first();
    $instagram = DB::table('m_flag')->where('id' , 7)->first();
    $youtube = DB::table('m_flag')->where('id' , 8)->first();
    $linkedin = DB::table('m_flag')->where('id' , 9)->first();
@endphp
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="footer-logo">
                    <img src="{{asset('asset/images/logo-footer.png')}}" class="img-fluid" alt="">
                    <p>Teeparody creates original pop-culture parody tees, designed and printed in the USA for people
                        who love a good laugh.</p>
                    <ul class="social-links">
                        <li class="yt">
                            <a href="{{$youtube->flag_value}}">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                        <li class="lk">
                            <a href="{{$linkedin->flag_value}}">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="tw">
                            <a href="{{$twitter->flag_value}}">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li class="fb">
                            <a href="{{$facebook->flag_value}}">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="it">
                            <a href="{{$instagram->flag_value}}">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="footer-logo">
                    <h5>HELP</h5>
                    <ul>
                        <li>
                            <a href="{{route('return_policy')}}">
                                SHIPPING & RETURN
                            </a>
                        </li>
                        <li>
                            <a href="{{route('terms_conditions')}}">
                                TERMS & CONDITIONS
                            </a>
                        </li>
                        <li>
                            <a href="{{route('privacy_policy')}}">
                                PRIVACY POLICY
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                REGISTER YOUR HOODIE
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                FREQUENTLY ASKED QUESTIONS (FAQS)
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                INFLUENCER PROGRAM
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                BECOME A DEALER
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-md-3 col-12">
                <div class="footer-logo">
                    <h5>COLLECTION</h5>
                    <ul>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                PRINT T SHIRT
                            </a>
                        </li>
                    </ul>
                </div>
            </div> -->
            <div class="col-lg-3 col-md-3 col-12">
                <div class="footer-logo">
                    <h5>CONNECT</h5>
                    <ul class="contact-info">
                        <li>
                            <h6>CONTACT US</h6>
                            <span>Assemblies & Service : </span>
                            <a href="tel:{{$phone->flag_value}}">
                                {{$phone->flag_value}}
                            </a>
                        </li>
                        <li>

                            <span>Sales Enquiry : </span>
                            <a href="tel:{{$sales_phone->flag_value}}">
                                {{$sales_phone->flag_value}}
                            </a>
                        </li>
                        <li>
                            <span>Enquiry </span>
                            <a href="mailto:{{$company_email->flag_value}}">
                                {{$company_email->flag_value}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <div class="last-para">
                    <p>{{$copyright->flag_value}}</p>
                    <ul>
                        <li>
                            <p>Payment </p>
                        </li>
                        <li>
                            <p>VISA </p>
                        </li>
                        <li>
                            <p>MASTERCARD </p>
                        </li>
                        <li>
                            <p>PAYPAL </p>
                        </li>
                        <li>
                            <p>BITCOIN </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>






</body>

</html>