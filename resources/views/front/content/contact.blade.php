@extends('layouts.app')

@section('page', 'FAQ')

@section('content')
<style type="text/css">
 .about_banner figure {
        margin: 0;
        position: relative;
    }
    .about_banner_caption {
        width: 100%;
        max-width: 600px;
        position: absolute;
        top: 50%;
        left: 60%;
        transform: translateY(-50%);
        z-index: 9;
        padding: 0 15px;
    }
    .about_banner figure img {
        width: 100%;
        height: 100%;
        aspect-ratio: 3/1;
        object-fit: cover;
    }
    .about_banner figure {
        position: relative;
        overflow: hidden;
    }
    .about_banner_caption p{
        font-size:30px !important;
        margin-bottom: 16px;
    }
    .map_area {
        width: 100%;
        height: 300px;
        position: relative;
        margin-bottom: 20px;
    }
    .map_area iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .profile-card textarea.form-control {
        border: 1px solid #EAEAEC !important;
        border-radius: 0 !important;
    }
    textarea {
        min-height: 120px;
        resize: none;
    }
    .error{
        color:red;
    }
    .account-card h1,h2,h3,h4,h5,h6,p{
        font-size: 10px !important;
        line-height: 14px !important;
        font-weight: 700 !important;
    }
    .account-card a{
        color: #4936e7 !important;
    }
    @media (max-width:575px){
        .about_banner figure img {
            aspect-ratio: 3/2;
            object-position: left center;
        }
        .about_banner_caption {
            width: 100%;
            padding: 20px;
            left: 0;
            right: 0;
            top: 0;
            transform: none;
            text-align: center;
            position: relative;
        }
        .about_banner_caption p {
            font-size: 30px;
            margin-bottom: 16px;
        }
       
    }
</style>

<section class="about_banner p-0">
    <div class="container-fluid p-0">
        <figure>
            <div class="about_banner_caption">
                <p>Contact Us</p>
            </div>
            <!-- <div class="stroke_text">KGA Electronics</div> -->
            {{-- <!-- <img src="{{asset('/img/332077637_141046705527514_4967098247875274444_n.jpg')}}"> --> --}}
            <img src="{{asset($settings[22]->contact_image)}}">
        </figure>
    </div>
</section>

<section class="cart-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <ul class="account-list mt-0">
                    <li>
                        <span><strong>Quick Links</strong></span>
                        <ul>
                            <!-- <li><a href="{{route('front.content.about')}}">About</a></li> -->
                            <li><a href="{{route('front.content.corporate')}}">Corporate</a></li>
                            <li><a href="{{route('front.content.news')}}">News</a></li>
                            <li><a href="{{route('front.content.blog')}}">Blogs</a></li>
                            <li><a href="{{route('front.content.global')}}">Global</a></li>
                            <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{route('front.content.contact')}}">Contact</a></li>
                            <!-- <li><a href="{{route('front.content.career')}}">Career</a></li> -->
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9">
                <div class="map_area">
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.986685743695!2d88.43082871487756!3d22.57960128840419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275a56e5af545%3A0xc3d00bd19501575b!2sONN%20Innerwear!5e0!3m2!1sen!2sin!4v1654109109960!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    {!!$settings[22]->google_map_link!!}
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-navigation"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Contact Information</h4>
                                <h6>{!!$settings[22]->contact_info!!}</h6>
                            </figcaption>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div href="{{route('front.content.news')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Address</h4>
								<h6>{!! $settings[22]->address !!}</h6>
                            </figcaption>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <div href="{{route('front.content.news')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Inquiries & Feedback</h4>
                                <h6>{!!$settings[22]->inqueries_and_feedback!!}</h6>
                            </figcaption>
                        </div>
                    </div>
                </div>

                <div class="profile-card">
                    <h3>Feel free to contact us</h3>
                    <form action="{{route('front.content.contact.add')}}" method="POST" id="contactForm" >@csrf
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name" name="name" value="">
                                <label class="floating-label">Your Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Email" name="email" value="">
                                <label class="floating-label">Your Email</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" value="">
                                <label class="floating-label">Subject</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Your Message" name="message"></textarea>
                                <label class="floating-label">Your Message</label>
                            </div>
                        </div>
                    </div>


                    <div class="profile-card-footer">
                        <button type="submit" class="btn checkout-btn">Send</button>
                    </div>
                </form>
                </div>



            </div>

        </div>
    </div>
</section>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
        $('#contactForm').submit(function (e) {
            e.preventDefault();
            

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response.result); // Show success message
            },
            // error: function (xhr) {
            //     $('#errors').html(''); // Clear any previous errors

            //     // Display validation errors
            //     $.each(xhr.responseJSON.errors, function (key, value) {
            //         $('#errors').append('<p>' + value + '</p>');
            //     });
            // }
        });
    });
});



    </script>
@endsection
