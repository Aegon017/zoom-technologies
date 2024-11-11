<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
    <title>
        {{ $metaTitle ??
            'Online Training in India | Hyderabad, Vijayawada, Surat | CCNA, CCNP, CCIE, MCSE, MCSA,
                                                                                                                                                                                                                                                                                                                Ethical Hacking, Cybersecurity, Cyber Security, Linux, VMware, Checkpoint, RHCE, Azure, AWS, Microsoft Training' }}
    </title>
    @if (isset($metaKeywords))
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    @if (isset($metaDescription))
        <meta name="description" content="{{ $metaDescription }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="copyright" content="www.zoomgroup.com">
    <meta name="google-site-verification" content="hlz1iv2l6Ywd7fdmJwhAimAVWwld2KR0oACgbfUUVfA" />
    <meta name="alexaVerifyID" content="qpE55hFRXYVm5odecM_WG_il_zk">
    <meta name="ROBOTS" content="INDEX, FOLLOW" />
    <meta name="ROBOTS" content="ALL" />
    <meta name="googlebot" content="index,follow,archive" />
    <meta name="msnbot" content="index,follow,archive" />
    <meta name="Slurp" content="index,follow,archive" />
    <meta name="author" content="ZOOM Technologies" />
    <meta name="publisher" content="ZOOM Technologies" />
    <meta name="owner" content="ZOOM Technologies" />
    <meta http-equiv="content-language" content="English" />
    <meta name="doc-type" content="Web Page" />
    <meta http-equiv="reply-to" content="priya@zoomgroup.com" />
    <meta name="doc-rights" content="Copywritten Work" />
    <meta name="rating" content="All" />
    <meta name="distribution" content="Global" />
    <meta name="document-type" content="Public" />
    <meta name="classification" content="Network and Security Solutions" />
    <meta name="abstract"
        content="Zoom Technologies provides MCITP Training, Online CCIE Training India, Online Ethical Hacking Training India, Online Cybersecurity Training India, Online Cyber Security Training India, Online CCNP Training India, Online MCSE Training India, Online CCNA Training India, Online Linux Training India" />
    <meta name="Address" content="http://www.zoomgroup.com" />
    <meta name="revisit-after" content="2 days" />
    <meta name="DC.title" content="ZOOM Technologies" />
    <meta name="geo.region" content="IN-AP" />
    <meta name="geo.placename" content="Hyderabad" />
    <meta name="geo.position" content="17.41449;78.430262" />
    <meta name="ICBM" content="17.41449, 78.430262" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer-theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    @if (isset($localSchema))
        <script type="application/ld+json">{{ $localSchema }}</script>
    @endif

    @if (isset($organizationSchema))
        <script type="application/ld+json">{{ $organizationSchema }}</script>
    @endif


    @livewireStyles
</head>

<body class="zt-home">
    <x-preloader />
    <x-scroll-up />
    <x-partials.header />
    {{ $slot }}
    <x-partials.footer />
    <x-sticky-contact />
    @livewireScripts
    <script src="{{ asset('frontend/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/odometer.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-one-page-nav.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
</body>

</html>
