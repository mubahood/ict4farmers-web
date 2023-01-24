@extends('metro.layout.layout-auth')

@section('content')
    <form class="form w-100" autocomplete="off" action="{{ url('password/reset') }}" method="POST">
        @csrf

        @include('metro.components.input-text', [
                'attributes' => [
                    'name' => 'token',
                    'type' => 'hidden',
                    'value' => $token,
                    ],
            ])

        <div class="mb-10 text-center">
            <h1 class="fw-100  fs-1">Passowrd reset.</h1>
        </div>
        <div class="fv-row mb-7">
            @include('metro.components.input-text', [
                'label' => 'Email',
                'attributes' => [
                    'name' => 'email',
                    'type' => 'text',
                    'value' => request()->email,
                ],
            ])
        </div>
        <div class="fv-row mb-7">
            @include('metro.components.input-text', [
                'label' => 'Enter enter new password',
                'attributes' => [
                    'name' => 'password',
                    'type' => 'password',
                    'autocomplete' => 'off',
                ],
            ])
        </div>

        <div class="fv-row mb-7">
            @include('metro.components.input-text', [
                'label' => 'Re-Enter enter same password',
                'attributes' => [
                    'name' => 'password_confirmation',
                    'type' => 'password',
                    'autocomplete' => 'off',
                ],
            ])
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary">
                <span class="indicator-label">SUBMIT</span>
            </button>
        </div>
    </form>


    <div class="text-gray-400 fw-bold fs-6 mt-10">
        <a href="{{ url('login') }}" class="link-primary fw-bolder">
            <- Back to login</a>
    </div>
@endsection
