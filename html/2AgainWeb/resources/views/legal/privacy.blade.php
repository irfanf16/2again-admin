@extends('web.layouts.landingpage')
@section('content')

    <main id="mainweb" class="index-main">
        <section class="sectionmain">
            <div class="container">
                <div class="section-headermain text-center">

                    <h2 class="text-capitalize">Privacy Policy</h2>
                </div>
                <hr style="margin: 90px -9999px;">
                {!! $privacy->description !!}
            </div>
        </section>
    </main>
@endsection
