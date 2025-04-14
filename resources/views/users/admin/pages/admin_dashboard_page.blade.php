@include('includes.dashboardHeader')

<title>Mfumo wa Parokia | Dashboard ya Admin</title>

<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

@include('includes.notifications_alert')

<!--begin::App Wrapper-->
<div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">

        <!--begin::Container-->
        <div class="container-fluid">

            <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>
            <!--end::Start Navbar Links-->

            <!--begin::End Navbar Links-->
            <ul class="navbar-nav ms-auto">

                <!--begin::Fullscreen Toggle-->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                        <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                        <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                    </a>
                </li>
                <!--end::Fullscreen Toggle-->

                <!--begin::User Menu Dropdown-->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <span class="bg-dark rounded-circle text-light fw-bold d-flex justify-content-center align-items-center"
                                                      style="width: 35px; height: 35px;">
                            {{ Str::limit($user->firstname, 1, '') }}{{ Str::limit($user->lastname, 1, '') }}
                        </span>
                        <span class="d-none d-md-inline mx-2">{{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <!--begin::User Profile Details-->
                        <li class="user-header d-flex align-items-center justify-content-start" style="background-color: black; min-height: 50px !important;">
                            <span class="bg-dark rounded-circle text-light fw-bold d-flex justify-content-center align-items-center"
                                  style="width: 50px; height: 50px;">
                                {{ Str::limit($user->firstname, 1, '') }}{{ Str::limit($user->lastname, 1, '') }}
                            </span>
                            <p class="d-flex flex-column align-items-start text-light mx-2" style="margin-bottom: 10px;">
                                {{ $user->name }}
                                <small style="color: rgba(245,245,245,0.7);">{{ $user->user_type  }}</small>
                            </p>
                        </li>
                        <!--end::User Image-->

                        <!--begin::Menu Footer-->
                        <li class="user-footer bg-black pb-3" style="border-top: 1px solid #cccccc40">
                            <a href="#" class="btn btn-dark btn-flat text-white">
                                <x-heroicon-m-user style="width: 20px; height: 20px;" />
                                Wasifu
                            </a>
                            <a href="{{ route('user.logout') }}" class="btn btn-danger btn-flat float-end text-white" style="background-color: darkred; border: 1px solid darkred;">
                                <x-heroicon-m-arrow-left-start-on-rectangle style="width: 20px; height: 20px;" />
                                Toka Nje
                            </a>
                        </li>
                        <!--end::Menu Footer-->
                    </ul>
                </li>
                <!--end::User Menu Dropdown-->

            </ul>
            <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
    </nav>
    <!--end::Header-->

    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="{{ route('admin.dashboard.page') }}" class="brand-link">

                {{--  <!--begin::Brand Image--> signout
                <img src="{{ asset('assets/AdminLTE-4.0.0-beta3/dist/assets/img/AdminLTELogo.png') }}"
                    alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
                <!--end::Brand Image-->  --}}

                <!--begin::Brand Text-->
                <span class="brand-text fw-bold">ChurchParish</span>
                <!--end::Brand Text-->
            </a>
            <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->

        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
            <nav class="mt-2">

                <!--begin::Sidebar Menu-->
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.page') }}" class="nav-link active">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.view.users.page') }}" class="nav-link">
                            <i class="nav-icon bi bi-person-vcard-fill"></i>
                            <p>
                                Wahusika
                                <span class="nav-badge badge text-bg-success me-2">{{ $users->count()  }}</span>
                            </p>
                        </a>
                    </li>

                    {{-- MCHUNGAJI --}}
                    <li class="nav-item menu-open mt-3">
                        <a href="#" class="nav-link">
                            {{-- <i class=""></i>--}}
                            <p>
                                Muhasibu
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-pin-fill"></i>
                                    <p>
                                        Maudhuria
                                        {{-- <span class="nav-badge badge text-bg-success me-2">{{ $leaders->count() }}</span>--}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- KATIBU --}}
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            {{-- <i class=""></i>--}}
                            <p>
                                Katibu
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.members.page') }}" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-person-fill"></i>
                                    <p>
                                        Washirika
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.leaders.page') }}" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-briefcase-fill"></i>
                                    <p>
                                        Viongozi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.leader.positions.page') }}" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-funnel-fill"></i>
                                    <p>
                                        Nafasi za Viongozi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.groups.page') }}" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-people-fill"></i>
                                    <p>
                                        Vikundi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-megaphone-fill"></i>
                                    <p>
                                        Matangazo
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- MCHUNGAJI --}}
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            {{-- <i class=""></i>--}}
                            <p>
                                Mchungaji
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <span class="mx-3"></span>
                                    <i class="bi bi-chat-dots-fill"></i>
                                    <p>
                                        Meseji
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>




                    <li class="nav-item">
                        <a href="{{ route('admin.view.users.page') }}" class="nav-link">
                            <span class="bg-dark rounded-circle text-light fw-bold d-flex justify-content-center align-items-center"
                                  style="width: 25px; height: 25px; font-size: 10px;">
                                {{ Str::limit($user->firstname, 1, '') }}{{ Str::limit($user->lastname, 1, '') }}
                            </span>
                            <p>
                                 {{ $user->name ?? "Wasifu" }}
                            </p>
                        </a>
                    </li>


                </ul>
                <!--end::Sidebar Menu-->
            </nav>
        </div>
        <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->


    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->


        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">

                    <!--begin::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>{{ $members->count() }}</h3>
                                <p>Washirika</p>
                            </div>
                            <x-heroicon-m-user class="small-box-icon" fill="currentColor"
                                                     viewBox="0 0 20 20"/>
                            <a href="{{ route('admin.members.page') }}"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>{{ 0 }}</h3>
                                <p>Mahudhurio na Sadaka</p>
                            </div>
                            <x-heroicon-m-currency-dollar class="small-box-icon" fill="currentColor"
                                                         viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.view.users.page') }}"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>{{ 0 }}</h3>
                                <p>Ahadi</p>
                            </div>
                            <x-heroicon-m-banknotes class="small-box-icon" fill="currentColor"
                                                          viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.view.users.page') }}"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->


                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-secondary">
                            <div class="inner">
                                <h3>{{ $users->count() }}</h3>
                                <p>Wahusika</p>
                            </div>
                            <x-heroicon-m-identification class="small-box-icon" fill="currentColor"
                                                         viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.view.users.page') }}"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>{{ $leaders->count() }}</h3>
                                <p>Viongozi</p>
                            </div>
                            <x-heroicon-m-briefcase class="small-box-icon" fill="currentColor"
                                                         viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.leaders.page') }}"
                               class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-dark">
                            <div class="inner">
                                <h3>{{ $leaderPositions->count() }}</h3>
                                <p>Nafasi za Viongozi</p>
                            </div>
                            <x-heroicon-m-funnel class="small-box-icon" fill="currentColor"
                                                    viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.leader.positions.page') }}"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->


                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-info">
                            <div class="inner">
                                <h3>{{ $groups->count() }}</h3>
                                <p>Vikundi</p>
                            </div>
                            <x-heroicon-m-user-group class="small-box-icon" fill="currentColor"
                                                 viewBox="0 0 22 22"/>
                            <a href="{{ route('admin.groups.page') }}"
                               class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box bg-black">
                            <div class="inner text-light">
                                <h3>{{ $announcements->count() }}</h3>
                                <p>Matangazo</p>
                            </div>
                            <x-heroicon-m-megaphone class="small-box-icon" style="color: #9eeaf920;" fill="currentColor"
                                                 viewBox="0 0 22 22"/>
                            <a href="#"
                               class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover" style="border-top: 1px solid #ccc2a420;">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->

                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row">


                </div>
                <!-- /.row (main row) -->

            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->

    <!--begin::Footer-->
    <footer class="app-footer">
        <!--begin::Copyright-->
        <strong>
            Copyright &copy; 2014-2024&nbsp;
            <a href="{{ route('admin.dashboard.page') }}" class="text-decoration-none">ChurchParish</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
    </footer>
    <!--end::Footer-->

</div>
<!--end::App Wrapper-->


@include('includes.dashboardFooter')
