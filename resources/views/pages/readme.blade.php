@extends('layouts.app')
@section('title','Readme')

@section('content')
<h1>Notes:</h1>
<ol>
    <li><p>The SMS gateway used in this project is <a href="https://www.nexmo.com">"Nexmo"</a>.</p></li>
    <li><p>Tested all the Apis (Login, Register, Details, Verify) with "Postman", find below screenshots of the results.</p></li>
    <li><p>Created a separate login system for "Admins", with separate guard, routes and views.</p></li>
    <li><p>Built the users CRUD at the admin panel with "DataTables", and "Ajax" requests.</p></li>
</ol>

    <h1>Screenshots:</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <p>Register</p>
                <img src="{{asset('img/postman-register.jpg')}}" alt="register-api" height="250px" width="250px">
            </div>
            <div class="col-md-4">
                <p>Login</p>
                <img src="{{asset('img/postman-login.jpg')}}" alt="login-api" height="250px" width="250px">
            </div>
            <div class="col-md-4">
                <p>Details</p>
                <img src="{{asset('img/postman-details.jpg')}}" alt="details-api" height="250px" width="250px">
            </div>
            <div class="col-md-4">
                <p>Verify</p>
                <img src="{{asset('img/postman-verify.jpg')}}" alt="verify-api" height="250px" width="250px">
            </div>
            <div class="col-md-4">
                <p>Nexmo account</p>
                <img src="{{asset('img/nexmo.jpg')}}" alt="nexmo" height="250px" width="250px">
            </div>
            <div class="col-md-4">
                <p>SMS Screenshot</p>
                <img src="{{asset('img/sms.jpg')}}" alt="sms" height="250px" width="250px">
            </div>
        </div>

    </div>

    <div style="height: 50px"></div>
@endsection
