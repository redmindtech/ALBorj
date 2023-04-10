@extends('layouts.main')

@section('title')
AL BORJ ERP| Login
@endsection

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="
viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            background-image: url('images/a.jpg');
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row g-3 mt-5">
            <div class="col-md-4 col-lg-4 col-sm-12"></div>
            <div class="col-md-4 col-lg-4 col-sm-12">
                <form action="{{ url('/main/checklogin') }}" class="py-5 px-4 mt-5 shadow-lg bg-white" method="post">
                    @csrf
                    <center><img src="{{ asset('images/al borj.jpeg') }}" style="width: 100%" height="100%"/>
                    <h2 style="color: #173aeb">ERP</h2></center>

                <!--<center><h3 class="h3 my-3 text-primary">SASHTI REAL ESTATE</h3></center>-->
                <div class="form-floating mb-3 mt-4">
                    <input id="email" type="email"
                                    value="{{old('email')}}"
                                        name="email" placeholder="Enter email" class="form-control"/>
                    <label>Email Id <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="password" type="password"
                        name="password"  placeholder="Enter password" class="form-control"/>
                    <label for="">Password <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-group">
                        <center><button type="submit" class="btn btn-primary btn-lg active">
                            {{ __('Login') }}
                        </button><center>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12"></div>
        </div>
    </div>
    </body>
</html>
@endsection
