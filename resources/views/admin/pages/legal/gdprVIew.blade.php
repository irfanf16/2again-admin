@extends('admin.layouts.app')

@section('content')
@section('page_title','GDPR Pdf View')

<style>
    .MsoNormal{
        line-height: 21px !important;
    }
</style>
<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="content-box p-3">
                {!! $gdpr !!}
            </div>
        </section>
    </div>
</div>

@endsection
