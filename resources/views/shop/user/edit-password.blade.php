@extends('layouts.app')
@section('content')
@include("includes.shop.header")
<div class="toast-container mt-5 pt-5 position-absolute top-0 end-0 p-3" style="right: unset!important">
    @if(session("error_password_wrong"))
    <div class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" dir="ltr">
        <div class="toast-header bg-danger">
            <strong class="me-auto text-light fs-6">error</strong>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> --}}
        </div>
        <div class="toast-body">
            {{session("error_password_wrong")}}
        </div>
    </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" dir="ltr">
            <div class="toast-header bg-danger">
                <strong class="me-auto text-light fs-6">error</strong>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> --}}
            </div>
            <div class="toast-body">
                {{$error}}
            </div>
        </div>
        @endforeach
    @endif
</div>

<div class="container pt-5">
    <h2 class="text-center mb-4">{{__("app.account")}}</h2>
    <div class="row justify-content-start py-5">
        <div class="col-md-3 border-end">
            <ul class="list-group col-12 col-md-11 list-group-flush">
                <a href="/account" class="edit-account list-group-item py-3 posision-relative fs-6">
                    {{__("app.account")}}
                    <span class="position-absolute text-primary top-50 start-100 translate-middle-y" style="margin-right: -1.25em">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
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
            <form method="POST" action="/account/update-password" class="password-edit">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="fs-6 mb-1" for="first_name">{{__("app.old-password")}}<span class="text-danger ms-1">*</span></label>
                        <input type="password" autocomplete="off" class="form-control" name="old_password" id="first_name">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="fs-6 mb-1" for="last_name">{{__("app.password")}}<span class="text-danger ms-1">*</span></label>
                        <input type="password" autocomplete="off" class="form-control" name="password" value="{{old("password")}}" id="last_name">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fs-6 mb-1" for="phone_number">{{__("app.password_confirm")}}<span class="text-danger ms-1">*</span></label>
                        <input type="password" autocomplete="off" class="form-control" name="password_confirmation" value="{{old("password_confirmation")}}" id="phone_number" min="0">
                    </div>
                </div>
                <button type="submit" class="btn essence-btn fs-6 mt-2">{{__("app.save")}}</button>
            </form>
        </div>
    </div>
</div>

@endsection