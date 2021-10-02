@extends('layouts.app')
@section('content')
@include("includes.shop.header")
<div class="toast-container mt-5 pt-5 position-absolute top-0 end-0 p-3" style="right: unset!important">
    @if(session("password_success_message"))
    <div class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" dir="ltr">
        <div class="toast-header bg-success">
            <strong class="me-auto text-light fs-6">success</strong>
        </div>
        <div class="toast-body">
            {{session("password_success_message")}}
        </div>
    </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" dir="ltr">
            <div class="toast-header bg-danger">
                <strong class="me-auto text-light fs-6">error</strong>
            </div>
            <div class="toast-body">
                {{$error}}
            </div>
        </div>
        @endforeach
    @endif
</div>
<div class="container pt-3">
    <h2 class="text-center mb-4">{{__("app.account")}}</h2>
    <div class="row justify-content-start py-5">
        <div class="col-md-3 border-end">
            <ul class="list-group col-12 col-md-11 list-group-flush">
                <a href="#" data-click="read" class="edit-account list-group-item py-3 posision-relative fs-6">
                    {{__("app.edit")}}
                    {{__("app.account")}}
                    <span class="position-absolute text-primary top-50 start-100 translate-middle-y" style="margin-right: -1.25em">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                    </span>
                </a>

                <a href="/account/edit-password" class="list-group-item py-3 position-relative fs-6">
                    {{__("app.edit")}}
                    {{__("app.password")}}
                    <span class="position-absolute text-primary top-50 start-100 translate-middle-y"  style="margin-right: -1.25em">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                        </svg>
                    </span>
                </a>
                <a href="/orders" class="list-group-item py-3 position-relative fs-6">
                    {{__("app.your-orders")}}
                    <span class="position-absolute text-primary top-50 start-100 translate-middle-y" style="margin-right: -1.25em">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                            <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                            <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
                        </svg>
                    </span>
                </a>
            </ul>
        </div>
        <div class="col-md-6 ps-4">
            <form method="POST" action="/account/update" class="account-form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fs-6 mb-1" for="first_name">{{__("app.fname")}}<span class="text-danger ms-1">*</span></label>
                        <input readonly type="text" class="form-control" name="fname" id="first_name" value="{{auth()->user()->fname}}" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fs-6 mb-1" for="last_name">{{__("app.lname")}}<span class="text-danger ms-1">*</span></label>
                        <input readonly type="text" class="form-control" name="lname" id="last_name" value="{{auth()->user()->lname}}" >
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fs-6 mb-1" for="country">{{__("app.governorate")}}<span class="text-danger ms-1">*</span></label>
                        <select class="w-100" disabled id="country" name="governorate">
                            <option value="">{{__("app.governorate")}}</option>
                            <option value="cairo" @if(auth()->user()->city === "cairo") selected @endif >Cairo</option>
                            <option value="giza" @if(auth()->user()->city === "giza") selected @endif >Giza</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fs-6 mb-1" for="street_address">{{__("app.address")}} <span class="text-danger ms-1">*</span></label>
                        <input readonly type="text" class="form-control mb-3" name="address_one" id="street_address" value="{{auth()->user()->address_one}}">
                        <input readonly type="text" class="form-control" name="address_two" id="street_address2" value="{{auth()->user()->address_two}}">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fs-6 mb-1" for="phone_number">{{__("app.phone")}}<span class="text-danger ms-1">*</span></label>
                        <input readonly type="text" class="form-control" name="phone" id="phone_number" min="0" value="{{auth()->user()->phone}}">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="fs-6 mb-1" for="email_address">{{__("app.email")}}</label>
                        <input readonly type="email" class="form-control" name="email" id="email_address" value="{{auth()->user()->email}}">
                    </div>
                </div>
                <button type="submit" class="btn d-none essence-btn fs-6 mt-2">{{__("app.save")}}</button>
            </form>
        </div>
    </div>
</div>
@endsection