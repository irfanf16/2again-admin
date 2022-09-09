@extends('admin.layouts.app')

@section('content')
@section('page_title','Safety Tips')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('safetyTip-add')
                <div class="mb-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addEmoji" class="btn ">Add New</a>
                </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tips as $key=> $tip)
                        <tr>
                            <td><img class="img-safety-tip" style="width: 100px!important;"
                                     src="{{ $icon_url }}{{ $tip->icon }}"></td>
                            <td>{{ $tip->title }}</td>
                            <td>{{ $tip->tip }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('admin.safety.translation',$tip->id)}}">Translations</a>
                                        </li>
                                        @can('safetyTip-edit')
                                            <li><a href="javascript:void(0)" class="Edit-tip" data-tip="{{ $tip->id }}">Edit</a>
                                            </li>
                                        @endcan
                                        @can('safetyTip-delete')
                                            <li><a href="javascript:void(0)" class="delete-tip"
                                                   data-tip="{{ $tip->id }}">Delete</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        No Tip Found
                    @endforelse

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>


<div class="modal fade" id="addEmoji" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New Tip
            </div>
            <form action="{{ route('admin.safety.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Enter Tip</label>
                        <input type="text" name="tip" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Select Icon (Only PNG)</label>
                        <input type="file" name="file" class="form-control" accept="image/png" required/>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="EditTip" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered" id="EditTipModal">

    </div>
</div>

<div class="modal fade" id="deleteTip" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this Tip?
            </div>
            <form method="POST" action="{{ route('admin.safety.destroy') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this Tip, users will be able to see this
                        tip in tips section</p>
                </div>
                <input type="hidden" name="tip" id="tip" value="">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
