<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name')}} @yield('title')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/images/logo.png') }}">
        <!-- plugins -->
        <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- page styles -->
        @yield('styles')
    </head>
    <body>
        <div id="wrapper">
            <input type="hidden" id="local" value="{{session()->get('locale', 'en')}}">
            <input type="hidden" id="auth_user" value="{{auth()->user()}}">
            <input type="hidden" id="base_url" value="{{ url()->to('/') }}">

            <!-- include header -->
            @auth
                @include('layouts.partials.header')
            @endauth

            <!-- include sidebar -->
            @auth
                @include('layouts.partials.sidebar')
            @endauth

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <!-- breadcrumb -->
                        @hasSection('breadcrumb')
                            @yield('breadcrumb')
                        @endif

                        <!-- main contect -->
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>

        <div class="modal fade" id="ajax_model" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajax_model_title">Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="ajax_model_content">
                        ...
                    </div>
                    <div id="ajax_model_spinner">
                        <div class="modal-body">
                            <div class="spinner" style="text-align: center;">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

        <script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
      
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src='{{asset("js/common.js")}}' type="text/javascript"></script>
        <script src='{{asset("js/jquery.min.js")}}' type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        
        <script>
            WebFont.load({
                google: {
                    "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
                },
                active: function () {
                    sessionStorage.fonts = true;
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Hide alert message if any
            $('div.alert').not('.alert-important').delay(3000).slideUp(350);
        </script>
        <script>
            $('input:text').on('keypress', function (event) { 
                var regex = new RegExp("^[a-zA-Z0-9 ]");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
