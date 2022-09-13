@extends('web.layouts.landingpage')
@section('content')

    <main id="mainweb" class="index-main">
        <section class="sectionmain bg-blue-light safetymain">
            <div class="container">
                <div class="section-headermain text-center">
                    <div class="img-box">
                        <img src="{{asset('images/safety-1.png')}}" alt="">
                    </div>
                    <h2 class="text-capitalize">Safety Tips</h2>
                </div>
                <hr style="margin: 90px -9999px;">
                <ul class="accordionmain" id="faqs-list">
                    @foreach($safetyTips as $safetyTip)
                    <li>
                        <a class="opener" href="javascript:void(0)">{{$safetyTip->title}}</a>
                        <div class="slide">
                            <p>{{$safetyTip->tip}}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>

    <script>
        $('.faq-search').on('keypress', function (event) {
                try {
                    $.ajax({
                        method: "POST",
                        url: window.location.origin + '/community/faqs/search',
                        data: {
                            keyword: this.value,
                            _token: $('meta[name="csrf_token"]').attr('content')
                        }
                    }).done(function (response) {
                        $('#faqs-list').empty()
                        response.faqs.forEach(faqslist);
                        function faqslist(value,index) {
                            $('#faqs-list').append(
                                $('<li/>').append(
                                    $('<a/>',{'class':'opener',href:'javascript:void(0)'}).append(
                                        value.question
                                    ),
                                    $('<div/>',{'class':'slide'}).append(
                                        $('<p/>').append(
                                            value.answer
                                        )
                                    )
                                )
                            )
                        }
                        initAccordion();
                    })
                } catch (e) {
                    results.innerHTML = e;
                }

        });
    </script>
@endsection
