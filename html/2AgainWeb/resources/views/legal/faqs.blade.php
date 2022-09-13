@extends('web.layouts.landingpage')
@section('content')

    <main id="mainweb" class="index-main">
        <section class="sectionmain bg-blue-light">
            <div class="container">
                <div class="section-headermain text-center">
                    <p class="mb-2 text-gray"> FAQs</p>
                    <h2 class="text-capitalize">frequently asked questions</h2>
                    <p  class="mb-4 text-gray">Have questions? We are here to help.</p>
                </div>
                <div class="search-box faqs">
                    <form class="search-form">
                        <input type="search" id="myInput" onkeyup="myFunction()" class="form-control faq-search" placeholder="Search">
                        <button type="button" class="btn circle"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <hr style="margin: 90px -9999px;">
                <ul class="accordionmain" id="myUL" >
                    @foreach($faqs as $faq)
                    <li>
                        <a class="opener" href="javascript:void(0)">{{$faq->question}}</a>
                        <div class="slide">
                            <p>{{$faq->answer}}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>

    <script>
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
{{--    <script>--}}
{{--        $('.faq-search').on('keypress', function (event) {--}}
{{--                try {--}}
{{--                    $.ajax({--}}
{{--                        method: "POST",--}}
{{--                        url: window.location.origin + '/community/faqs/search',--}}
{{--                        data: {--}}
{{--                            keyword: this.value,--}}
{{--                            _token: $('meta[name="csrf_token"]').attr('content')--}}
{{--                        }--}}
{{--                    }).done(function (response) {--}}
{{--                        $('#faqs-list').empty()--}}
{{--                        response.faqs.forEach(faqslist);--}}
{{--                        function faqslist(value,index) {--}}
{{--                            $('#faqs-list').append(--}}
{{--                                $('<li/>').append(--}}
{{--                                    $('<a/>',{'class':'opener',href:'javascript:void(0)'}).append(--}}
{{--                                        value.question--}}
{{--                                    ),--}}
{{--                                    $('<div/>',{'class':'slide'}).append(--}}
{{--                                        $('<p/>').append(--}}
{{--                                            value.answer--}}
{{--                                        )--}}
{{--                                    )--}}
{{--                                )--}}
{{--                            )--}}
{{--                        }--}}
{{--                        initAccordion();--}}
{{--                    })--}}
{{--                } catch (e) {--}}
{{--                    results.innerHTML = e;--}}
{{--                }--}}

{{--        });--}}
{{--    </script>--}}
@endsection
