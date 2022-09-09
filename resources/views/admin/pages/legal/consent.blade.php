@extends('admin.layouts.app')
@section('content')
@section('page_title','Consent')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <ul class="tabset">
                <li class="active"><a href="#English">English</a></li>
                <li><a href="#Danish">Danish</a></li>
            </ul>
            <div class="tab-content overflow-hidden mt-4 ">
                <div class="tab" id="English">
                    <form method="post" @can('legal-edit') action="{{route('admin.terms.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shortcode" value="CONSENT-En">
                        <div class="form-group">
                            <textarea id="" name="description" style="height: 400px;">{{$consentEn->description}}</textarea>
                        </div>
                        @can('legal-edit')
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>

                            </div>
                        @endcan
                    </form>
                </div>
                <div class="tab" id="Danish">
                    <form method="post" @can('legal-edit') action="{{route('admin.terms.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shortcode" value="CONSENT-Da">
                        <div class="form-group">
                            <textarea class="" name="description" style="height: 400px;">{{$consentDa->description}}</textarea>
                        </div>
                        @can('legal-edit')
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>

                            </div>
                        @endcan
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>


@endsection
