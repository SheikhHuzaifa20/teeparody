@php
    $testi = DB::table('sections')->where('page_id', 1)->get();
    $testimonial = DB::table('testimonial')->where('status' , 1)->get();
@endphp
<section class="testimonial">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 p-0">
                <div class="client-say">
                    <h2><span class="blue">{{$testi[3]->value}}
                        </span></h2>
                    {!! $testi[4]->value !!}
                </div>
                <div class="testimonial-slider owl-carousel owl-theme">
                    @foreach ($testimonial as $t)
                    <div class="item">
                        <div class="customer-qoute">
                            <h5>
                                @for ($i = 0; $i < $t->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                @endfor
                                {{ number_format($t->rating, 1) }}</h5>
                            {!! $t->description !!}
                            <div class="customer-info">
                                <h5><img src="{{asset($t->image)}}" class="img-fluid" alt=""> {{$t->title}}
                                    <br> {{$t->text2}}
                                </h5>
                                <img src="{{asset('asset/images/qoute.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- <div class="item">
                        <div class="customer-qoute">
                            <h5><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> 5.0</h5>
                            <p> "The detail on The Four Kings design is unreal, and it honestly looks even better in
                                person than on screen. The shirt itself is thick without feeling heavy and fits true to
                                size. I wore it to church and to the gym in the same week, and it held up perfectly both
                                times. Quality you can actually feel."
                            </p>
                            <div class="customer-info">
                                <h5><img src="{{asset('asset/images/client-1.png')}}" class="img-fluid" alt=""> Denise R.
                                    <br> Verified Buyer
                                </h5>
                                <img src="{{asset('asset/images/qoute.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="customer-qoute">
                            <h5><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> 5.0</h5>
                            <p> "Grabbed the No Retreat tee for my daughter's basketball banquet, and the whole team
                                ended up wanting one. The artwork is full of energy, and the colors really pop off the
                                shirt. Shipping was quick, and everything arrived neatly packed. It is rare to find a
                                shirt this fun that is also this well-made."
                            </p>
                            <div class="customer-info">
                                <h5><img src="{{asset('asset/images/client-1.png')}}" class="img-fluid" alt=""> Kevin M.
                                    <br> Verified Buyer
                                </h5>
                                <img src="{{asset('asset/images/qoute.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="customer-qoute">
                            <h5><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                    class="fa-solid fa-star"></i> 5.0</h5>
                            <p> "To Infinity and Beyoncé had me laughing before I even hit order, and it is even better
                                in person. The design is crisp, the shirt is soft, and the fit is flattering without
                                being tight. I have bought three Teeparody tees now, and every single one has been a
                                hit. Customer for life."
                            </p>
                            <div class="customer-info">
                                <h5><img src="{{asset('asset/images/client-1.png')}}" class="img-fluid" alt=""> Aaliyah W.
                                    <br> Verified Buyer
                                </h5>
                                <img src="{{asset('asset/images/qoute.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>