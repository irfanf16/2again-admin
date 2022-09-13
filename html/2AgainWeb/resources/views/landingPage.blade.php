@extends('web.layouts.landingpage')
@section('content')

    <div class="bannermain">
        <div class="container">
            <div class="col">
                <div class="text-box">
                    <h1>Find your perfect match</h1>
                    <p>2Again is a new and exciting dating app that launches march 2022 <br> worldwide simultaneously
                        and in many languages</p>
                    <h3 class="text-yellow">Pre-launching Registration</h3>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#notify_popup" class="btn">Register
                        Now</a>
                </div>
            </div>
            <div class="col">
                <div class="img-box">
                    <img src="frontend/images/bannerimg.png">
                </div>
            </div>
        </div>
    </div>

    <main id="mainweb" class="index-main">
        <section class="sectionmain p-0">
            <div class="container">
                <div class="flex-align-center my-5 flex-column">
                    <h3 class="m-2">Launching Soon!</h3>
                    <div class="m-2 flex-align-center">
                        <a href="#" class="d-inline m-1 ms-0 img-box store">
                            <img src="frontend/images/apple-store.svg">
                        </a>
                        <a href="#" class="d-inline m-1 img-box store">
                            <img src="frontend/images/googleplay.svg">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain about">
            <div class="container">
                <div class="col col1">
                    <div class="logo">
                        <a href="#">
                            <img src="frontend/images/logo.svg">
                        </a>
                    </div>
                </div>
                <div class="col">
                    <h2 class="border-bottom">About 2again</h2>
                    <p>2Again is a new and exciting dating app that launches march 2022 worldwide simultaneously and in
                        40+ languages.
                        <br> <br>
                        Then you probably ask yourself: “Well, are there not plenty of dating apps on the market
                        already? "And yes! There are”. However, this is different and stands out from the crowd.
                        Immediately when you see it and swipe through the profiles it looks like the others. But cool
                        features are hidden and are definitely worth a download.
                    </p>
                </div>
            </div>
        </section>
        <section class="sectionmain bg-purple">
            <div class="container">
                <div class="section-headermain text-center">
                    <h2 class="text-capitalize">Pre-launching Registraion</h2>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#notify_popup" class="btn btn-darkblue">Register Now</a>
                </div>
            </div>
        </section>
        <section class="sectionmain bg-blue-light">
            <div class="container">
                <div class="section-headermain text-center">
                    <h2>How it works</h2>
                    <div class="video-box">
                        <iframe width="560" height="560" src="https://www.youtube.com/embed/zSLj8FWDEOA"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Direct message to unknown</h2>
                    <p>Basically, you can write to each other when you have a match. But imagine that you have just seen
                        a profile that you just have to get in contact with. The only problem is just that the person
                        has not seen you yet. So therefore you can pay to send a direct message to the person, you do
                        not yet have a match with, but it gets even better.
                        <br> <br>
                        - So put a little emotion in the messages and not just a simple "Hello beautiful", because these
                        messages are often ignored and deleted.</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s1.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1 bg-blue-light">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Appear first to person you wish to</h2>
                    <p>You have the option to appear first to a person you wish to, and that person will see you on
                        feeds when comes online next time. You can also see inside interactions if that person saw you
                        already. You can also give a like or super like, you can send direct messages or a small gift,
                        if you can not forget the person. So there are many opportunities to get a match with just the
                        one and only at 2Again.</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s2.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Earn silver coin by accepting gift and invitation</h2>
                    <p>Silver coins can also be earned by accepting small nice gifts and invitations from other users,
                        and when they choose to receive them, you automatically become a match.</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s3.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1 bg-blue-light">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Earn silver coin by replying to unknown</h2>
                    <p>Because in 2Again, the advantage is, that you can send a paid message to another profile. If the
                        recipient of your message thinks "Cool!" and answers you back, must you as the sender, Rate the
                        message you get back, with either thumbs up or down - depending on what you thought of the
                        answer. If you rate with thumbs up, the sender of the answer now gets a reward in the form of
                        silver coins, and this to promote the good and positive dialogue and more matches in between our
                        users, so the better content you write, the better answers you get back!</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s4.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Live calls</h2>
                    <p>You can also have live calls or video calls with other users, thereby making sure, that the
                        person at the other end is who he or she pretends to be. And besides this, there are a lot of
                        other fun things in the app.</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s5.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1 bg-blue-light">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Earn silver coin by private photo and video gallery</h2>
                    <p>You can also earn silver coins by putting some great photos and videos into your private photo
                        and video folders. For these items, other users pay to view and then rate them. So the better
                        stuff you post, the better rating and thereby more visits and who knows…? Maybe more matches in
                        the end.</p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s6.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain section1">
            <div class="container">
                <div class="col">
                    <h2 class="border-bottom">Withdraw silver coin to real money</h2>
                    <p>Silver coins can, once you have earned enough, be converted to real money and deposited into your
                        bank account.
                        <br><br>
                        There is, of course, a limit to what you can earn from silver coins per month per user, so
                        people can not take advantage of each other!
                        <br><br>
                        And why do we do that…? It's very simple… small rewards or gifts are super icebreakers to get
                        the dialogue started, leading to more matches between our users. And the most important thing
                        for us is, that everyone gets a positive experience on 2Again. And who knows? Maybe find the one
                        and only. </p>
                </div>
                <div class="col">
                    <div class="img-box">
                        <a href="#">
                            <img src="frontend/images/s7.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="sectionmain bg-blue-light contact">
            <div class="container">
                <div class="section-headermain text-center">
                    <p class="mb-2 text-gray"> Let’s keep in touch</p>
                    <h2 class="text-capitalize">How Can We Help You?</h2>
                </div>
                <form class="form row contact-form" id="keep-in-touch-form" method="POST"
                      action="{{route('keep.in.touch')}}">
                    @csrf
                    <code id="results"></code>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="firstname" id="firstname"
                               placeholder="First name">
                        <code id="fn"></code>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name">
                        <code id="ln"></code>

                    </div>
                    <div class="form-group col-md-12">
                        <input type="email" class="form-control" maxlength="100" name="email" id="email"
                               placeholder="Email" required>
                        <code id="em"></code>

                    </div>
                    <div class="form-group col-md-12">
                        <textarea placeholder="Message" name="message" id="message" spellcheck="false"></textarea>
                        <code id="msg"></code>

                    </div>
                    <div class="col-md-12 custom-flex-space">
                        <div class="form-group m-0">
                            <div class="form-check checkboxmain">
                                <input class="form-check-input" type="checkbox" value="" id="send">
                                <label class="form-check-label" for="send">
                                    Send me a copy
                                </label>
                            </div>
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" id="keep-in-touch" class="btn">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>



@endsection
