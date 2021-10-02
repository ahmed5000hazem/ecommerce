@extends('layouts.app')
@section('content')
@include("includes.shop.header")
<div class="container pt-5">
    <div class="row mt-5 justify-content-center">
        <div class="alert text-center alert-success" role="alert">
            <div class="row justify-content-center">
                <div class="col-6">
                    <h4 class="alert-heading">{{__("app.order-placed-successfully")}}</h4>
                    <p class="fw-bold mt-3">
                        {{__("app.order-placed-info")}}
                    </p>
                    <hr>
                    <p class="text-danger">
                        {{__("app.order-slogan")}} 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                        </svg>
                    </p>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection