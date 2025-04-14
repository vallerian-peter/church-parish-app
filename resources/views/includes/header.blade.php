<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Admin | Dashboard" />
    <meta name="author" content="VallerianMchau" />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">--}}
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
{{--    <script src="//unpkg.com/alpinejs" defer></script>--}}
</head>
<!--end::Head-->

<style>
    section.landingpage {
        background-image: url('assets/images/cathedral-church.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>
