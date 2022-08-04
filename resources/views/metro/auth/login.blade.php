@extends('metro.layout.layout-auth')

@section('content')
    <?php
    $action_url = url('login');
    /* if (isset($_GET['submit_to'])) {
            if ($_GET['submit_to'] == 'admin') {
                $action_url = url('admin/auth/login');
            }
        } */
    $action_url = url('admin/auth/login');
    ?>
    <form class="form w-100" autocomplete="off" action="{{ $action_url }}" method="POST">
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
        <div class=" fv-row" data-kt-password-meter="true">
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
        <p class="mb-5 mb-md-10">Forgot password? <a href="{{ url('reset-password-phone') }}">Reset password</a></p>

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
