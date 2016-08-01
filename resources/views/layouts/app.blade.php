<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="token" id="token" value="{{ csrf_token() }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Health Page</title>

    <!-- Bootstrap CSS -->
    {!! Html::style('/loading/vue-loading-bar.css')!!}

    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"--}}
          {{--integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <!-- Vue Table Style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">--}}
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

    <style>
        /* Move down content because we have a fixed navbar that is 50px tall */
        body {
            background-color: honeydew;
            padding-top: 50px;
            padding-bottom: 20px;
            overflow-y: scroll;
        }
        .success-transition {
            transition: all .5s ease-in-out;
        }
        .success-enter, .success-leave {
            opacity: 0;
        }
        ul.dropdown-menu li {
            margin-left: 20px;
        }
        .vuetable th.sortable:hover {
            color: #2185d0;
            cursor: pointer;
        }
        .vuetable-actions {
            width: 11%;
            padding: 12px 0px;
            text-align: center;
        }
        .vuetable-actions > button {
            padding: 3px 6px;
            margin-right: 4px;
        }
        .vuetable-pagination {
            margin: 0;
        }
        .vuetable-pagination .btn {
            margin: 2px;
        }
        .vuetable-pagination-info {
            float: left;
            margin-top: auto;
            margin-bottom: auto;
        }
        ul.pagination {
            margin: 0px;
        }
        .vuetable-pagination-component {
            float: right;
        }
        .vuetable-pagination-component li a {
            cursor: pointer;
        }
        [v-cloak] {
            display: none;
        }
        .highlight {
            background-color: yellow;
        }
        .vuetable-detail-row {
            height: 200px;
        }
        .detail-row {
            margin-left: 40px;
        }
        .expand-transition {
            transition: all .5s ease;
        }
        .expand-enter, .expand-leave {
            height: 0;
            opacity: 0;
        }

        /* Loading Animation: */
        .vuetable-wrapper {
            opacity: 1;
            position: relative;
            filter: alpha(opacity=100); /* IE8 and earlier */
        }
        .vuetable-wrapper.loading {
            opacity:0.4;
            transition: opacity .3s ease-in-out;
            -moz-transition: opacity .3s ease-in-out;
            -webkit-transition: opacity .3s ease-in-out;
        }
        .vuetable-wrapper.loading:after {
            position: absolute;
            content: '';
            top: 40%;
            left: 50%;
            margin: -30px 0 0 -30px;
            border-radius: 100%;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            border: 4px solid #000;
            height: 60px;
            width: 60px;
            background: transparent !important;
            display: inline-block;
            -webkit-animation: pulse 1s 0s ease-in-out infinite;
            animation: pulse 1s 0s ease-in-out infinite;
        }
        @keyframes pulse {
            0% {
                -webkit-transform: scale(0.6);
                transform: scale(0.6); }
            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
                border-width: 12px; }
            100% {
                -webkit-transform: scale(0.6);
                transform: scale(0.6); }
        }
    </style>

</head>
<body>
<loading-bar :progress.sync="progress" :direction="direction ? 'left' : 'right'" :error.sync="error"></loading-bar>
<div class="main">
    <h3 align="center">Health Data Center</h3>
</div>


<div class="container">
    @yield('content')
</div>

{{--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>--}}


{!! Html::script('/js/vue.min.js')	!!}
{!! Html::script('/js/vue-resource.js')	!!}
{!! Html::script('/loading/vue-loading-bar.min.js')!!}
<!-- Vue Table Script -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment-with-locales.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.min.js"></script>
<script src="{{ asset('js/vue-table.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="http://code.jquery.com/jquery.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

@stack('scripts')
<script>
    new Vue({
        el: 'body',
        data: function () {
            return {
                progress: 0,
                status: "doesn't start yet",
                error: false,
                direction: false
            };
        },
        methods: {
            progressTo: function (val) {
                this.progress = val;
            },
            setToError: function (bol) {
                this.error = bol;
                this.status = "Error";
            },
            changeDirection: function (direction) {
                if (this.progress > 0) {
                    this.progress = 100;
                }
                this.direction = !this.direction;
            }
        },
        events: {
            /**
             *    Global Loading Callback Event
             *
             *    @event-name loading-bar:{event-name}
             */
            // Loading Bar on started
            'loading-bar:started': function () {
                console.log('started');
                this.status = "started";
            },
            // Loading Bar on loading
            'loading-bar:loading': function () {
                console.log('loading');
                this.status = "loading";
            },
            // Loading Bar on loaded
            'loading-bar:loaded': function () {
                console.log('loaded');
                this.status = "loaded";
            },
            // Loading Bar on error
            'loading-bar:error': function () {
                console.log('error');
                this.status = "error";
            },
        },
        ready: function () {
            var self = this;
            self.progress = 10;
            for (var i = 0; i < 30; i++) {
                if (i > 20 && i < 29) {
                    setTimeout(function () {
                        self.progress += 5;
                    }, 50 * i);
                } else {
                    setTimeout(function () {
                        self.progress++;
                    }, 10 * i);
                }
            }
            setTimeout(function () {
                self.progress = 100;
            }, 1500);
        }
    });

</script>

</body>
</html>