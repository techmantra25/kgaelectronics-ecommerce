@extends('admin.layouts.app')

@section('page', 'Order detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-5">
            <div class="card shadow-sm">
                <div class="card-header">Ordered Products ({{count($data->orderProducts)}})</div>
                <div class="card-body pt-0">
                    @foreach($data->orderProducts as $productKey => $productValue)
                    <div class="admin__content">
                        <aside>
                            <nav>{{$productValue->product_name}}</nav>
                            <img src="{{ asset($productValue->product_image) }}" class="mt-2" style="width: 80%;">
                        </aside>
                        <content>
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Style no :</label>
                                </div>
                                <div class="col-auto">
                                    {{$productValue->productDetails->style_no}}
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Qty :</label>
                                </div>
                                <div class="col-auto">
                                    {{$productValue->qty}}
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Price :</label>
                                </div>
                                <div class="col-auto">
                                    Rs {{$productValue->price}}
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Offer Price :</label>
                                </div>
                                <div class="col-auto">
                                    Rs {{$productValue->offer_price}}
                                </div>
                            </div>
                            @if ($productValue->productVariationDetails)
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Color :</label>
                                </div>
                                <div class="col-auto">
                                    {{ucwords($productValue->productVariationDetails->colorDetails->name)}}
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-5">
                                    <label for="inputPassword6" class="col-form-label">Size :</label>
                                </div>
                                <div class="col-auto">
                                    {{strtoupper($productValue->productVariationDetails->sizeDetails->name)}}
                                </div>
                            </div>
                            @endif
                        </content>
                    </div>
                    @endforeach

                    <!-- <div class="row product__thumb">
                        @foreach($data->orderProducts as $productKey => $productValue)
                            <div class="col-md-6">
                                <img src="{{ asset($productValue->product_image) }}" style="height:100px">
                                <p class="small single-line mb-0">{{$productValue->product_name}}</p>
                                <p class="small text-dark mb-0"> <span class="text-muted">Style no : </span> {{$productValue->productDetails->style_no}}</p>
                                <hr class="my-1">
                                <p class="small text-dark mb-0"> <span class="text-muted">Qty : </span> {{$productValue->qty}}</p>
                                <p class="small text-dark mb-0"> <span class="text-muted">Price : </span> Rs {{$productValue->price}}</p>
                                <p class="small text-dark mb-0"> <span class="text-muted">Offer price : </span> Rs {{$productValue->offer_price}}</p>
                                @if ($productValue->productVariationDetails)
                                    <p class="small text-dark mb-0"> <span class="text-muted">Color : </span> {{ucwords($productValue->productVariationDetails->colorDetails->name)}}</p>
                                    <p class="small text-dark mb-0"> <span class="text-muted">Size : </span> {{strtoupper($productValue->productVariationDetails->sizeDetails->name)}}</p>
                                @endif
                            </div>
                        @endforeach
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 6)" type="button" class="status_6 btn btn-outline-primary btn-sm {{($data->status == 6) ? 'active' : ''}}">Pending</a>
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 1)" type="button" class="status_1 btn btn-outline-primary btn-sm {{($data->status == 1) ? 'active' : ''}}">New</a>
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 2)" type="button" class="status_2 btn btn-outline-primary btn-sm {{($data->status == 2) ? 'active' : ''}}">Confirm</a>
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 3)" type="button" class="status_3 btn btn-outline-primary btn-sm {{($data->status == 3) ? 'active' : ''}}">Shipped</a>
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 4)" type="button" class="status_4 btn btn-outline-success btn-sm {{($data->status == 4) ? 'active' : ''}}">Delivered</a>
                        <a href="javascript: void(0)" onclick="statusUpdate({{$data->id}}, 5)" type="button" class="status_5 btn btn-outline-danger btn-sm {{($data->status == 5) ? 'active' : ''}}" onclick="return confirm('Are you sure ?')">Cancelled</a>
                    </div>

                    @if ($data->status == 5)
                        <div class="w-100 mt-3">
                            Cancelled by: {{ ($data->orderCancelledBy == 0) ? 'ADMIN' : 'CUSTOMER' }}
                        </div>
                        <div class="w-100 mt-1">
                            Cancellation Reason: {!! ($data->orderCancelledReason) ?? 'NA' !!}
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <p class="small">Order Time : {{date('j M Y g:i A', strtotime($data->created_at))}}</p>
                        <h5>#{{$data->order_no}}</h5>
                        <h2>{{$data->fname.' '.$data->lname}}</h2>
                        <p class="small text-dark mb-0"> <span class="text-muted">Email : </span> {{$data->email}}</p>
                        <p class="small text-dark mb-0"> <span class="text-muted">Mobile : </span> {{$data->mobile}}</p>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="small text-dark mb-2"> <span class="text-muted">Billing address</span></p>
                            <p class="small text-dark mb-0"> <span class="text-muted">Address : </span> {{$data->billing_address}}</p>
                            <p class="small text-dark mb-0"> <span class="text-muted">Landmark : </span> {{$data->billing_landmark}}</p>
                            <p class="small text-dark mb-0"> {{$data->billing_pin.', '.$data->billing_city.', '.$data->billing_state.', '.$data->billing_country}}</p>
                        </div>

                        <div class="col-md-6 border-start">
                            <p class="small text-dark mb-2"> <span class="text-muted">Shipping address</span></p>
                            @if ($data->shippingSameAsBilling == 1) <p class="small text-dark mb-2"> <span class="text-muted"> <i class="fi fi-br-info"></i> Same as Billing address </span></p>@endif
                            <p class="small text-dark mb-0"> <span class="text-muted">Address : </span> {{$data->shipping_address}}</p>
                            <p class="small text-dark mb-0"> <span class="text-muted">Landmark : </span> {{$data->shipping_landmark}}</p>
                            <p class="small text-dark mb-0"> {{$data->shipping_pin.', '.$data->shipping_city.', '.$data->shipping_state.', '.$data->shipping_country}}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3 justify-content-end">
                        <div class="col-md-8">
                            @if ($data->coupon_code_id != 0)
                                <p class="small text-muted mb-2">{{ ($data->couponDetails->is_coupon == 0) ? 'Voucher' : 'Coupon' }} used</p>
                                <a href="{{ route('admin.coupon.view', $data->coupon_code_id) }}" class="small text-primary mb-0">{{$data->couponDetails->coupon_code}}</a>
                            @endif
                            <p class="small text-dark mb-0"> <span class="text-muted">Payment method : </span> {{$data->payment_method}}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="small text-muted mb-2">Pricing</p>
                            <table class="w-100">
                                <tr>
                                    <td><p class="small text-muted mb-0">Amount : </p></td>
                                    <td><p class="small text-dark mb-0 text-end">Rs {{$data->amount}}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="small text-muted mb-0">Tax Amount : </p></td>
                                    <td><p class="small text-dark mb-0 text-end">+ Rs {{$data->tax_amount}}</p></td>
                                </tr>
                                <tr>
                                    <td><p class="small text-muted mb-0">Discount : </p></td>
                                    @if ($data->coupon_code_id != 0)
                                        <td><p class="small text-dark mb-0 text-end">- {{ $data->coupon_code_discount_type == 'Percentage' ? $data->discount_amount .'%' : 'Rs. ' . $data->discount_amount }}</p></td>
                                    @else
                                        <td><p class="small text-dark mb-0 text-end">- {{$data->discount_amount}}</p></td>
                                    @endif
                                </tr>
                                <tr class="border-top">
                                    <td><p class="small text-muted mb-0">Final Amount : </p></td>
                                    <td><p class="small text-dark mb-0 text-end">Rs {{$data->final_amount}}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        function statusUpdate(orderId, status) {
            const res = confirm('Customer will receive email about the order. Are you sure ?');

            if (res === true) {
                $('.btn-group .btn').addClass('disabled');
                $.ajax({
                    url: "{{ route('admin.order.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: orderId,
                        status: status,
                    },
                    success: function(resp) {
                        if (resp.error === false) {
                            $('.btn-group .btn').removeClass('active').removeClass('disabled');
                            $('.btn-group .status_'+status).addClass('active');
                            toastFire('success', resp.message);
                        } else {
                            toastFire('warning', resp.message);
                        }
                    }
                });
            } else {
                return false;
            }
        }
    </script>
@endsection