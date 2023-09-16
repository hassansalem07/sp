@extends('master.front')

@section('title')
    {{__('Billing')}}
@endsection

@section('content')
    <!-- Page Title-->
<div class="page-title">
    <div class="container">
      <div class="column">
        <ul class="breadcrumbs">
          <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
          <li class="separator"></li>
          <li>{{__('Billing address')}}</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Page Content-->
  <div class="container padding-bottom-3x mb-1 checkut-page">
    <div class="row">
      <!-- Billing Adress-->
      <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h6>{{__('User Information')}}</h6>

          <form id="checkoutBilling" action="{{route('front.checkout.shipping.store')}}" method="POST">
            @csrf
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-fn">{{__('First Name')}}</label>
              <input class="form-control" name="first_name" type="text" required id="checkout-fn" value="{{isset($user) ? $user->first_name : ''}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-ln">{{__('Last Name')}}</label>
              <input class="form-control" name="last_name" type="text" required id="checkout-ln" value="{{isset($user) ? $user->last_name : ''}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout_email_billing">{{__('E-mail Address')}}</label>
              <input class="form-control" name="email"  type="email" required id="checkout_email_billing" value="{{isset($user) ? $user->email : ''}}">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-phone">{{__('Phone Number')}}</label>
              <input class="form-control" name="phone" type="text" id="checkout-phone" required value="{{isset($user) ? $user->phone : ''}}">
            </div>
          </div>
        </div>
        <h6>{{__('Address Information')}}</h6>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-city">{{__('City')}}</label>
              <select class="form-control" name="city" id="city">
                @foreach (\App\Models\ShippingCity::all() as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-city">{{__('Region')}}</label>
              <input class="form-control" name="region" required type="text" id="region"  >
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-address1">{{__('Street')}} </label>
              <input class="form-control" name="street" required type="text" id="checkout-street"  >
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="checkout-address1">{{__('Address')}} </label>
              <input class="form-control" name="address" required type="text" id="checkout-address1">
            </div>
          </div>
        </div>
        @if ($setting->is_privacy_trams == 1)
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="trams__condition" >
            <label class="custom-control-label" for="trams__condition">This site is protected by reCAPTCHA and the <a href="{{$setting->policy_link}}" target="_blank">Privacy Policy</a> and <a href="{{$setting->terms_link}}" target="_blank">Terms of Service</a> apply.</label>
          </div>
        </div>
        @endif

        <div class="d-flex justify-content-between paddin-top-1x mt-4">
            <a class="btn btn-primary btn-sm" href="{{route('front.cart')}}"><span class="hidden-xs-down"><i class="icon-arrow-left"></i>{{__('Back To Cart')}}</span></a>
            @if ($setting->is_privacy_trams == 1)
            <button disabled id="continue__button" class="btn btn-primary  btn-sm" type="button"><span class="hidden-xs-down">{{__('Continue')}}</span><i class="icon-arrow-right"></i></button>
            @else
            <button class="btn btn-primary btn-sm" type="submit"><span class="hidden-xs-down">{{__('Continue')}}</span><i class="icon-arrow-right"></i></button>
            @endif
          </div>
        </form>
            </div>
        </div>
      </div>
      @include('includes.checkout_sitebar',$cart)
    </div>
  </div>
@endsection
