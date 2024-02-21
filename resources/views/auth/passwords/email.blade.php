@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form class="flex" action="{{ route('password.email') }}" method="post">
        @csrf
        <div
            class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                Reset Password
            </h2>
            <div class="intro-x mt-8">
                <div>
                    <input type="text" class="intro-x login__input form-control py-3 px-4 block"
                        value="{{ old('email') }}" name="email" placeholder="Email">

                    @error('email')
                        <span class="text-danger mt-2 inline-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="intro-x flex mt-10 text-center xl:text-left">
                <button type="submit" class="btn btn-primary py-3 px-4 w-full align-top">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>

        </div>
    </form>
    {{-- <div class="w-full">
        <div class="h-full flex items-center">


            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
@endsection
