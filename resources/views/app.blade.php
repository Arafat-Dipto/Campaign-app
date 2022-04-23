@if(request()->is('backend') || request()->is('backend/*'))

    <!DOCTYPE html>
    <html class="h-full bg-gray-200">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link href="{{ mix('css/backend/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/backend/manifest.js') }}" defer></script>
        <script src="{{ mix('js/backend/vendor.js') }}" defer></script>
        <script src="{{ mix('js/backend/app.js') }}" defer></script>

        <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/Logo.svg">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/Logo.svg">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/Logo.svg">
        {{-- <link rel="manifest" href="/assets/favicon/site.webmanifest"> --}}

        @routes('backend')

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-XXXXXX');
        </script> 
    </head>

    <body class="font-sans leading-none text-gray-800 antialiased">

        @inertia

    </body>

    </html>
@else
<!DOCTYPE html>
    <html >

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <meta name="og:title" content="Ocean Life" />
        <meta name="og:url" content="{{request()->url()}}" />
	    <meta name="og:decription" content="Welcome to Ocean Life a professional busainess and consulting agency." />
	    <meta name="og:image" content="{{ asset('/assets/images/Logo.svg')}}" />

        <link href="{{ mix('css/frontend/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/frontend/manifest.js') }}" defer></script>
        <script src="{{ mix('js/frontend/vendor.js') }}" defer></script>
        <script src="{{ mix('js/frontend/app.js') }}" defer></script>

        <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/Logo.svg">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/Logo.svg">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/Logo.svg">
        {{-- <link rel="manifest" href="/assets/favicon/site.webmanifest"> --}}

        @routes('frontend')

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-XXXXXX');
        </script>
    </head>

    <body class="font-sans leading-none text-gray-800 antialiased">

        @inertia

    </body>

    </html>
@endif
