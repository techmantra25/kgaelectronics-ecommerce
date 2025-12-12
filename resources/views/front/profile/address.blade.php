@extends('front.profile.layouts.app')

@section('profile-content')
<div class="col-lg-9 col-md-8 col-12">
    <div class="profile-card">
        {{-- <h3>Default Addresses</h3>

        <div class="address-card">
            <span class="badge badge-secondary float-right">Home</span>
            <h5>Jhon Doe</h5>
            <p>College Pally, Telinipara, P.O. Sewli, Kolkata 700121<br/>Sewli Telinipara,<br/>North 24 parganas, - 700121<br/>West Bengal</p>
            <p>Mobile: 8420425082</p>
        </div> --}}

        <div class="profile-card-footer">
            <a href="{{route('front.user.address.add')}}" class="btn checkout-btn">Add Address</a>
        </div>
    </div>

    <div class="profile-card">
        <h3>Addresses</h3>
        @forelse ($data as $addressKey => $addressValue)
        <div class="address-card">
           <!-- <span class="badge badge-info float-right">{{ ($addressValue->type == 1 ? 'Home' : ($addressValue->type == 2 ? 'Work' : 'Other')) }}</span>-->
            <br><a class="badge badge-info float-right" href="{{route('front.user.address.edit', $addressValue->id)}}">edit</a>
             <br><a class="badge badge-info float-right" href="{{route('front.user.address.delete', $addressValue->id)}}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg><!--<span>Remove</span>--></a>
			
            <h5>{{$addressValue->user->name}}</h5>
            <p>{{$addressValue->address}}<br/>{{$addressValue->landmark ? $addressValue->landmark.',' : ''}}<br/>{{$addressValue->city}}, - {{$addressValue->pin}}<br/>{{$addressValue->state}}</p>
            <p>Mobile: {{$addressValue->user->mobile}}</p>
        </div>
        @empty
        <p>No address found. Add new.</p>
        @endforelse
    </div>
</div>
@endsection