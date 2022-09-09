@extends('admin.layouts.app')

@section('content')
@section('page_title','Coins Setting')

        <div id="content">
            <div class="container-fluid">
                <ul class="accordion">
                    <li>
                        <a href="#" class="opener text-yellow">
                            Direct Message
                        </a>
                        <div class="slide">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Deduct Gold Coins:</label>
                                    <input type="text" name="DM" class="form-control" value="{{ $coinSettings['DM']->deduct_gold_coins }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Earn Silver Coins:</label>
                                    <input type="text" name="DM" class="form-control" value="{{ $coinSettings['DM']->earn_silver_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
                        </div>
                    </li>
                    <li>
                        <a href="#" class="opener text-yellow">
                            Calling
                        </a>
                        <div class="slide">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Deduct Gold Coins:</label>
                                    <input type="text" name="Call" class="form-control" value="{{ $coinSettings['Call']->deduct_gold_coins }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Earn Silver Coins:</label>
                                    <input type="text" name="Call" class="form-control" value="{{ $coinSettings['Call']->earn_silver_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
                        </div>
                    </li>
                    <li>
                        <a href="#" class="opener text-yellow">
                            Super Like
                        </a>
                        <div class="slide">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Deduct Gold Coins:</label>
                                    <input type="text" name="SuperLike" class="form-control" value="{{ $coinSettings['SuperLike']->deduct_gold_coins }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Earn Silver Coins:</label>
                                    <input type="text" name="SuperLike" class="form-control" value="{{ $coinSettings['SuperLike']->earn_silver_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
                        </div>
                    </li>
                    <li>
                        <a href="#" class="opener text-yellow">
                            Visit Photo Gallery
                        </a>
                        <div class="slide">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Deduct Gold Coins:</label>
                                    <input type="text" name="Photo" class="form-control" value="{{ $coinSettings['Photo']->deduct_gold_coins }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Earn Silver Coins:</label>
                                    <input type="text" name="Photo" class="form-control" value="{{ $coinSettings['Photo']->earn_silver_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
                        </div>
                    </li>
                    <li>
                        <a href="#" class="opener text-yellow">
                            Visit Video Gallery
                        </a>
                        <div class="slide">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Deduct Gold Coins:</label>
                                    <input type="text" name="Video" class="form-control" value="{{ $coinSettings['Video']->deduct_gold_coins }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Earn Silver Coins:</label>
                                    <input type="text" name="Video" class="form-control" value="{{ $coinSettings['Video']->earn_silver_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
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
                                    <input type="text" name="Emoji" class="form-control" value="{{ $coinSettings['Emoji']->deduct_gold_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
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
                                    <input type="text" name="AF" class="form-control" value="{{ $coinSettings['AF']->deduct_gold_coins }}">
                                </div>
                            </div>
                            <input type="button" class="btn save-coin-settings" value="save">
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>



@endsection
