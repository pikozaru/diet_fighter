<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ダイエットファイター') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/diet_fiter.css')}}" rel="stylesheet">
    
    <!-- Icon -->
    <script src="https://kit.fontawesome.com/e41605fcb9.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">
        @component('components.ranking_header')
        @endcomponent
        
        <div id="content-box">
            <main id="main" class="pt-5 pb-4" style="margin-top:100px;">
                @yield('ranking_content')
            </main>
            
            @component('components.footer')
            @endcomponent
        </div>
    </div>

    <script type="text/javascript">
        function adjustFooter() {
            let m = document.getElementById('main');
            let h = document.getElementById('header');
            let f = document.getElementById('footer');

            if (m.getBoundingClientRect().height + h.getBoundingClientRect().height + f.getBoundingClientRect().height > window.innerHeight) {
                console.log("over");
                if (f.classList.contains('fixed-bottom')) {
                    f.classList.remove('fixed-bottom');
                }
            } else {
                console.log("under");
                if (!f.classList.contains('fixed-bottom')) {
                    f.classList.add('fixed-bottom');
                }
            }
        }

        adjustFooter();
        window.onresize = adjustFooter;
    </script>
</body>
</html>
