@extends('front.profile.layouts.app')

@section('profile-content')
<div class="col-lg-9 col-md-8 col-12">
    <form method="POST" action="{{ route('front.user.order.address.billing.update', $data->id) }}" id="address-form">
        @csrf
        <div class="profile-card">
            <h3>Add Address</h3>
            <div class="row">
                <!-- Country/Region Field -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Country/Region" name="billing_country" id="billing_country" value="{{ $data->billing_country }}">
                        <label class="floating-label">Country/Region</label>
                    </div>
                    @error('billing_country')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <!-- Address Field -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Address" name="billing_address" id="billing_address" value="{{ $data->billing_address }}">
                        <label class="floating-label">Address</label>
                    </div>
                    @error('billing_address')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <!-- Landmark Field -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control"  name="billing_landmark" id="billing_landmark" value="{{ $data->billing_landmark }}">
                        <label class="floating-label">Landmark</label>
                    </div>
                    @error('billing_landmark')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <!-- Location Field -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Location" name="billing_location" id="billing_location" value="{{ $data->billing_location }}">
                        <label class="floating-label">Location</label>
                    </div>
                    @error('billing_location')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <!-- City, State, and Pin Code Fields -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="City" name="billing_city" id="billing_city" value="{{ $data->billing_city }}">
                        <label class="floating-label">City</label>
                    </div>
                    @error('billing_city')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="State" name="billing_state" id="billing_state" value="{{ $data->billing_state }}">
                        <label class="floating-label">State</label>
                    </div>
                    @error('billing_state')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Pin Code" name="billing_pin" id="billing_pin" value="{{ $data->billing_pin }}">
                        <label class="floating-label">Pin Code</label>
                    </div>
                    @error('billing_pin')<p class="small text-danger mb-0">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Save Button -->
            <div class="profile-card-footer">
                <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                <button type="submit" class="btn checkout-btn">Update Address</button>
            </div>
        </div>
    </form>

    <!-- Existing Addresses -->
    <div class="profile-card">
        <h3>Addresses</h3>
        @forelse ($dataaddress as $addressKey => $addressValue)
        <div class="address-card">
            <input type="radio" name="selected_address" class="address-radio" data-address="{{ json_encode($addressValue) }}">
            <h5>{{ $addressValue->user->name }}</h5>
            <p>
                {{ $addressValue->country }}<br/>
                {{ $addressValue->address }}<br/>
                {{ $addressValue->landmark ? $addressValue->landmark . ',' : '' }}<br/>
                {{ $addressValue->city }}, - {{ $addressValue->pin }}<br/>
                {{ $addressValue->state }}
            </p>
            <p>Mobile: {{ $addressValue->user->mobile }}</p>
        </div>
        @empty
        <p>No address found. Add new.</p>
        @endforelse
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.btn_lbl').forEach(label => {
        label.addEventListener('click', () => {
            label.previousElementSibling.checked = true;
        });
    });
</script>
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I&libraries=places,geometry&callback=initMap&v=weekly"></script --}}

<script>
    google.maps.event.addDomListener(window,'load',initialize(1));

    /* function initialize(){
        var autocomplete= new google.maps.places.Autocomplete(document.getElementById('location'));

        google.maps.event.addListener(autocomplete, 'place_changed', function(){
            var places = autocomplete.getPlace();
            console.log(places);
            $('#location').val(places.formatted_address);
            $('#lng').val(places.geometry.location.lng());
            $('#lat').val(places.geometry.location.lat());
        });
    }*/
</script>
<script>
 
    // Populate form fields when a radio button is selected
 document.querySelectorAll('.address-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        const addressData = JSON.parse(this.getAttribute('data-address'));
        if (addressData) { // Ensure data is only populated when selected
            document.getElementById('billing_country').value = addressData.country || '';
            document.getElementById('billing_address').value = addressData.address || '';
            document.getElementById('billing_landmark').value = addressData.landmark || '';
            document.getElementById('billing_location').value = addressData.location || '';
            document.getElementById('billing_city').value = addressData.city || '';
            document.getElementById('billing_state').value = addressData.state || '';
            document.getElementById('billing_pin').value = addressData.pin || '';
        }
    });
});

</script>
@endsection
