@extends('frontend.layouts.guest')

@section('content')
    <main id="main">
        <div class="login" style="background-image: url(images/bg1.jpg)">
            <div class="container">
                <div class="content-box w-100">
                    <div class="font-18 mb-5">Enter your personal information</div>
                    <form action="{{'updateProfile'}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="d-block">Full name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{auth()->user()->name ?? old('name')}}"
                                       maxlength="50" placeholder="First name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block">Date Of Birth</label>
                                <input type="date" name="dob" value="{{auth()->user()->dob ?? old('dob')}}"
                                       class="form-control"
                                       placeholder="03/31/2021">
                                {{--                                <small class="text-red">Must be 18 and over to use 2again</small><br>--}}
                                @if ($errors->has('dob'))
                                    <span class="text-danger">Must be 18 and over to use 2again</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block">Enter your university</label>
                                <input type="text" maxlength="50" class="form-control"
                                       value="{{auth()->user()->university ?? old('university')}}" name="university"
                                       placeholder="Nulla.">
                                @if ($errors->has('university'))
                                    <span class="text-danger">{{ $errors->first('university') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block">Country</label>
                                <select name="country_id" class="form-select" required>
                                    <option selected disabled>--Select Your Country--</option>
                                    @foreach($countries as $country)
                                        @if($country->id==auth()->user()->country_id)
                                            <option selected value="{{$country->id}}">{{$country->name}}</option>
                                        @else

                                                <option value="{{$country->id}}"  @if(old('country_id')==$country->id) selected @endif>{{$country->name}}</option>

                                        @endif

                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="text-danger">Please Select Your Country</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block">Religion</label>
                                <select name="religion_id" class="form-select" required>
                                    <option>--Select Your Religon--</option>
                                    @foreach($religions as $religion)
                                        @if($religion->id==auth()->user()->religion_id)
                                            <option selected value="{{$religion->id}}">{{$religion->name}}</option>
                                        @else
                                            <option value="{{$religion->id}}" @if(old('religion_id')==$religion->id) selected @endif>{{$religion->name}}</option>
                                        @endif
                                    @endforeach

                                </select>
                                @if ($errors->has('religion_id'))
                                    <span class="text-danger">Please Select Your Religion</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block">Choose your language</label>
                                <select name="language_id" class="form-select" required>
                                    <option>--Select Your Language--</option>

                                    @foreach($languages as $language)
                                        @if($language->id==auth()->user()->language_id)
                                            <option selected value="{{$language->id}}">{{$language->name}}</option>
                                        @else
                                            <option value="{{$language->id}}" @if(old('language_id')==$language->id) selected @endif>{{$language->name}}</option>
                                        @endif

                                    @endforeach
                                </select>
                                @if ($errors->has('language_id'))
                                    <span class="text-danger">Please Select Your language</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block">Passion</label>
                                <input type="text" maxlength="50" name="passion" class="form-control"
                                       value="{{auth()->user()->passion ?? old('passion')}}"
                                       placeholder="Designer">
                                @if ($errors->has('passion'))
                                    <span class="text-danger">{{ $errors->first('passion') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block">Select one: Are you?</label>
                                @if ($errors->has('gender_id'))
                                    <span class="text-danger">Please Select Your Gender</span>
                                @endif
                                @if(auth()->user()->gender_id==null)
                                    <div class="gender-list">
                                        <div class="gender-box">
                                            <input type="radio" @if(old('gender_id')==2) checked @endif class="form-check-input" value="2" id="male"
                                                   name="gender_id">
                                            <label for="male" class="form-check-label">
                                                <i class="fal ico-male text-blue"></i>
                                                Male
                                            </label>
                                        </div>
                                        <div class="gender-box">
                                            <input type="radio" @if(old('gender_id')==3) checked @endif  class="form-check-input" value="3" id="female"
                                                   name="gender_id">
                                            <label for="female" class="form-check-label">
                                                <i class="fal ico-female text-red"></i>
                                                Female
                                            </label>
                                        </div>
                                        <div class="gender-box">
                                            <input type="radio" @if(old('gender_id')==4) checked @endif class="form-check-input" value="4" id="Other"
                                                   name="gender_id">
                                            <label for="Other" class="form-check-label">
                                                <i class="fal ico-gender-other text-yellow-dark"></i>
                                                Other
                                            </label>
                                        </div>

                                    </div>

                                @else
                                    <div class="gender-list">
                                        @if(auth()->user()->gender_id==2)
                                            <div class="gender-box">
                                                <input type="radio" checked class="form-check-input" value="2" id="male"
                                                       name="gender_id">
                                                <label for="male" class="form-check-label">
                                                    <i class="fal ico-male text-blue"></i>
                                                    Male
                                                </label>
                                            </div>
                                        @elseif(auth()->user()->gender_id==3)

                                            <div class="gender-box">
                                                <input type="radio" checked class="form-check-input" value="3" id="female"
                                                       name="gender_id">
                                                <label for="female" class="form-check-label">
                                                    <i class="fal ico-female text-red"></i>
                                                    Female
                                                </label>
                                            </div>
                                        @else

                                            <div class="gender-box">
                                                <input type="radio" checked class="form-check-input" value="4" id="Other"
                                                       name="gender_id">
                                                <label for="Other" class="form-check-label">
                                                    <i class="fal ico-gender-other text-yellow-dark"></i>
                                                    Other
                                                </label>
                                            </div>
                                        @endif

                                    </div>

                                @endif

                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block">Your are interested in: <small>Please select
                                        anyone</small></label>
                                @if ($errors->has('interested_in'))
                                    <span class="text-danger">Please Select Your Interest</span>
                                @endif
                                <div class="gender-list">
                                    <div class="gender-box">
                                        <input type="radio" @if(old('interested_in')==2 || auth()->user()->interested_in==2) checked @endif class="form-check-input" value="2" id="Man"
                                               name="interested_in">
                                        <label for="Man" class="form-check-label">
                                            <i class="fal ico-man text-blue"></i>
                                            Man
                                        </label>
                                    </div>
                                    <div class="gender-box">
                                        <input type="radio"  @if(old('interested_in')==3 || auth()->user()->interested_in==3) checked @endif class="form-check-input" value="3" id="Woman"
                                               name="interested_in">
                                        <label for="Woman" class="form-check-label">
                                            <i class="fal ico-woman text-red"></i>
                                            Woman
                                        </label>
                                    </div>
                                    <div class="gender-box">
                                        <input type="radio"  @if(old('interested_in')==1 || auth()->user()->interested_in==1) checked @endif class="form-check-input" value="1" id="Everyone"
                                               name="interested_in">
                                        <label for="Everyone" class="form-check-label">
                                            <i class="fal ico-couple text-yellow-dark"></i>
                                            Everyone
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block">I am searching for:</label>
                                @if ($errors->has('filter_purpose'))
                                    <span class="text-danger">Please Select Dating or Marriage</span>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <input type="radio" name="filter_purpose" value="Dating"
                                                   @if(auth()->user()->filter_purpose=='Dating') checked
                                                   @endif   class="form-check-input" id="Dating">
                                            <label class="form-check-label" for="Dating">Dating</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <input type="radio" name="filter_purpose" value="Marriage"
                                                   @if(auth()->user()->filter_purpose=='Marriage') checked
                                                   @endif   class="form-check-input" id="Marriage">
                                            <label class="form-check-label" for="Marriage">Marriage</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <a class="btn w-100 btn-blue" data-bs-target="#Verifyaccountpic" data-bs-toggle="modal">Upload
                                    Image </a>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6 form-group">
                                    <div class="checkbox">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">
                                            Creating an account means you’re okay with
                                            our <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <button href="#" class="btn w-100" type="submit">Profile Update</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        @if(Session::has('message'))

        toastr.success("{{ session('message') }}");
        @endif
        @if(Session::has('success'))

        toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif



        var formData = new FormData();

        $(document).ready(function (e) {

            $('input').on('keypress', function (event) {
                var regex = new RegExp("^[a-z A-Z0-9]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });

            $('#camera_open').click(function () {
                Webcam.set({
                    width: 400,
                    height: 400,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
            });

            $('#image').change(function () {
                var fileData = $('#image').prop('files')[0];
                console.log(fileData)
                formData.append('file', fileData);
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#add-image').click(function () {
                addImage();
            });

            $('#capture-image-add').click(function () {

                var image = document.getElementById('camera-image').src;
                var file = dataURLtoFile(image, 'profile_pic.jpg');
                console.log(file);
                formData.append('file', file);

                addImage();
                Webcam.reset();
            });

        });

        function dataURLtoFile(dataurl, filename) {

            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {type: mime});
        }

        function configure() {
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        }

        function take_snapshot() {

            // take snapshot and get image data
            Webcam.snap(function (data_uri) {
                // display results in page
                document.getElementById('take_pic').innerHTML =
                    '<img width="400" id="camera-image" height="400" src="' + data_uri + '"/>';

            });
        }

        function addImage() {
            $.ajax({
                url: `{{route('uploadProfilePic')}}`,
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    formData = '';
                    document.getElementById('preview-image-before-upload').src = '{{env('MEDIA_URL')}}{{env('USER_NOT_FOUND')}}';
                    document.getElementById('image').value = '';
                    $('#addphoto').modal('hide');
                    toastr.success("Profile Picture has been uploaded successfully");
                }

            });
        }
    </script>
@endsection
