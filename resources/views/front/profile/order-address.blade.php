@extends('front.profile.layouts.app')

@section('profile-content')
<div class="col-lg-9 col-md-8 col-12">
  <div class="profile-card">
    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
	 @elseif(session('failure'))
	  <div class="alert alert-danger">
      {{ session('failure') }}
    </div>
    @endif
    <h3>Addresses</h3>
	  @foreach($addresses as $key => $address)
      <div class="address-card">
        <input type="radio" id="address_{{ $address->id }}" name="selected_address_id" value="{{ $address->id }}" onchange="updateAddress('{{$address->address}}', '{{$address->landmark}}', '{{$address->location}}', '{{$address->city}}', '{{$address->state}}', '{{$address->country}}', '{{$address->pin}}')">
        <label for="address_{{ $address->id }}"  style="cursor: pointer;">
          <span><strong>Address {{ $key + 1 }}:</strong></span>
          <p>
            {{ $address->address }},
            {{ $address->landmark ? $address->landmark . ',' : '' }}
            {{ $address->location }},
            {{ $address->city }},
            {{ $address->state }},
            {{ $address->country }},
            {{ $address->pin }}
          </p>
        </label>
      </div>
      @endforeach
  </div>

  <form method="POST" action="{{ route('front.user.order.address.update', $data->id) }}" id="address-form">
    @csrf
    <div class="profile-card">
		 
      <h3>Billing Address</h3>
      <div class="row">
        <div class="col-sm-12">
         <div class="form-group d-block">
            <input type="text" class="form-control @error('country') is-invalid @enderror" placeholder="Country/Region" name="country" id="billing_country" value="{{ old('country', $data->billing_country) }}">
            @error('country')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Address" name="address" id="billing_address"
              value="{{old('address',$data->billing_address)}}">
            <label class="floating-label">Address</label>
			  @error('billing_address')
				<span class="invalid-feedback">{{ $message }}</span>
			@enderror
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('landmark') is-invalid @enderror" placeholder="Landmark" name="landmark" id="billing_landmark"
              value="{{old('landmark',$data->billing_landmark)}}">
            <label class="floating-label">Landmark</label>
			  
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('location') is-invalid @enderror" placeholder="Location" id="billing_location" name="location"
              value="{{old('location',$data->billing_location)}}">
            <label class="floating-label">Location</label>
			 @error('location')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('city') is-invalid @enderror" placeholder="City" name="city" id="billing_city"
              value="{{old('city',$data->billing_city)}}">
            <label class="floating-label">City</label>
			   @error('city')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('state') is-invalid @enderror" placeholder="State" name="state" id="billing_state"
              value="{{old('state',$data->billing_state)}}">
            <label class="floating-label">State</label>
			   @error('state')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group d-block">
            <input type="text" class="form-control @error('pin') is-invalid @enderror" placeholder="Pin Code" name="pin" id="billing_pin" value="{{ old('pin', $data->billing_pin) }}">
			  <label class="floating-label">Pin Code</label>
            @error('pin')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            
          </div>
        </div>
      </div>
    </div>

    <div class="form-group d-block">
      <input type="checkbox" id="same_as_billing" name="same_as_billing" value='1'>
      <label for="same_as_billing">Same as Billing Address</label>
    </div>

    <div class="profile-card">
      <h3>Shipping Address</h3>
      <div class="shipping-address-section">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_country') is-invalid @enderror" placeholder="Country/Region" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', $data->shipping_country) }}">
              <label class="floating-label">Country/Region</label>
				@error('shipping_country')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
         <div class="col-sm-12">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" placeholder="Address" name="shipping_address"
                id="shipping_address" value="{{old('shipping_address',$data->shipping_address)}}">
              <label class="floating-label">Address</label>
				@error('shipping_country')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_landmark') is-invalid @enderror" placeholder="Landmark" name="shipping_landmark"
                id="shipping_landmark" value="{{old('shipping_landmark',$data->shipping_landmark)}}">
              <label class="floating-label">Landmark</label>
				
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_location') is-invalid @enderror" placeholder="Location" id="shipping_location"
                name="shipping_location" value="{{old('shipping_location',$data->shipping_location)}}">
              <label class="floating-label">Location</label>
				@error('shipping_location')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" placeholder="City" name="shipping_city" id="shipping_city"
                value="{{old('shipping_city',$data->shipping_city)}}">
              <label class="floating-label">City</label>
				@error('shipping_city')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" placeholder="State" name="shipping_state" id="shipping_state"
                value="{{old('shipping_state',$data->shipping_state)}}">
              <label class="floating-label">State</label>
				@error('shipping_state')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group d-block">
              <input type="text" class="form-control @error('shipping_pin') is-invalid @enderror" placeholder="Pin Code" name="shipping_pin" id="shipping_pin" value="{{ old('shipping_pin', $data->shipping_pin) }}">
				<label class="floating-label">Pin Code</label>
              @error('shipping_pin')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
              <label class="floating-label">Pin Code</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="profile-card-footer">
      <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
      <button type="submit" class="btn checkout-btn" id="UpdateAddress">Update Address</button>
    </div>
  </form>
</div>
@endsection

@section('script')
<script>
  // Handle checkbox logic for copying billing to shipping address

  $(document).ready(function() {
    // Handle checkbox logic for copying billing to shipping address
    $('#same_as_billing').change(function () {
      if (this.checked) {
        $('#shipping_country').val($('#billing_country').val()).prop('disabled', true);
        $('#shipping_address').val($('#billing_address').val()).prop('disabled', true);
        $('#shipping_landmark').val($('#billing_landmark').val()).prop('disabled', true);
        $('#shipping_location').val($('#billing_location').val()).prop('disabled', true);
        $('#shipping_city').val($('#billing_city').val()).prop('disabled', true);
        $('#shipping_state').val($('#billing_state').val()).prop('disabled', true);
        $('#shipping_pin').val($('#billing_pin').val()).prop('disabled', true);
      } else {
        $('#shipping_country').val('').prop('disabled', false);
        $('#shipping_address').val('').prop('disabled', false);
        $('#shipping_landmark').val('').prop('disabled', false);
        $('#shipping_location').val('').prop('disabled', false);
        $('#shipping_city').val('').prop('disabled', false);
        $('#shipping_state').val('').prop('disabled', false);
        $('#shipping_pin').val('').prop('disabled', false);
      }
    });

    // Before form submission, enable the fields temporarily
    $('#address-form').submit(function() {
      if ($('#same_as_billing').is(':checked')) {
        $('#shipping_country, #shipping_address, #shipping_landmark, #shipping_location, #shipping_city, #shipping_state, #shipping_pin').prop('disabled', false);
      }
    });
  });
	 function updateAddress(address, landmark, location, city, state, country, pin) {
		 $('#shipping_country').val(country);
		 $('#shipping_address').val(address);
		 $('#shipping_landmark').val(landmark);
		 $('#shipping_location').val(location);
		 $('#shipping_city').val(city);
		 $('#shipping_state').val(state);
		 $('#shipping_pin').val(pin);
		 
		 $('#billing_country').val(country);
		 $('#billing_address').val(address);
		 $('#billing_landmark').val(landmark);
		 $('#billing_location').val(location);
		 $('#billing_city').val(city);
		 $('#billing_state').val(state);
		 $('#billing_pin').val(pin);
		$('#same_as_billing').attr('checked', 'checked');// Set checkbox as checked


	 }


</script>
@endsection
