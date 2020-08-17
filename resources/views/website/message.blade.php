@extends('website.template.master')

<!-- Page Header -->
<header class="masthead" style="background-image: url({{ asset('website/img/banners/bg2.jpg') }})">
<div class="overlay"></div>
<div class="container">
    <div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="page-heading">
        <h2>{{ __('website.site_name') . " · " . __('website.leave_message') }}</h2>
        <span class="subheading mt-4">{{ __('website.welcome_your_message') }}</span>
        </div>
    </div>
    </div>
</div>
</header>

<!-- Main Content -->
<div class="container">
<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <p>{{ __('website.send_me_a_message') }}</p>

        @include('includes.flash')

        {!! Form::open(['route' => ['message.submit', app()->getLocale()]]) !!}
        <div class="control-group">
        <div class="form-group floating-label-form-group controls">
            <label>{{ __('website.your_name') }}</label>
            <input type="text" name="name" class="form-control" placeholder="{{ __('website.your_name') }}" id="name" required data-validation-required-message="{{ __('website.your_name_required') }}">
            <p class="help-block text-danger"></p>
        </div>
        </div>
        <div class="control-group">
        <div class="form-group floating-label-form-group controls">
            <label>{{ __('website.your_email') }}</label>
            <input type="email" name="email" class="form-control" placeholder="{{ __('website.your_email') }}" id="email" required data-validation-required-message="{{ __('website.your_email_required') }}">
            <p class="help-block text-danger"></p>
        </div>
        </div>
        <div class="control-group">
        <div class="form-group col-xs-12 floating-label-form-group controls">
            <label>{{ __('website.your_phone') }}</label>
            <input type="tel" name="tel" class="form-control" placeholder="{{ __('website.your_phone') }}" id="phone" required data-validation-required-message="{{ __('website.your_phone_required') }}">
            <p class="help-block text-danger"></p>
        </div>
        </div>
        <div class="control-group">
        <div class="form-group floating-label-form-group controls">
            <label>{{ __('website.your_message') }}</label>
            <textarea name="message" rows="5" class="form-control" placeholder="{{ __('website.your_message') }}" id="message" required data-validation-required-message="{{ __('website.your_message_required') }}"></textarea>
            <p class="help-block text-danger"></p>
        </div>
        </div>
        <br>
        <div id="success"></div>
        <button type="submit" class="btn btn-primary py-2 px-4 text-xl" id="sendMessageButton">{{ __('website.send') }}</button>
        {!! Form::close() !!}
    </div>
</div>
</div>
