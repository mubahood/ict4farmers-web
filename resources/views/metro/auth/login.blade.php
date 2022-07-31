@extends('metro.layout.layout-auth')

@section('content')
    <form class="form w-100" autocomplete="off" 
        action="{{url('login')}}"
        method="POST"
    >
    @csrf
        <div class="mb-10 text-center">
            <h1 class="fw-100  fs-1">Login to your dashboard</h1>
        </div>
 
        <div class="fv-row mb-7">
            @include('metro.components.input-text', [
                'label' => 'Phone Number',
                'attributes' => [
                    'name' => 'phone_number',
                    'type' => 'text',
                    'autocomplete' => 'off',
                ],
            ])
        </div>
        <div class="mb-5 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                @include('metro.components.input-text', [
                    'label' => 'Password',
                    'attributes' => [
                        'name' => 'password',
                        'type' => 'password',
                        'autocomplete' => 'off',
                    ],
                ])
            </div>
        </div>
 
        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary">
                <span class="indicator-label">Login</span>
            </button>
        </div>
    </form>

    
    <div class="text-gray-400 fw-bold fs-6 mt-10">Don't have account?
        <a href="{{ url('register') }}" class="link-primary fw-bolder">Register
            here</a>
    </div>
@endsection
