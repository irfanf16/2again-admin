@extends('admin.layouts.app')

@section('content')
@section('page_title','Terms Of Use')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            <ul class="tabset">
                <li class="active"><a href="#TermsEn">English</a></li>
                <li><a href="#TermsDa">Danish</a></li>
            </ul>
            <div class="tab-content overflow-hidden mt-4 ">
                <div class="tab" id="TermsEn">
                    <form method="post" @can('legal-edit') action="{{route('admin.terms.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shortcode" value="TERM-En">
                        <div class="form-group">
                            <textarea  id="editor" name="description">{{$termsEn->description}}</textarea>
                        </div>
                        @can('legal-edit')
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>

                            </div>
                        @endcan
                    </form>
                </div>
                <div class="tab" id="TermsDa" style="display:none;">
                    <form method="post" @can('legal-edit') action="{{route('admin.terms.update')}}"
                          @endcan enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shortcode" value="TERM-Da">
                        <div class="form-group">
                            <textarea id="editor1" name="description">{{$termsDa->description}}</textarea>
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

<script type="text/javascript">
    $(document).ready(function () {
        initSample();
    });
</script>
@endsection
