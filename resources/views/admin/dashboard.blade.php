@extends('admin.layouts.app')
@section('title','Dashboard')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="jumbotron text-center">
                <h3>Welcome</h3>
                <h1>{{Auth::guard('admin')->user()->name}}</h1>
            </div>

        </div>
    </div>

@endsection
