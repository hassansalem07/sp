@extends('master.front')
@section('title')
    {{__('Payment')}}
@endsection
@section('content')
    <!-- Page Title-->
<div class="page-title">
    <div class="container">
      <div class="column">
        <ul class="breadcrumbs">
          <li><a href="{{route('front.index')}}">{{ __('Home') }}</a> </li>
          <li class="separator"></li>
          <li>{{ __('Review your order and pay') }}</li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1  checkut-page">
    <div class="row">
      <!-- Payment Methode-->
      <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h6 class="pb-2">{{__('Review Your Order')}} :</h6>
        <hr>
        <div class="row">
          <div class="col-6">
            <h6>{{__('User Information')}} :</h6>
            <ul class="list-unstyled">
              <li><span class="text-muted">{{__('Name')}}: </span>{{$user['first_name']}} {{$user['last_name']}}</li>
              <li><span class="text-muted">{{__('Phone')}}: </span>{{$user['phone']}}</li>
              <li><span class="text-muted">{{__('Email')}}: </span>{{$user['email']}}</li>

       
            </ul>
          </div>
          <div class="col-6">
            <h6>{{__('Address Information')}} :</h6>
            <ul class="list-unstyled">
              @if (PriceHelper::CheckDigital())
              <li><span class="text-muted">{{__('City')}}: </span> {{$user['city']}}</li>
              <li><span class="text-muted">{{__('Region')}}: </span> {{$user['region']}}</li>
              <li><span class="text-muted">{{__('Street')}}: </span> {{$user['street']}}</li>
              <li><span class="text-muted">{{__('Address')}}: </span>{{$user['address']}}</li>
              @endif
       
            </ul>

            <form action="{{route('submit.order')}}" method="POST">
              @csrf
              <input type="hidden" name="first_name" value="{{$user['first_name']}}">
              <input type="hidden" name="last_name" value="{{$user['last_name']}}">
              <input type="hidden" name="phone" value="{{$user['phone']}}">
              <input type="hidden" name="email" value="{{$user['email']}}">
              <input type="hidden" name="city" value="{{$user['city']}}">
              <input type="hidden" name="region" value="{{$user['region']}}">
              <input type="hidden" name="street" value="{{$user['street']}}">
              <input type="hidden" name="address" value="{{$user['address']}}">
              <input type="hidden" name="cart_total" value="{{$data['cart_total']}}">
              <input type="hidden" name="grand_total" value="{{$data['grand_total']}}">
              <input type="hidden" name="shipping" value="{{$data['shipping']}}">
              <input type="hidden" name="tax" value="{{$data['tax']}}">
              <input type="hidden" name="cart" value="{{json_encode($data['cart'])}}">
              <input class="btn btn-primary" type="submit" value="submit">
            </form>
          </div>

        </div>

        </div>
        </div>
        
      </div>
      @include('includes.checkout_sitebar',$data)
    </div>
  </div>
@endsection

