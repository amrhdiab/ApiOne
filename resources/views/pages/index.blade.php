@extends('layouts.app')
@section('title','Home')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome</h1>
        <p>Login Api, Register Api, Details Api, and Admin dashboard </br>with full CRUD that controls the users
            data.</p>
        <p>
            @auth('admin')
            <a href="{{route('admin.dashboard')}}" class="btn btn-primary btn-lg" role="button">Dashboard</a>
            @else
            <a href="{{route('admin.login')}}" class="btn btn-primary btn-lg" role="button">Login</a>
            @endauth
                <a href="{{route('readme')}}" class="btn btn-success btn-lg" role="button">Read Me</a>
        </p>
    </div>
@endsection
