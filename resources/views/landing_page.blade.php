@include('includes.header')

<title>Mfumo wa Parokia | Nyumbani</title>

<body>

<section class="landingpage relative w-full h-screen">
    <!-- Background image -->
    <div class="absolute inset-0 bg-cover bg-center z-0">
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/80 z-10"></div>

    <!-- Content -->
    <div class="relative z-20 flex items-center justify-center h-full">

        <div class="text-center text-white px-4">
            {{--  <h1 class="display-1 font-bold">Church Parish System</h1>  --}}
            <h1 class="display-1 font-bold">
                Mfumo wa Parokia ya Kanisa
            </h1>
            <p class="py-3 text-lg max-w-2xl mx-auto">
                Mfumo ambao hushughulikia shughuli zote za parokia na pia rekodi za michango kwa urahisi wa usimamizi na
                uchambuzi
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary">
                <div class="inline-block items-center text-white font-bold py-1 px-2 rounded">
                    Anza Sasa <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>

@include('includes.footer')
