@extends('admin.layouts.app')
@section('content')
@section('page_title','App Language Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <h3> {{$lang->languages->name}} App Translation</h3>
            <form id="form" action="{{route('admin.app.translated.languages.update',$lang->id)}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="lang" name="lang" value="{{$lang->id}}">
                    <div class="row">
                        <div class="form-group">
                            <label>Json Data</label>
                            <textarea id="data" name="translation" style="height: 300px;" >{{$lang->translation}}</textarea>
                        </div>
                        <code id="results" class="m-1 p-1"></code>
                    </div>
                @can('language-edit')
                <div class="text-right m-1 p-1">
                    <button id="submit" type="submit" class="btn btn-primary">Update</button>
                </div>
                @endcan
{{--                    <input id="submit" type="submit" class="btn btn-green" value="Update">--}}
            </form>
        </section>
    </div>
</div>

<script>
    $(document).ready(function (){
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            try {
                JSON.parse(data.value);
                results.innerHTML = 'Valid Json!';
                $.ajax({
                    method: "POST",
                    url: window.location.origin + '/admin/app/translated/languages/update',
                    data: {
                        lang: $('#lang').val(),
                        translation: $('#data').val(),
                        _token: $('meta[name="csrf_token"]').attr('content')
                    }
                }).done(function (response) {
                    if(response.code==1){
                        toastr.success(response.message);
                    }
                    if(response.code==0){
                        toastr.error(response.message);
                    }
                })
            } catch (e) {
                results.innerHTML = e;
            }
        });
    })
</script>

@endsection
