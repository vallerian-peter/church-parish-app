@include('includes.header')

<title>Mfumo wa Parokia | Fomu ya Kuingia</title>

<body class="bg-dark" style="height: 100vh;">

    @include('includes.notifications_alert')

    <section>

        <div class="nav flex items-center justify-start py-3">
            <a href="/" class="nav-link text-secondary d-flex items-center">
                <x-heroicon-o-arrow-left class="text-secondary mx-2" style="height: 15px; width: 15px;" /> Nyumbani
            </a>
        </div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-light bg-opacity-10 backdrop-blur rounded shadow p-4 border-0"
                        style="backdrop-filter: blur(10px);">
                        <h3 class="text-white mb-4 text-center">Fomu ya Kuingia</h3>
                        <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()"
                            actions="{{ route('userPostLogin') }}" method="POST">
                            @csrf
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Barua Pepe</label>
                                <input type="email"
                                    class="form-control bg-dark text-white border-secondary placeholder-gray"
                                    id="email" name="email" placeholder="Ingiza barua pepe.."
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-error fw-1">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3" x-data="{ show: false }">
                                <label for="password" class="form-label text-white">Neno Siri</label>
                                <div class="input-group">
                                    <input :type="show ? 'text' : 'password'" name="password"
                                        class="form-control bg-dark text-white border-secondary placeholder-gray border-end-0"
                                        id="password" placeholder="Ingiza neno siri.." value="{{ old('password') }}">
                                    <span class="input-group-text bg-dark text-white border-secondary border-start-0"
                                        style="cursor: pointer;" @click="show = !show">
                                        <template x-if="!show">
                                            <i class="bi bi-eye text-white"></i>
                                        </template>
                                        <template x-if="show">
                                            <i class="bi bi-eye-slash text-white"></i>
                                        </template>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="text-error fw-1">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>



                            {{--  <!-- File Upload -->
                        <div class="mb-4">
                            <label for="file" class="form-label text-white">Upload File</label>
                            <input class="form-control bg-dark text-white border-secondary" type="file"
                                id="file">
                        </div>
                        --}}

                            <!-- Submit Button -->
                            <div class="d-grid pt-3 pb-4">
                                <button type="submit"
                                    class="btn btn-primary d-flex align-items-center justify-content-center gap-2 py-2"
                                    :disabled="loading">
                                    <!-- Spinner shown only when loading -->
                                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    <span>Ingia Sasa</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Custom gray placeholder style */
        .placeholder-gray::placeholder {
            color: #b0b0b0 !important;
            opacity: 1;
        }

        .text-error {
            color: #ff5733 !important;
        }
    </style>



    @include('includes.footer')
