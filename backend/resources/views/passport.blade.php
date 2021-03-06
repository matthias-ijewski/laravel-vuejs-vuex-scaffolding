@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <passport-clients></passport-clients>
        </div>
        <div class="col-md-8 pt-3">
            <passport-authorized-clients></passport-authorized-clients>
        </div>
        <div class="col-md-8 pt-3">
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
</div>
@endsection
