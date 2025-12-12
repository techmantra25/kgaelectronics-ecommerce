@extends('admin.layouts.app')

@section('page', 'Order invoice')

@section('content')
    <style>
        .border td {
            border: 1px solid #ddd;
        }

        table,
        table p {
            font-size: 12px;
        }

        table h3 {
            font-size: 16px;
        }
    </style>
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript: void(0)" type="button" class="btn btn-primary btn-sm" onclick="printInvoice()">Print</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="printDiv">
                            <table border="1" class="table-bordered" style="width: 100%; border-collapse: collapse;"
                                cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table border="1" style="width: 100%; border-collapse: collapse;"
                                            class="table-bordered" cellpadding="10" cellspacing="0">
                                            <tr>
                                                <td style="width: 35%;" rowspan="2">
                                                    <p style="margin: 0">Sender</p>
                                                    <p style="margin: 0;"><strong>{!! $settings[18]->content !!}</strong><br />{!! $settings[5]->content !!}</p>
                                                    <p style="margin: 0;">Ph No: <strong>{{ $settings[6]->content }}</strong></p>
                                                    <p style="margin: 0;">GSTIN: <strong>{{ $settings[19]->content }}</strong></p>
                                                </td>
                                                <td style="width: 35%;">
                                                    <p style="margin: 0;">Invoice ID:<br /><strong>{{ $data->order_no }}</strong></p>
                                                </td>
                                                <td style="width: 30%;">
                                                    <p style="margin: 0;">Invoice Date:<br /><strong>{{date('j-M-Y', strtotime($data->created_at))}}</strong>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="margin: 0;">Order No: <strong>{{ $data->order_no }}</strong></p>
                                                    <p style="margin: 0;">Order Date: {{date('j-M-Y', strtotime($data->created_at))}}</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0;">Portal: <strong>{!! $settings[18]->content !!}</strong></p>
                                                    <p style="margin: 0;">Payment Mode</p>
                                                    <p style="margin: 0;"><strong>
                                                        @php
                                                            if ($data->payment_method == "cash_on_delivery") {
                                                                echo 'Cash on Delivery';
                                                            } else {
                                                                echo 'Online Payment';
                                                            }
                                                        @endphp
                                                    </strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="margin: 0;">Bill To: <br />
                                                        <strong>{{$data->fname.' '.$data->lname}}</strong>
                                                        <br />{{$data->billing_address}}, {{$data->billing_landmark}}, {{$data->billing_pin.', '.$data->billing_city.', '.$data->billing_state.', '.$data->billing_country}}</p>
                                                    <p style="margin: 0;">T : {{$data->mobile}}</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0;">Ship To: <br />
                                                        <strong>{{$data->fname.' '.$data->lname}}</strong>
                                                        <br />{{$data->shipping_address}}, {{$data->shipping_landmark}}, {{$data->shipping_pin.', '.$data->shipping_city.', '.$data->shipping_state.', '.$data->shipping_country}}</p>
                                                    <p style="margin: 0;">T : {{$data->mobile}}</p>
                                                </td>
                                                <td>
                                                    {{-- <p style="margin: 0;">Dispatch Through<br /><strong>EK</strong><br />AWB
                                                        No<br /> MYNP0032032743</p> --}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <table border="1" style="width: 100%; border-collapse: collapse;" class="table-bordered" cellpadding="10" cellspacing="0">
                                        <tr>
                                            <th align="center">SI No.</th>
                                            <th align="center">Descriptions of Goods</th>
                                            <th align="center">Qty</th>
                                            <th align="center">Amount</th>
                                            <th align="center">Coupon Discount</th>
                                            <th align="center">Final Amount</th>
                                        </tr>

                                        @foreach($data->orderProducts as $productKey => $productVal)
									
                                            @php
                                                $amount = $productVal->offer_price * $productVal->qty;
                                                $offer_price = $productVal->offer_price;
                                                $discount_amount =(($amount - $offer_price) / $amount) * 100;
															
                                            @endphp

                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td> <!-- dynamic serial number -->
                                                <td><strong>{{ $productVal->product_name }}</strong></td>
                                                <td align="center">{{ $productVal->qty }}</td>
                                                <td align="center">{{ number_format($amount, 2) }}</td>

                                                <!-- Display discount if applicable -->
                                                <td align="center">
                                                    @if($discount_amount > 0)
                                                        {{ $discount_amount }}%
                                                    @else
                                                        No Discount
                                                    @endif
                                                </td>

                                                <td align="center">{{ number_format($offer_price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" style="width: 100%; border-collapse: collapse;"
                                            class="" cellpadding="10" cellspacing="0">
                                            <tr>
                                                <td valign="top">
                                                    <p style="margin: 0;">Amount Chargeable (in words)<br /><strong>INR {{ amountInWords($data->final_amount) }} Only Tax is payable on reverse charge basis: No</strong></p>
                                                </td>
                                                <td align="right" valign="top">
                                                    <h4 style="margin: 0; font-size: 14px;">E. & O.E</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%;">
                                                    <p style="margin: 0;"><u>Declaration</u></p>
                                                    <p style="margin: 0;">1. All claims, if any, for shortages or damages
                                                        must be reported to customer service on the day of delivery through
                                                        the contact us page on the web store 2. All Disputes are subject to
                                                        Maharashtra (27) jurisdiction only.</p>
                                                </td>
                                                <td align="center"
                                                    style="width: 50%; border-top: 1px solid #000; border-left: 1px solid #000;">
                                                    <h3>KGA Electronics</h3>
                                                    <h3>Authorised Signatory</h3>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" style="width: 100%; border-collapse: collapse;"
                                            class="" cellpadding="10" cellspacing="0">
                                            <tr>
                                                <td style="width: 49%;">
                                                    <p style="margin: 0;"><strong>Bill By</strong>
                                                </td>
                                                <td style="width: 2%;" align="center">:</td>
                                                <td style="width: 49%;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/printThis.js') }}"></script>

    <script>
        function printInvoice() {
            var printContents = document.querySelector('.printDiv').innerHTML;

			// Create a new window
			var originalContents = document.body.innerHTML;

			// Replace the body with only the print div content
			document.body.innerHTML = printContents;

			// Trigger the print
			window.print();

			// Restore the original content
			document.body.innerHTML = originalContents;

			// Reload the page to ensure JavaScript and other features are re-enabled
			location.reload();
        }
    </script>
@endsection
