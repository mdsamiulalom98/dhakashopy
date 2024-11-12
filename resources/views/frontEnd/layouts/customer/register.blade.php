@extends('frontEnd.layouts.master')
@section('title','Customer Register')
@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="form-content">
                    <p class="auth-title"> Customer Registration  </p>
                    <form action="{{route('customer.store')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder=" Enter Your Name " required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="phone">  Phone Number </label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone Number " required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <!--<div class="form-group mb-3">-->
                        <!--    <label for="email"> ইমেইল </label>-->
                        <!--    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="ইমেইল">-->
                        <!--    @error('email')-->
                        <!--        <span class="invalid-feedback" role="alert">-->
                        <!--            <strong>{{ $message }}</strong>-->
                        <!--        </span>-->
                        <!--    @enderror-->
                        <!--</div>-->
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="password"> Password </label>
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password " name="password" value="{{ old('password') }}" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <button class="submit-btn">Registration</button>
                         <div class="register-now no-account">
                        <p><i class="fa-solid fa-user"></i> If registered?</p>
                        <a href="{{route('customer.login')}}"><i data-feather="edit-3"></i>Login</a>
                    </div>
                        </div>
                     <!-- col-end -->
                     
                    
                     </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush