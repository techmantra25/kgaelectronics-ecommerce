<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>KGA | OTP-Verify</title>

    <link rel="icon" href="img/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('css/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel='stylesheet' href='{{ asset('node_modules/lightbox2/dist/css/lightbox.min.css?ver=5.8.2') }}'>
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('scss/css/preload.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <main>
		<section class="register-wrapper">
            <div class="register-right">
                <!-- <div class="register-logo">
                    <a href="{{route('front.home')}}"><img src="{{asset('img/KGA Logo.png')}}" style="width: 10px; height: auto;" alt="KGA Logo"></a>
                </div> -->
                

                    <div class="register-block">
                                <div class="left-part">
                                   <!-- <div class="register-logo">
                                        <a href="{{route('front.home')}}">
											<img src="{{asset('img/KGA Logo.png')}}">
											<img src="{{ asset('img/KGA_Logo.png') }}" style="width: 10px; height: auto;" alt="KGA Logo">
										</a>
                                    </div>-->
                                    <form method="POST" action="{{route('front.user.otp-verify')}}">@csrf
                                    
                                        <h3>OTP Verify</h3>
                                        <h4>Welcome to KGA</h4>

                                        <div class="register-card">
                                           <input type="hidden" class="register-box" name="email" value= "{{ session('email') }}">
                                            <div class="register-group">
                                                <input type="text" class="register-box" name="otp" placeholder="OTP">
                                                <label class="floating-label">OTP</label>
                                                @error('otp') <p class="small text-danger mb-0">{{$message}}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row align-items-center justify-content-center text-center">
                                            <div class="col-12">
                                                <button type="submit">Veify</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="right-part">
                                    <img src="{{asset('img/kga-bg.jpg')}}">
                                </div>
                            <!-- <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="right-part">
                                    <img src="{{asset('img/login-image.png')}}">
                                </div>
                            </div> -->


                    </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('node_modules/gsap/dist/gsap.min.js') }}"></script>
    <script src="{{ asset('node_modules/gsap/dist/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('node_modules/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('node_modules/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('node_modules/lightbox2/dist/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.0/TweenMax.min.js"></script>
    <script src="{{ asset('node_modules/scrollmagic/scrollmagic/minified/ScrollMagic.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/plugins/animation.gsap.min.js'></script>
    <script src="{{ asset('node_modules/scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				// timerProgressBar: true,
                showCloseButton: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});

			Toast.fire({
				icon: type,
				title: title
			});
        }

        // on session toast fires
        @if (Session::has('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::has('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif
    </script>
</body>

</html>