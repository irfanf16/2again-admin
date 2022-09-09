@extends('admin.layouts.app')
@section('content')
@section('page_title','Offers Translations')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('offers-edit') action="{{ route('admin.offers.translation.update',$offers->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>English Title</label>
                            <input type="text" disabled value="{{$offers->title}}"
                                   class="form-control">
                        </div>
                        <div class="col-md-8 form-group">
                            <label>English Description</label>
                            <input type="text" disabled value="{{$offers->description}}"
                                   class="form-control">
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
                                <input type="text" name="title[]" value="{{$translate['title']['translation'] ?? null}}"
                                       class="form-control">
                            </div>
                            <div class="col-md-8 form-group">
                                <label>{{$translate['title']['language']['name']}} Description </label>
                                <input type="text" name="description[]" value="{{$translate['description']['translation'] ?? null}}"
                                       class="form-control">
                            </div>
                        @endforeach
                        @foreach($languages as $language)
                                <input type="text" hidden name="language_id[]" value="{{$language->languages->id}}">
                                <div class="col-md-4 form-group">
                                <label> {{$language->languages->name}} Title</label>
                                <input type="text" name="title[]" value="" class="form-control" placeholder="add title">
                            </div>

                            <div class="col-md-8 form-group">
                                <label>{{$language->languages->name}} Description</label>
                                <input type="text" name="description[]" value="" class="form-control" placeholder="add description">
                            </div>
                        @endforeach

                    </div>
                    @can('offers-edit')
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
