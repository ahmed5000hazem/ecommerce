@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container pt-5">
        <div class="row mb-5 justify-content-between">
            <div class="col-md-4">
                <h3>Create Reason</h3>
                <form action="/admin/reason/store" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <input type="text" class="form-control" name="reason" id="reason" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    @foreach ($reasons as $reason)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-10">Reason : {{$reason->reason}}</div>
                                
                                <div class="col-2">
                                    <form action="/admin/reason/{{$reason->id}}/delete" method="post">
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection