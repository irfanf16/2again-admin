@extends('admin.layouts.app')
@section('page_title','Offer Detail')
@section('content')


    <div id="content">
        <div class="container-fluid">
            @include('admin.inc.alerts')
            <section class="section">
                <div class="header-section content-box p-3">
                    <div class="space-between">
                        <div class="description">
                            <ul class="info-list">
                                <li><span class="title text-yellow">Offer Title: </span>{{ $offer->title }}</dd></li>
                                <li><span
                                        class="title text-yellow">Cost (Gold Coins): </span>{{ $offer->cost == 0 ? 'FREE' : $offer->cost}}</dd>
                                </li>
                                <li><span class="title text-yellow">Description: </span>{{ $offer->description}}</dd>
                                </li>
                                <li><span
                                        class="title text-yellow">Start Date & Time: </span>{{ $offer->start_date }}</dd>
                                </li>
                                <li><span
                                        class="title text-yellow">End Date & Time: </span>{{ $offer->valid_till }}</dd>
                                </li>
                            </ul>
                            @can('offers-edit')
                                <a href="#" class="btn medium btn-green" data-bs-toggle="modal"
                                   data-bs-target="#editOffer">
                                    <i class="fal fa-edit"></i>
                                    Edit
                                </a>
                            @endcan
                            @can('offers-delete')
                                <a href="#" data-bs-target="#deleteOffer" data-bs-toggle="modal"
                                   class="btn medium btn-red">
                                    <i class="fal fa-trash-alt"></i>
                                    Delete
                                </a>
                            @endcan
                        </div>
                        <div class="img-box mx-5">
                            <img style="width: 100px!important;" src="{{ $url }}{{ $offer->icon }}">
                        </div>
                    </div>
                </div>

            </section>
            <section class="section">
                <div class="text-yellow">Offer Items</div>
                <div class="content-box p-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                {{--                                        <th>Icon</th>--}}
                                <th>Name</th>
                                <th>Quantity</th>
                                @if(request()->user()->can('offers-edit') || request()->user()->can('offers-delete'))
                                    <th class="text-left">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($offer->consumables as $item)
                                <tr>
                                    {{--                                            <td>--}}
                                    {{--                                                <i class="fal ico-coin"></i>--}}
                                    {{--                                            </td>--}}
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    @if(request()->user()->can('offers-edit') || request()->user()->can('offers-delete'))
                                        <td class="action">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('offers-edit')
                                                        <li><a href="#" class="edit-offer-item"
                                                               data-offer_id="{{$offer->id}}"
                                                               data-consumable_id="{{ $item->id }}">Edit Quantity</a>
                                                        </li>
                                                    @endcan
                                                    @can('offers-delete')
                                                        <li><a href="#" class="deleteOfferItem"
                                                               data-item="{{ $item->id }}">Delete</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                No Offer Item Found
                            @endforelse

                            </tbody>
                        </table>
                        @can('offers-edit')
                            <input type="button" style="border-radius: 25px !important;" class="btn"
                                   data-bs-toggle="modal" data-bs-target="#addMoreOfferItem" value="Add More">
                        @endcan
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="addMoreOfferItem" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Add Item in Offer
                </div>
                <form action="{{ route('admin.offers.addItem') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Item</label>
                            <select class="form-control" name="consumable_id" required>
                                <option value="">Select Item</option>
                                @foreach ($consumables as $con)
                                    <option value="{{ $con->id }}">{{ $con->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Quantity</label>
                            <input type="number" min="0" name="quantity" class="form-control" placeholder="quantity"
                                   required>
                        </div>
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editOfferItemModal" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered" id="editOfferItem">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Edit Item in Offer
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editOffer" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Edit Offer
                </div>
                <form action="{{ route('admin.offers.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Offer Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $offer->title }}">
                        </div>
                        <div class="form-group">
                            <label>Offer Price</label>
                            <input type="number" name="cost" class="form-control" value="{{ $offer->cost }}">
                        </div>
                        <div class="form-group">
                            <label for="validity">Offer Start Date & Time</label>
                            <input type="datetime-local" class="form-control" name="start_date" id="validity"
                                   placeholder="Enter offer end date & time">
                        </div>
                        <div class="form-group">
                            <label for="validity">Offer End Date & Time</label>
                            <input type="datetime-local" class="form-control" name="valid_till" id="validity"
                                   placeholder="Enter offer end date & time">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Offer Description</label>
                            <textarea class="form-control" style="height: 100px;" name="description"
                                      id="exampleFormControlTextarea1" rows="5" required>{{ $offer->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Offer Icon</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <input type="hidden" name="id" value="{{ $offer->id }}">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteOfferItem" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to delete Item?
                </div>
                <form method="POST" action="{{ route('admin.offers.deleteItem') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> If you delete this Item, user will not be able to
                            get this item reward in offer</p>
                    </div>
                    <input type="hidden" name="item" id="offerItem">
                    <input type="hidden" name="offer" value="{{ $offer->id }}">
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteOffer" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to delete this offer?
                </div>
                <form method="POST" action="{{ route('admin.offers.delete') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> This offer will be permanently deleted from the
                            system.</p>
                    </div>
                    <input type="hidden" name="offer" value="{{ $offer->id }}">
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
