@php
    $faq_sec = DB::table('sections')->where('page_id', 1)->get();
    $faq = DB::table('faq')->where('status', 1)->get();

@endphp
<section class="faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="client-say">
                    <h2>{{ $faq_sec[5]->value }}</h2>
                    {!! $faq_sec[6]->value !!}
                </div>
                <div class="faqs">
                    @foreach ($faq as $faq)
                        <div class="faq-item animate1">
                            <div class="faq-question">{{ $faq->title }}</div>
                            <div class="faq-answer">
                                {!! $faq->description !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
