@extends('layouts.main')

@section('title')
    AL BORJ ERP | Login
@endsection

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-md-8 banner-sec">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="2000">
                        <img src="https://redmindtechnologies.com/alborj_new_desgins/login_template-ranjit/diversity-construction-e1584456867559.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p> --}}
                        </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="https://redmindtechnologies.com/alborj_new_desgins/login_template-ranjit/construction-concept-illustration_114360-2558.avif" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5>Second slide label</h5>
                            <p>Some representative placeholder content for the second slide.</p> --}}
                        </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="https://redmindtechnologies.com/alborj_new_desgins/login_template-ranjit/1.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p> --}}
                        </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="https://redmindtechnologies.com/alborj_new_desgins/login_template-ranjit/Civil-Engineering-Consultancy2.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                               {{-- <h5>Fourth slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>--}}
                            </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                            <img src="https://redmindtechnologies.com/alborj_new_desgins/login_template-ranjit/Working Group Meeting banner image_1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                               {{-- <h5>Fourth slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>--}}
                            </div>
                            </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-4 login-sec">
                <center><img src="{{ asset('images/al borj.jpeg') }}" style="width: 100%" height="100%"/>
                    <h2 style="color: #319DD9" class="mt-4">Alborj ERP</h2></center>
                {{-- <h2 class="text-center">Alborj ERP Login</h2> --}}
                <form class="login-form" action="{{ url('/checklogin') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="Email" class="text-uppercase text-bold">Email id<a style="text-decoration: none;color:red">*</a></label>
                        <input id="email" type="email" value="{{ old('email') }}" name="email" placeholder="Enter email" class="form-control" />
                        <p style="color: red" id="error_email">{{ $errors->first('email') }}</p>
                    </div>
                    <div class="form-group mt-4">
                        <label for="password" class="text-uppercase text-bold">Password<a style="text-decoration: none;color:red">*</a></label>
                        <input id="password" type="password" name="password" placeholder="Enter password" class="form-control" />
                        <p style="color: red" id="error_password">{{ $errors->first('password') }}</p>
                    </div>
                    @if ($errors->has('loginError'))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('loginError') }}
                    </div>
                    @endif
                    <div class="form-check d-flex justify-content-center me-4">
                        <center>
                            <button type="submit" class="btn btn-login float-right mt-4">
                                {{ __('Login') }}
                            </button>
                        <center>
                    </div>
                </form>


            </div>
        </div>
    </div>
  </section>
</body>

</html>
@endsection