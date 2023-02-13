<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.app_slogan') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="{{ config('app.app_slogan') }}" />
    <meta name="keywords" content="{{ config('app.app_slogan') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="ICT4Farmers" />
    <meta property="og:url" content="<?= url('assets/images/favicon.png') ?>" />
    <meta property="og:site_name" content="{{ config('app.app_slogan') }}" />
    <link rel="canonical" href="<?= url('/') ?>" />
    <link rel="shortcut icon" href="<?= url('assets/images/favicon.png') ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" async />
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" async />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PNLCGK3S63"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', 'G-PNLCGK3S63');
    </script>


    @yield('header')

    <style>
        .my-active-menu {
            border-bottom: var(--bs-blue) 5px solid;
            background-color: rgb(235, 235, 235);
        }

        .menu-link {
            border-radius: 0px !important;
        }

        .product:hover {
            margin: 2px;
            -webkit-box-shadow: 0px 0px 6px 2px #A6A6A6;
            box-shadow: 0px 0px 6px 2px #A6A6A6;
        }

        img.lazy {
            /* width: 700px;
            height: 467px;
            display: block;
 
            background-image: url('images/loading.gif');
            background-repeat: no-repeat;
            background-position: 50% 50%; */
        }
    </style>
</head>


<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative py-5 py-md-20"
                style="    background-size:     cover;                      /* <------ */
                background-repeat:   no-repeat;
                background-position: center center; background-color: #baf0d4;background-image: url({{ url('assets/images/digital-value-chain-for-small-holder-farmers.png') }})">

            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid ">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">

                        <div class="row">
                            <div class="col-12">
                                <center>
                                    <a href="{{ url("market") }}" class="py-9 mb-5">
                                        <img alt="Logo" src="assets/images/logo.png" class="h-90px" />
                                    </a>
                                </center>

                                <h1 class="fw-bolder fs-2qx mb-0 text-center pb-0 mt-5 mb-2 text-uppercase "
                                    style="color: #145a32;">ICT4farmers</h1>

                                <i>
                                    <p class="fw-light  text-center mt-1 pt-0" style="color: #636363; font-size:16px;">
                                        "Making ICT work for farmers."
                                    </p>
                                </i>


                                <div class="separator my-10 separator-dashed border-1 border-primary  "></div>


                                @if (session('success_message'))
                                    <div class="alert alert-success">{{ session('success_message')}}</div>
                                @endif

                            </div>
                        </div>

                        <!--begin::Form-->
                        @yield('content')
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                    <!--begin::Links-->
                    <div class="d-flex flex-center fw-bold fs-6">
                        <a href="javascript:;" class="text-muted text-hover-primary px-2" target="_blank">About</a>
                        <a href="javascript:;" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
                        <a href="javascript:;" class="text-muted text-hover-primary px-2"
                            target="_blank">8Technologies</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>


<script src="{{ url('/') }}/assets/js/scripts.bundle.js"></script>
<script>
    $(function() {
        $('.lazy').Lazy({
            // your configuration goes here
            scrollDirection: 'vertical',
            placeholder: '{{ url('no_image.jpg') }}',
            effect: 'fadeIn',
            visibleOnly: true,
            onError: function(element) {
                console.log('error loading ' + element.data('src'));
            }
        });
    });
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/62ee7a3437898912e961972f/1g9poqoh3';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
@yield('footer')
@yield('footer-2')

</html>
