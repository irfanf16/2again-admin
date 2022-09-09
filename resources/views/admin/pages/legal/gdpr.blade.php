@extends('admin.layouts.app')

@section('content')
@section('page_title','GDPR')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <ul class="tabset">
                <li class="active"><a href="#English">English</a></li>
                <li><a href="#Danish">Danish</a></li>
            </ul>
            <div class="tab-content overflow-hidden mt-4 ">
                <div class="tab" id="English">
                    <form method="post" @can('legal-edit') action="{{route('admin.GDPR.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="shortcode" value="GDPR-En">
                            <textarea id="editor" name="gdpr">{{$gdprEn->description}}</textarea>
                        </div>
                        <div class="row">
                            <div class="text-left col-md-6">
                                <a href="{{route('admin.GDPR.view')}}" class="btn btn-success btn-sm">View Live</a>
                            </div>
                            @can('legal-edit')
                                <div class="text-right col-md-6">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
                <div class="tab" id="Danish">
                    <form method="post" @can('legal-edit') action="{{route('admin.GDPR.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="shortcode" value="GDPR-Da">
                            <textarea id="editor1" name="gdpr">{{$gdprDa->description}}</textarea>
                        </div>
                        <div class="row">
                            <div class="text-left col-md-6">
                                <a href="{{route('admin.GDPR.view')}}" class="btn btn-success btn-sm">View Live</a>
                            </div>
                            @can('legal-edit')
                                <div class="text-right col-md-6">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        initSample();
    });
</script>
@endsection
