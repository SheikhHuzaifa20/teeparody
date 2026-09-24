@php
    $faq = DB::table('sections')->where('page_id', 1)->get();   
@endphp
<section class="faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="client-say">
                    <h2>{{$faq[5]->value}}</h2>
                    {!! $faq[6]->value !!}
                </div>
                <div class="faqs">
                    <div class="faq-item animate1">
                        <div class="faq-question">{{$faq[7]->value}}</div>
                        <div class="faq-answer">
                            {!! $faq[8]->value !!}
                        </div>
                    </div>

                    <div class="faq-item animate1">
                        <div class="faq-question">{{$faq[9]->value}}</div>
                        <div class="faq-answer">
                            {!! $faq[10]->value !!}
                        </div>
                    </div>

                    <div class="faq-item animate1">
                        <div class="faq-question">{{$faq[11]->value}} </div>
                        <div class="faq-answer">
                            {!! $faq[12]->value !!}
                        </div>
                    </div>
                    <div class="faq-item animate1">
                        <div class="faq-question">{{$faq[13]->value}}</div>
                        <div class="faq-answer">
                            {!! $faq[14]->value !!}
                        </div>
                    </div>
                    <div class="faq-item animate1">
                        <div class="faq-question">{{$faq[15]->value}}</div>
                        <div class="faq-answer">
                            {!! $faq[16]->value !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>