@extends('admin.layouts.app')

@section('content')
@section('page_title','Subscriptions')
<div id="content">
    <div class="container-fluid">
        <form class="form">
            <ul class="accordion">
                <li class="active">
                    <a href="#" class="opener text-yellow"> Greet & Read (Welcome Bonus)</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="GAM-gold_coins" class="form-control"
                                       value="{{ $subscriptionSettings['gam_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="GAM-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['gam_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="GAM-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['gam_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="GAM-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['gam_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">

                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">VIP - 1 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip1month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['vip_1m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip1month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_1m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip1month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_1m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip1month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['vip_1m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>

                </li>
                <li>
                    <a href="#" class="opener text-yellow"> VIP - 3 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip3month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['vip_3m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip3month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_3m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip3month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_3m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip3month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['vip_3m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow"> VIP - 6 Month</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip6month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['vip_6m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip6month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_6m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip6month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_6m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip6month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['vip_6m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow"> VIP - 12 Month</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip12month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['vip_12m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip12month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_12m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip12month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['vip_12m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.vip12month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['vip_12m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>

                <li>
                    <a href="#" class="opener text-yellow">Big Spender - 1 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender1month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['big_1m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender1month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_1m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender1month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_1m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender1month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['big_1m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">Big Spender - 3 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender3month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['big_3m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender3month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_3m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender3month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_3m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender3month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['big_3m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow">Big Spender - 6 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender6month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['big_6m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender6month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_6m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender6month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_6m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender6month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['big_6m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
                <li>
                    <a href="#" class="opener text-yellow"> Big Spender - 12 Month </a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gold Coins:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender12month-gold_coin" class="form-control"
                                       value="{{ $subscriptionSettings['big_12m_gold_coins'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Daily Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender12month-daily_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_12m_daily_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Super Likes:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender12month-super_like" class="form-control"
                                       value="{{ $subscriptionSettings['big_12m_super_like'] }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Favorites:</label>
                                <input type="number" min="0" onKeyPress="if(this.value.length==7) return false;"
                                       name="com.twoagainaps.bigspender12month-favorite" class="form-control"
                                       value="{{ $subscriptionSettings['big_12m_favorite'] }}">
                            </div>
                        </div>
                        @can('subscription-edit')
                        <div class="text-right">
                            <input type="button" class="btn save" style="border-radius:25px" value="Save">
                        </div>
                        @endcan
                    </div>
                </li>
            </ul>
        </form>

    </div>
</div>


@endsection
