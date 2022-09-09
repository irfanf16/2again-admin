@extends('admin.layouts.app')

@section('content')
@section('page_title','Shop')


<div id="content">
    <div class="container-fluid">
        <ul class="accordion">
            <li>
                <div class="text-center text-yellow">
                    <label>Buy with Currency</label>
                </div>
            </li>
            <li class="">
                <a href="#" class="opener text-yellow">
                    Gold Coins
                </a>
                <div class="slide">
                    <div class="row">
                        @foreach ($shop['gold'] as $gold)
                            <div class="row">
                                <div class="form-group col-md-6">

                                    <label>Package {{preg_replace('/package/', ' ',preg_replace('/com.twoagainaps.goldcoin/', ' ', $gold->package_id))}}
                                        -
                                        Quantity:</label>
                                    <input type="number" name="quantity" min="0"
                                           onKeyPress="if(this.value.length==7) return false;"
                                           class="form-control valid-number" data-item="{{ $gold->id }}"
                                           value="{{ $gold->quantity }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Price For Web App ($):</label>
                                    <input type="text" name="price" onKeyPress="if(this.value.length==7) return false;"
                                           step="99.99" class="form-control " value="{{ $gold->price }}">
                                </div>
                                {{--                                <div class="form-group col-md-2 mt-4">--}}
                                {{--                                    <button class="btn shopRemove" data-shop="{{$gold->id}}"><i--}}
                                {{--                                            class="fas fa-trash "></i></button>--}}
                                {{--                                </div>--}}
                            </div>
                        @endforeach
                    </div>
                    @can('shop-setting-edit')
                        <div class="row mt-5">
                            <div class="form-group col-md-6 text-left ">
                                <button class="m-1" data-bs-toggle="modal" data-bs-target="#goldCoinsPackageAdd">Add New
                                </button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @endcan
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    VIP
                </a>
                <div class="slide">
                    <div class="row">
                        @foreach ($shop['vip'] as $vip)
                            <div class="form-group col-md-6">
                                <label>Quantity:</label>
                                <input type="text" name="quantity" onKeyPress="if(this.value.length==7) return false;"
                                       data-item="{{ $vip->id }}" class="form-control"
                                       value="{{ $vip->quantity }} month" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Price For Web App ($):</label>
                                <input type="text" name="price" onKeyPress="if(this.value.length==7) return false;"
                                       class="form-control" value="{{ $vip->price }}">
                            </div>
                        @endforeach
                    </div>
                    @can('shop-setting-edit')

                        <div class="row mt-5">
                            <div class="form-group col-md-12 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>
                        </div>
                    @endcan
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Big Spender
                </a>
                <div class="slide">
                    <div class="row">
                        @foreach ($shop['bs'] as $bs)
                            <div class="form-group col-md-6">
                                <label>Quantity:</label>
                                <input type="text" name="quantity" onKeyPress="if(this.value.length==7) return false;"
                                       class="form-control" data-item="{{ $bs->id }}"
                                       value="{{ $bs->quantity }} month" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Price For Web App ($):</label>
                                <input type="text" name="price" onKeyPress="if(this.value.length==7) return false;"
                                       class="form-control" value="{{ $bs->price }}">
                            </div>
                        @endforeach
                    </div>
                    @can('shop-setting-edit')

                        <div class="row mt-5">
                            <div class="form-group col-md-12 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>
                        </div>
                    @endcan
                </div>
            </li>
            <li>
                <div class="text-center text-yellow">
                    <label>Buy with Gold Coins</label>
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Likes
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))
                        <div class="row">
                            @foreach ($shop['like'] as $like)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $like->id }}" class="form-control"
                                               value="{{ $like->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $like->price }}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$like->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Like">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['like'] as $like)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $like->id }}" class="form-control"
                                               value="{{ $like->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $like->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Super Likes
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))
                        <div class="row">
                            @foreach ($shop['superlike'] as $superlike)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $superlike->id }}" class="form-control"
                                               value="{{ $superlike->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $superlike->price }}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$superlike->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="SuperLike">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['superlike'] as $superlike)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $superlike->id }}" class="form-control"
                                               value="{{ $superlike->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $superlike->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Favorites
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))
                        <div class="row">
                            @foreach ($shop['favorite'] as $favorite)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $favorite->id }}" class="form-control"
                                               value="{{ $favorite->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $favorite->price }}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$favorite->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Favorite">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['favorite'] as $favorite)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $favorite->id }}" class="form-control"
                                               value="{{ $favorite->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $favorite->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Private Photo Slots
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))

                        <div class="row">
                            @foreach ($shop['photo'] as $photo)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $photo->id }}" class="form-control"
                                               value="{{ $photo->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $photo->price }}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$photo->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>


                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Photo">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['photo'] as $photo)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $photo->id }}" class="form-control"
                                               value="{{ $photo->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $photo->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Private Video Slots
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))
                        <div class="row">
                            @foreach ($shop['video'] as $video)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $video->id }}" class="form-control"
                                               value="{{ $video->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $video->price }}">
                                    </div>


                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$video->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                                </div>
                            @endforeach
                        </div>


                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Video">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['video'] as $video)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Quantity:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $video->id }}" class="form-control"
                                               value="{{ $video->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $video->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>

            <li>
                <a href="#" class="opener text-yellow">
                    Call Minutes
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))
                        <div class="row">
                            @foreach ($shop['call'] as $call)
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Minutes:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="quantity" data-item="{{ $call->id }}" class="form-control"
                                               value="{{ $call->quantity }}">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="price" class="form-control" value="{{ $call->price }}">
                                    </div>
                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$call->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Call">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['call'] as $call)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Minutes:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="quantity" data-item="{{ $call->id }}" class="form-control"
                                               value="{{ $call->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="price" class="form-control" value="{{ $call->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
            <li>
                <a href="#" class="opener text-yellow">
                    Boost
                </a>
                <div class="slide">
                    @if(request()->user()->can('shop-setting-edit'))

                    <div class="row">
                        @foreach ($shop['boost'] as $boost)
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label>Minutes:</label>
                                    <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                           name="Call" data-item="{{ $boost->id }}" class="form-control"
                                           value="{{ $boost->quantity }}">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Price (Gold Coins)</label>
                                    <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                           name="Call" class="form-control" value="{{ $boost->price }}">
                                </div>
                                    <div class="form-group col-md-2 mt-4">
                                        <button class="btn shopRemove" data-shop="{{$boost->id}}"><i
                                                class="fas fa-trash "></i></button>
                                    </div>

                            </div>
                        @endforeach
                    </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-5 text-left ">
                                <button class="m-1 shop-add" data-shop="Boost">Add New</button>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <input type="button" class="btn save-shop-settings m-1" style="border-radius:25px"
                                       value="Save">
                            </div>

                        </div>
                    @else
                        <div class="row">
                            @foreach ($shop['boost'] as $boost)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Minutes:</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" data-item="{{ $boost->id }}" class="form-control"
                                               value="{{ $boost->quantity }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price (Gold Coins)</label>
                                        <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                               name="Call" class="form-control" value="{{ $boost->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="modal fade" id="goldCoinsPackageAdd" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Gold Coins Package add
            </div>
            <div class="modal-body">
                <form method="POST" id="" action="{{route('admin.shop.add')}}">
                    @csrf
                    <input type="hidden" name="type" value="Gold">
                    <input type="hidden" name="is_active" value="1">
                    <div class="form-group">
                        <label>Package Id</label>
                        <input class="form-control" type="text" placeholder="Enter package id same as on stores"
                               name="package_id" required value="">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control" min="0" onKeyPress="if(this.value.length==7) return false;"
                               type="number" placeholder="Enter quantity" name="quantity" required
                               value="">
                    </div>
                    <div class="form-group">
                        <label>Price For Web App ($):</label>
                        <input class="form-control" min="0" onKeyPress="if(this.value.length==7) return false;"
                               type="text" placeholder="Enter price" name="price" required
                               value="">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="javascript:void(0)" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="shopAdd" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New
            </div>
            <div class="modal-body">
                <form method="POST" id="" action="{{route('admin.shop.add')}}">
                    @csrf
                    <input type="hidden" id="shop_type" name="type" value="">
                    <input type="hidden" name="is_active" value="1">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control" min="0" onKeyPress="if(this.value.length==7) return false;"
                               type="number" placeholder="Enter quantity" name="quantity" required
                               value="">
                    </div>
                    <div class="form-group">
                        <label>Price (Gold Coins)</label>
                        <input class="form-control" min="0" onKeyPress="if(this.value.length==7) return false;"
                               type="number" placeholder="Enter price" name="price" required
                               value="">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="javascript:void(0)" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('input[type=text]').on('keypress', function (event) {
        var regex = new RegExp("^[0-9.]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        console.log(key);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
        if (event.keyCode === 46 && this.value.split('.').length === 2) {
            return false;
        }
        if (this.value.toString().split(".")[1].length > 1) {
            return false;
        }

    });
</script>
@endsection

