@extends('admin.layouts.app')
@section('page_title','403')
@section('content')
    <div id="content">
        <div class="container-fluid">

            <section class="section">

                        <div class="login" style="background-image: url('{{asset('admin/images/bg1.jpg')}}')">
                            <div class="container">
                                <div class="col">
                                    <div class="content-box">
                                        <img src="{{asset('admin/images/403.webp')}}">
                                        <h5 class="text-red"> You have not accessed to perform this action</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

            </section>
        </div>
    </div>



@endsection
