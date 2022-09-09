@extends('admin.layouts.app')
@section('page_title','Create Offer')
@section('content')


        <div id="content">
            <div class="container-fluid">
                @include('admin.inc.alerts')
                <section class="section">
                    <form method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Offer Title</label>
                          <input type="text" class="form-control" name="title" id="exampleFormControlInput1" placeholder="Enter offer title" required>
                        </div>
                        <div class="form-group">
                          <label for="cost">Offer Cost (Gold Coins)</label>
                          <input type="number" class="form-control" name="cost" id="cost" placeholder="Enter offer cost" required>
                        </div>
                        <div class="form-group">
                          <label for="validity">Offer validity</label>
                          <input type="date" class="form-control" name="valid_till" id="validity" placeholder="Enter offer cost" required>
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">Offer Description</label>
                          <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Select Offer Icon</label>
                            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" required>
                        </div>
                        <input type="submit" class="btn" value="Save">
                      </form>
                </section>
            </div>
        </div>

@endsection
