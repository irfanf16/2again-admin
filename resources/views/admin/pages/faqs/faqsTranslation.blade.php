@extends('admin.layouts.app')
@section('content')
@section('page_title','FAQs Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('faqs-edit') action="{{ route('admin.faqs.translation.update',$faqs->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>English Question</label>
                            <textarea class="form-control" disabled >{{$faqs->question}}</textarea>

{{--                            <input type="text" disabled value="{{$faqs->question}}"--}}
{{--                                   class="form-control">--}}
                        </div>
                        <div class="col-md-8 form-group">
                            <label>English Answer</label>
                            <textarea class="form-control" disabled >{{$faqs->answer}}</textarea>

{{--                            <input type="text" disabled value="{{$faqs->answer}}"--}}
{{--                                   class="form-control">--}}
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>Other Translations</h3>
                    </div>
                    <div class="row">
                        @foreach($data as $translate)
                            <input type="text" hidden name="language_id[]" value="{{$translate['question']['language']['id']}}">
                            <div class="col-md-4 form-group">
                                <label>{{$translate['question']['language']['name']}} Question </label>
                                <textarea class="form-control scroll-color" type="text" name="questions[]"  >{{$translate['question']['translation'] ?? null}}</textarea>

{{--                                <input type="text" name="questions[]" value="{{$translate['question']['translation'] ?? null}}"--}}
{{--                                       class="form-control">--}}
                            </div>
                            <div class="col-md-8 form-group">
                                <label>{{$translate['answer']['language']['name']}} Answer</label>
                                <textarea class="form-control scroll-color" type="text" name="answers[]"  >{{$translate['answer']['translation'] ?? null}}</textarea>

{{--                                <input type="text" name="answers[]" value="{{$translate['answer']['translation'] ?? null}}"--}}
{{--                                       class="form-control">--}}
                            </div>
                        @endforeach
                        @foreach($languages as $language)
                                <input type="text" hidden name="language_id[]" value="{{$language->languages->id}}">
                                <div class="col-md-4 form-group">
                                <label>{{$language->languages->name}} Question</label>
                                    <textarea class="form-control scroll-color" type="text" name="questions[]"  ></textarea>

{{--                                    <input type="text" name="questions[]" value="" class="form-control" placeholder="add question">--}}
                            </div>

                            <div class="col-md-8 form-group">
                                <label>{{$language->languages->name}} Answer</label>
                                <textarea class="form-control scroll-color" type="text" name="answers[]"  ></textarea>
{{--                                <input type="text" name="answers[]" value="" class="form-control" placeholder="add answer">--}}
                            </div>
                        @endforeach

                    </div>
                    @can('faqs-edit')
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    @endcan


                </div>
            </form>
        </section>
    </div>
</div>


@endsection
