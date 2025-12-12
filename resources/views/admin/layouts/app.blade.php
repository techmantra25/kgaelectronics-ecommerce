<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/plugins/croppie/croppie.css') }}">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>KGA | Admin @yield('page')</title>

    <style>
        .admin-logo {
        display: block;
        padding: 7px 4px; 
        }
        .admin-logo img {
        max-width: 100%;
        width: 61px;
        }
    </style>
</head>

<body>
    <aside class="side__bar shadow-sm">
        <div class="admin__logo">
            <div class="logo">
                <a href="{{url('/')}}" target="_blank" class="admin-logo">
                    <!-- <svg width="322" height="322" viewBox="0 0 322 322" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="231.711" y="47.8629" width="60" height="260" rx="30" transform="rotate(45 231.711 47.8629)" fill="#c10909" />
                        <rect x="236.66" y="137.665" width="60" height="180" rx="30" transform="rotate(45 236.66 137.665)" fill="#c10909" />
                        <rect x="141.908" y="42.9132" width="60" height="180" rx="30" transform="rotate(45 141.908 42.9132)" fill="#c10909" />
                    </svg> -->
                    <img src="{{ asset('admin/images/KGA-Logo.png') }}">
                </a>
            </div>
            <div class="admin__info">
                <h1>{{ Auth()->guard('admin')->user()->name }}</h1>
                <h4>{{ Auth()->guard('admin')->user()->email }}</h4>
            </div>
        </div>
        <nav class="main__nav">
            <ul>
                <li class="{{ ( request()->is('admin/home*') ) ? 'active' : '' }}"><a href="{{ route('admin.home') }}"><i class="fi fi-br-home"></i> <span>Dashboard</span></a></li>

                <li class="@if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/collection*') || request()->is('admin/color*') || request()->is('admin/size*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>Master</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/category*') ) ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}"><i class="fi fi-br-database"></i> <span>Category</span></a></li>
					 <li class="{{ ( request()->is('admin/product/list*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.index') }}"><i class="fi fi-br-database"></i><span>All Product</span></a></li>
                      {{--  <li class="{{ ( request()->is('admin/subcategory*') ) ? 'active' : '' }}"><a href="{{ route('admin.subcategory.index') }}"><i class="fi fi-br-database"></i> <span>Sub-category</span></a></li>--}}

                       {{-- <li class="{{ ( request()->is('admin/collection*') ) ? 'active' : '' }}"><a href="{{ route('admin.collection.index') }}"><i class="fi fi-br-database"></i> <span>Collection</span></a></li>--}}

						<li class="{{ ( request()->is('admin/color*') ) ? 'active' : '' }}"><a href="{{ route('admin.color.index') }}"><i class="fi fi-br-database"></i> <span>Color</span></a></li>

						{{--<li class="{{ ( request()->is('admin/size*') ) ? 'active' : '' }}"><a href="{{ route('admin.size.index') }}"><i class="fi fi-br-database"></i> <span>Size</span></a></li>--}}
                    </ul>
                </li>

               {{-- <li class="@if(request()->is('admin/product*') || request()->is('admin/faq*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>Product Management</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/product/list*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.index') }}">All Product</a></li>

                        <li class="{{ ( request()->is('admin/product/create*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.create') }}">Add New</a></li>
                    </ul>
                </li>--}}

                <li class="@if(request()->is('admin/order*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>
                       Order Management </span></a>
                    <ul>
						<li class="{{ ( request()->is('admin/order') && request()->query('status') == null ) ? 'active' : '' }}">
							<a href="{{ route('admin.order.index') }}">
								<i class="fi fi-br-database"></i> <span>All Orders</span>
							</a>
						</li>
					

						<!--<li class="{{ ( request()->get('status') === '0' ) ? 'active' : '' }}">
							<a href="{{ route('admin.order.index', ['status'=>0]) }}">
								<i class="fi fi-br-database"></i> 
								<span>Pending Orders</span>
							</a>
						</li>-->
						<li class="{{ ( request()->is('admin/order?status=pending') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'6']) }}"><i class="fi fi-br-database"></i> <span>Pending Orders</span></a></li>
						
						<li class="{{ ( request()->is('admin/order?status=new') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'1']) }}"><i class="fi fi-br-database"></i> <span>New Orders</span></a></li>

                        <li class="{{ ( request()->is('admin/order?status=new') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'1']) }}"><i class="fi fi-br-database"></i> <span>New Orders</span></a></li>

                        <li class="{{ ( request()->is('admin/order?status=confirm') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'2']) }}"><i class="fi fi-br-database"></i> <span>Confirm Orders</span></a></li>

                        <li class="{{ ( request()->is('admin/order?status=ship') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'3']) }}"><i class="fi fi-br-database"></i> <span>Shipped Orders</span></a></li>

                        <li class="{{ ( request()->is('admin/order?status=deliver') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'4']) }}"><i class="fi fi-br-database"></i> <span>Delivered Orders</span></a></li>

                        <li class="{{ ( request()->is('admin/order?status=cancel') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index', ['status'=>'5']) }}"><i class="fi fi-br-database"></i> <span>Cancelled Orders</span></a></li>
                    </ul>
                </li>

                <li class="@if(request()->is('admin/franchise*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>Franchise</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/requisite*') ) ? 'active' : '' }}"><a href="{{ route('admin.franchise.requisite.index') }}"><i class="fi fi-br-database"></i> <span>Requisite</span></a></li>
                        <li class="{{ ( request()->is('admin/our_stores*') ) ? 'active' : '' }}"><a href="{{ route('admin.franchise.our_stores.index') }}"><i class="fi fi-br-database"></i> <span>Our Stores</span></a></li>
                        <li class="{{ ( request()->is('admin/marketing*') ) ? 'active' : '' }}"><a href="{{ route('admin.franchise.marketing.index') }}"><i class="fi fi-br-database"></i> <span>Marketing</span></a></li>
                    </ul>
                </li>

                {{--<li class="@if(request()->is('admin/customer*') || request()->is('admin/address*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>Customer Management</span></a>
                    <ul>--}}
                        <li class="{{ ( request()->is('admin/customer*') ) ? 'active' : '' }}"><a href="{{ route('admin.customer.index') }}"><i class="fi fi-br-database"></i> <span>Customer</span></a></li>

                       {{-- <li class="{{ ( request()->is('admin/address*') ) ? 'active' : '' }}"><a href="{{ route('admin.address.index') }}"><i class="fi fi-br-database"></i> <span>Address</span></a></li>
                    </ul>
                </li>--}}

                <li class="{{ ( request()->is('admin/coupon*') ) ? 'active' : '' }}"><a href="{{ route('admin.coupon.index') }}"><i class="fi fi-br-database"></i> <span>Coupon</span></a></li>
                <li class="{{ ( request()->is('admin/product-review*') ) ? 'active' : '' }}"><a href="{{ route('admin.product-review.index') }}"><i class="fi fi-br-database"></i> <span>Product Review</span></a></li>
                {{-- Promotions --}}
               {{-- <li class="{{ ( request()->is('admin/promotions*') ) ? 'active' : '' }}"><a href="{{ route('admin.promotion.index') }}"><i class="fi fi-br-database"></i> <span>Promotion</span></a></li>

                <li class="{{ ( request()->is('admin/voucher*') ) ? 'active' : '' }}"><a href="{{ route('admin.voucher.index') }}"><i class="fi fi-br-database"></i> <span>Voucher</span></a></li> --}}

                <li class="{{ ( request()->is('admin/transaction*') ) ? 'active' : '' }}"><a href="{{ route('admin.transaction.index') }}"><i class="fi fi-br-database"></i> <span>Online Transactions</span></a></li>

                <li class="@if(request()->is('admin/settings*') || request()->is('admin/banner*')|| request()->is('admin/feature-banner*') || request()->is('admin/poster*')|| request()->is('admin/promotion-image*')|| request()->is('admin/product-video*')|| request()->is('admin/faq*') || request()->is('admin/gallery*') || request()->is('admin/global*') || request()->is('admin/blog*') || request()->is('admin/subscription*') || request()->is('admin/news*') || request()->is('admin/franchise*')) { {{'active'}} }  @endif">
                    <a href="javascript: void(0)"><i class="fi fi-br-cube"></i> <span>Settings</span></a>
                    <ul>
						<li class="{{ ( request()->is('admin/banner*') ) ? 'active' : '' }}"><a href="{{ route('admin.banner.index') }}"><i class="fi fi-br-database"></i> <span>Banner</span></a></li>
<li class="{{ ( request()->is('admin/feature-banner*') ) ? 'active' : '' }}"><a href="{{ route('admin.feature-banner.index') }}"><i class="fi fi-br-database"></i> <span>Feature Banner</span></a></li>
                        <li class="{{ ( request()->is('admin/poster*') ) ? 'active' : '' }}"><a href="{{ route('admin.poster.index') }}"><i class="fi fi-br-database"></i> <span>Poster</span></a></li>
                        <li class="{{ ( request()->is('admin/promotion-image*') ) ? 'active' : '' }}"><a href="{{ route('admin.promotion-image.index') }}"><i class="fi fi-br-database"></i> <span>Promotional Image</span></a></li>
                        
                        <li class="{{ ( request()->is('admin/product-video*') ) ? 'active' : '' }}"><a href="{{ route('admin.product-video.index') }}"><i class="fi fi-br-database"></i> <span>Product Video</span></a></li>
                        <li class="{{ ( request()->is('admin/settings*') ) ? 'active' : '' }}"><a href="{{ route('admin.settings.index') }}"><i class="fi fi-br-database"></i> <span>Site Settings</span></a></li>

                        <li class="{{ ( request()->is('admin/faq*') ) ? 'active' : '' }}"><a href="{{ route('admin.faq.index') }}"><i class="fi fi-br-database"></i> <span>FAQs</span></a></li>

                        <li class="{{ ( request()->is('admin/gallery*') ) ? 'active' : '' }}"><a href="{{ route('admin.gallery.index') }}"><i class="fi fi-br-database"></i> <span>Gallery</span></a></li>
                        <li class="{{ ( request()->is('admin/blog*') ) ? 'active' : '' }}"><a href="{{ route('admin.blog.index') }}"><i class="fi fi-br-database"></i> <span>Blog</span></a></li>
                        <li class="{{ ( request()->is('admin/news*') ) ? 'active' : '' }}"><a href="{{ route('admin.news.index') }}"><i class="fi fi-br-database"></i> <span>News</span></a></li>
                        <li class="{{ ( request()->is('admin/global*') ) ? 'active' : '' }}"><a href="{{ route('admin.global.index') }}"><i class="fi fi-br-database"></i> <span>Global</span></a></li>
                        {{--<li class="{{ ( request()->is('admin/mail*') ) ? 'active' : '' }}"><a href="{{ route('admin.subscription.mail.index') }}"><i class="fi fi-br-database"></i> <span>Subscription Mail</span></a></li>

                        <li class="{{ ( request()->is('admin/mail*') ) ? 'active' : '' }}"><a href="{{ route('admin.franchise.index') }}"><i class="fi fi-br-database"></i> <span>Franchise request</span></a></li>--}}
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="nav__footer">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fi fi-br-sign-out"></i> <span>Log Out</span></a>
        </div>
    </aside>
    <main class="admin">
        <header>
            <div class="row align-items-center">
                <div class="col-auto">
                    {{-- <input type="search" name="" class="form-control header__search" placeholder="Quick Search here"> --}}
                </div>
                <div class="col-auto ms-auto">
                    {{-- <a href="javascript: void(0)" class="notify__bell"><i class="fi fi-br-bell"></i></a> --}}
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <section class="admin__title">
            <h1>@yield('page')</h1>
        </section>

        @yield('content')

        <footer>
            <div class="row">
                <div class="col-12 text-end">Total Comfort 2021-2022</div>
            </div>
        </footer>
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/plugins/croppie/croppie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
		toastr.options = {
			"closeButton": true, // Show close button
			"debug": false,
			"newestOnTop": true,
			"progressBar": true, // Show progress bar
			"positionClass": "toast-top-right", // Position: top-right, top-left, bottom-right, bottom-left
			"preventDuplicates": true,
			"onclick": null,
			"showDuration": "300", // Animation duration
			"hideDuration": "1000",
			"timeOut": "5000", // How long the toast stays visible
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
        // click to select all checkbox
        function headerCheckFunc() {
            if ($('#flexCheckDefault').is(':checked')) {
                $('.tap-to-delete').prop('checked', true);
                clickToRemove();
            } else {
                $('.tap-to-delete').prop('checked', false);
                clickToRemove();
            }
        }

        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3500,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: type,
                title: title,
                // text: body
            })
        }

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif
    </script>

    @yield('script')
</body>
</html>
