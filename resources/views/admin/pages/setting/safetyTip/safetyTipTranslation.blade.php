@extends('admin.layouts.app')
@section('content')
@section('page_title','Safety Tip Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('safetyTip-edit') action="{{ route('admin.safety.translation.update',$safetyTips->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>English title</label>
                            <textarea class="form-control" disabled >{{$safetyTips->title}}</textarea>
{{--                            <input type="text" disabled value="{{$safetyTips->title}}"--}}
{{--                                   class="form-control">--}}
                        </div>
                        <div class="col-md-8 form-group">
                            <label>English Description</label>
{{--                            <input type="text" disabled value="{{$safetyTips->tip}}"--}}
{{--                                   class="form-control">--}}
                            <textarea class="form-control" disabled >{{$safetyTips->tip}}</textarea>

                        </div>
                    </div>
                    <div class="text-center">
                        <h3>Other Translations</h3>
                    </div>
                    <div class="row">
                        @foreach($data as $translate)
                            <input type="text" hidden name="language_id[]" value="{{$translate['title']['language']['id']}}">
                            <div class="col-md-4 form-group">
                                <label>{{$translate['title']['language']['name']}} Title</label>
                                <textarea class="form-control scroll-color" type="text"  name="title[]"  >{{$translate['title']['translation'] ?? null}}</textarea>

{{--                                <input type="text" name="title[]" value="{{$translate['title']['translation'] ?? null}}"--}}
{{--                                       class="form-control">--}}
                            </div>
                            <div class="col-md-8 form-group">
                                <label>{{$translate['title']['language']['name']}} Description</label>
                                <textarea class="form-control scroll-color" type="text"  name="tip[]"  >{{$translate['tip']['translation'] ?? null}}</textarea>

{{--                                <input type="text" name="tip[]" value="{{$translate['tip']['translation'] ?? null}}"--}}
{{--                                       class="form-control">--}}
                            </div>
                        @endforeach
                        @foreach($languages as $language)
                                <input type="text" hidden name="language_id[]" value="{{$language->languages->id}}">
                                <div class="col-md-4 form-group">
                                <label>{{$language->languages->name}} Title</label>
                                    <textarea class="form-control scroll-color" type="text"  name="title[]"  ></textarea>

{{--                                    <input type="text" name="title[]" value="" class="form-control" placeholder="add title">--}}
                            </div>

                            <div class="col-md-8 form-group">
                                <label>{{$language->languages->name}} Description</label>
                                <textarea class="form-control scroll-color" type="text"  name="tip[]" ></textarea>

{{--                                <input type="text" name="tip[]" value="" class="form-control" placeholder="add description">--}}
                            </div>
                        @endforeach

                    </div>
                    @can('safetyTip-edit')
                    <div class="text-right m-1 p-1">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    @endcan
                </div>
            </form>
        </section>
    </div>
</div>


@endsection
