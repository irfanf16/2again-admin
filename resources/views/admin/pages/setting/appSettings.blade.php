@extends('admin.layouts.app')

@section('content')
@section('page_title','App Settings')

<div id="content">
    <div class="container-fluid">
        <form class="form">
            <ul class="accordion">
                <li class="active">
                    <a href="#" class="opener text-yellow">Silver Coin</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Minimum Withdrawal Limit ($) - Per Request:</label>
                                <input type="text" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="MWL" class="form-control  real-money-validation"
                                       value="{{ $appSettings['withdraw_limits']->value1 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Maximum Withdrawal Limit ($) - Per Request:</label>
                                <input type="text" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="MWL" class="form-control  real-money-validation"
                                       value="{{ $appSettings['withdraw_limits']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Monthly Withdrawal Limit ($):</label>
                                <input type="text" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="MWLIMIT" class="form-control  real-money-validation"
                                       value="{{ $appSettings['MWLIMIT']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last 30 Days Max. Earning Limit (Silver Coins) - Per User:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="PUEL" class="form-control"
                                       value="{{ $appSettings['PUEL']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>1 Silver Coin = USD:</label>
                                <input type="text" name="STU" class="form-control silver1-coins-validation"
                                       value="{{ $appSettings['silver_to_usd']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Silver Coin Expiry Days(Greet And Read):</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="SCED" class="form-control"
                                       value="{{ $appSettings['silver_coins_expiry_days']->value2 }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">Earn Free</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Download Other Apps (Gold Coins Earning):</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="EGC-download_other_app" class="form-control"
                                       value="{{ $appSettings['download_other_app']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Watch Video Ad (Gold Coins Earning):</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="EGC-watch_video_ad" class="form-control"
                                       value="{{ $appSettings['watch_video_ad']->value2 }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Business Affiliate Invite (Silver Coins Earning)</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="ESC-invite_friend" class="form-control"
                                       value="{{ $appSettings['invite_friend_silver']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Business Affiliate Invite (Gold Coins Earning)</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="EGC-invite_friend_business_affiliate" class="form-control"
                                       value="{{ $appSettings['invite_friend_business_affiliate']->value2 }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Invite Friend (Gold Coins Earning)</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="EGC-invite_friend" class="form-control"
                                       value="{{ $appSettings['invite_friend_gold']->value2 }}">
                            </div>
                        </div>
                        @can('app-setting-edit')

                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Direct Message
                    </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Deduct Gold Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="DM" class="form-control"
                                       value="{{ $coinSettings['DM']->deduct_gold_coins }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Earn Silver Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="DM" class="form-control"
                                       value="{{ $coinSettings['DM']->earn_silver_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Calling
                    </a>
                    <div class="slide">
                        <div class="row">
                            {{--                            <div class="form-group col-md-6">--}}
                            {{--                                <label>Deduct Gold Coins:</label>--}}
                            {{--                                <input type="number" onKeyPress="if(this.value.length==7) return false;" name="Call" class="form-control"--}}
                            {{--                                       value="{{ $coinSettings['Call']->deduct_gold_coins }}">--}}
                            {{--                            </div>--}}
                            <input type="hidden" name="Call" class="form-control"
                                   value="{{ $coinSettings['Call']->deduct_gold_coins }}">
                            <div class="form-group col-md-6">
                                <label>Earn Silver Coins - Per Minute:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Call" class="form-control"
                                       value="{{ $coinSettings['Call']->earn_silver_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Super Like
                    </a>
                    <div class="slide">
                        <div class="row">
                            {{--                            <div class="form-group col-md-6">--}}
                            {{--                                <label>Deduct Gold Coins:</label>--}}
                            {{--                                <input type="number" onKeyPress="if(this.value.length==7) return false;" name="SuperLike" class="form-control"--}}
                            {{--                                       value="{{ $coinSettings['SuperLike']->deduct_gold_coins }}">--}}
                            {{--                            </div>--}}
                            <input type="hidden" name="SuperLike" class="form-control"
                                   value="{{ $coinSettings['SuperLike']->deduct_gold_coins }}">
                            <div class="form-group col-md-6">
                                <label>Earn Silver Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="SuperLike" class="form-control"
                                       value="{{ $coinSettings['SuperLike']->earn_silver_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">Public Photo</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Public Photo Limit:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="PPL-public_photo_limit" class="form-control"
                                       value="{{ $appSettings['public_photo_limit']->value2 }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Private Photo Gallery Visit
                    </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Deduct Gold Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Photo" class="form-control"
                                       value="{{ $coinSettings['Photo']->deduct_gold_coins }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Earn Silver Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Photo" class="form-control"
                                       value="{{ $coinSettings['Photo']->earn_silver_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Private Video Gallery Visit
                    </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Deduct Gold Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Video" class="form-control"
                                       value="{{ $coinSettings['Video']->deduct_gold_coins }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Earn Silver Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Video" class="form-control"
                                       value="{{ $coinSettings['Video']->earn_silver_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Set Daily Mood
                    </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Deduct Gold Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="Emoji" class="form-control"
                                       value="{{ $coinSettings['Emoji']->deduct_gold_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">
                        Appear First
                    </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Deduct Gold Coins:</label>
                                <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0"
                                       name="AF" class="form-control"
                                       value="{{ $coinSettings['AF']->deduct_gold_coins }}">
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn save-coin-settings" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>

                <li>
                    <a href="#" class="opener text-yellow">Search Distance</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Allow User To Set Search Distance:</label>
                                {{--                                <input type="number" onKeyPress="if(this.value.length==7) return false;" name="SD-search_distance" class="form-control"--}}
                                {{--                                       value="{{ $appSettings['search_distance']->value2 }}">--}}

                                <select class="form-control" name="SD-search_distance" id="">
                                    @if($appSettings['search_distance']->value2==0)
                                        <option selected value="0">No</option>
                                        <option value="1">Yes</option>

                                    @else
                                        <option selected value="1">Yes</option>
                                        <option value="0">No</option>

                                    @endif
                                </select>
                            </div>
                        </div>
                        @can('app-setting-edit')
                        <div class="text-right">
                            <input type="button" class="btn search_distance" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
            </ul>
        </form>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('.real-money-validation').on('keypress', function (event) {
            var regex = new RegExp("^[0-9.]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
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
        $('.silver1-coins-validation').on('keypress', function (event) {
            var regex = new RegExp("^[0-9.]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
            if (event.keyCode === 46 && this.value.split('.').length === 2) {
                return false;
            }
            if (this.value.toString().split(".")[1].length > 3) {
                return false;
            }
        });
    })

</script>
@endsection
