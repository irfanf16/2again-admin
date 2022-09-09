<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        {{$lang->languages->name}} Translation
    </div>

    <form id="form" action="" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">

                <div class="form-group">
                    <label>Json Data</label>
                    <textarea id="data" name="translation" cols="50" rows="20">{{$lang->translation}}</textarea>
                </div>
                <code id="results"></code>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input id="submit" type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>


{{--<script>--}}
{{--    form.addEventListener('submit', function (event) {--}}
{{--        event.preventDefault();--}}
{{--        try {--}}
{{--            JSON.parse(dataUpdate.value);--}}
{{--            results.innerHTML = 'Valid Json!';--}}
{{--            $.ajax({--}}
{{--                method: "POST",--}}
{{--                url: window.location.origin + '/admin/app/translated/languages/update'+ {{$lang->id}},--}}
{{--                data: {--}}
{{--                    translation: $('#dataUpdate').val(),--}}
{{--                    _token: $('meta[name="csrf_token"]').attr('content')--}}
{{--                }--}}
{{--            }).done(function (response) {--}}
{{--                if(response.code==1){--}}
{{--                    toastr.success(response.message);--}}
{{--                    $('#editLanguageModal').modal('hide')--}}
{{--                    var table = $('.yajra-datatable').DataTable();--}}
{{--                    table.ajax.reload();--}}
{{--                }--}}
{{--                if(response.code==0){--}}
{{--                    toastr.error(response.message);--}}
{{--                }--}}
{{--            })--}}
{{--        } catch (e) {--}}
{{--            results.innerHTML = e;--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
