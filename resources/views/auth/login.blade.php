@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <form class="flex" action="{{ route('login') }}" method="post">
        @csrf
        <div
            class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                Sign In
            </h2>
            <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                account.
            </div>
            <div class="intro-x mt-8">
                <div>
                    <input type="text" class="intro-x login__input form-control py-3 px-4 block" value="{{ old('email') }}"
                        name="email" placeholder="Email">

                    @error('email')
                        <span class="text-danger mt-2 inline-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div>
                    <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="password"
                        placeholder="Password">

                    @error('password')
                        <span class="text-danger mt-2 inline-block" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
           
            <div class="intro-x flex justify-between items-center mt-4">
                <div class="text-gray-700 dark:text-gray-600 text-xs sm:text-sm">
                    <input type="checkbox" name="remember_me" value="1" class="input border mr-2" id="remember-me">
                    <label class="cursor-pointer select-none" for="remember-me">Keep me login</label>
                </div>
            </div>
            <div class="intro-x flex mt-10 text-center xl:text-left">
                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                    Sign In
                </button>
            </div>

        </div>
    </form>
@endsection
