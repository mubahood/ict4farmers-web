<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('admin.title') }} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @if (!is_null($favicon = Admin::favicon()))
        <link rel="shortcut icon" href="{{ $favicon }}">
    @endif

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page"
    @if (config('admin.login_background_image')) style="background: url({{ config('admin.login_background_image') }}) no-repeat;background-size: cover;" @endif>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ admin_url('/') }}"><b style="color: white;">{{ config('admin.name') }}</b></a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body well">
            <div class="card-header">
                <h4 class="login-box-msg">{{ trans('admin.login') }}</h4><br>

                <form action="{{ admin_url('auth/login') }}" method="post">
                    <div class="form-group has-feedback {!! !$errors->has('phone_number') ?: 'has-error' !!}">

                        @if ($errors->has('phone_number'))
                            @foreach ($errors->get('phone_number') as $message)
                                <label class="control-label" for="inputError"><i
                                        class="fa fa-times-circle-o"></i>{{ $message }}</label><br>
                            @endforeach
                        @endif

                        <label>Phone Number <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Enter your phone number"
                            name="phone_number" value="{{ old('phone_number') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

                        @if ($errors->has('password'))
                            @foreach ($errors->get('password') as $message)
                                <label class="control-label" for="inputError"><i
                                        class="fa fa-times-circle-o"></i>{{ $message }}</label><br>
                            @endforeach
                        @endif


                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" value="{{ old('phone_number') }}" class="form-control"
                            placeholder="Enter your password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <!-- <p><small>Fields marked by * are required</small></p> -->
                    </div>
                    <p>Forget password? <a href="{{ url('register') }}">Reset password</a></p>
                    <div class="row">
                        <div class="col-xs-8">
                            @if (config('admin.auth.remember'))
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="checkbox" name="remember" value="1"
                                            {{ !old('phone_number') || old('remember') ? 'checked' : '' }}>
                                        {{ trans('admin.remember_me') }}
                                    </label>
                                </div>
                            @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                        </div>
                        <!-- /.col -->

                    </div>
                </form>

                <br>
                <div>
                    <p>Already have an account? <a href="{{ url('register') }}">Register</a></p>
                </div>
            </div>
            <!-- /.login-box-body -->

        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>
