<div class="container">
    <style>
        .my-dropbtn.dropdown-toggle::after {
            display: none !important;
        }

        /* Prevent any color or shadow change on focus */
        .my-topbar .input-group:focus-within {
            box-shadow: none; /* No box-shadow on focus */
            border-color: #ccc; /* Keep the grey border color */
        }

        /* Prevent form-control focus styles */
        .my-topbar .input-group .form-control:focus {
            box-shadow: none; /* Remove default input focus box-shadow */
            border-color: #ccc !important; /* Keep the grey border color */
            outline: none; /* Remove the default focus outline */
        }

        /* Input group text */
        .my-topbar .input-group .input-group-text {
            border-right: 0;
            background-color: transparent;
            border-radius: 0.375rem; /* Ensure matching border-radius */
        }

        /* Form control text */
        .my-topbar .input-group .form-control {
            border-left: 0;
            border-radius: 0.375rem; /* Ensure matching border-radius */
            border-color: #ccc; /* Set initial grey border color */
        }
    </style>

    <div class="row">
        <div class="my-topbar py-3 container-fluid">
            <div class="row align-items-center g-3 justify-content-between">

                <!-- Per page & Delete on md+ -->
                <div class="col-12 col-md-auto d-flex align-items-center">
                    <!-- Hidden on small screens -->
                    <div class="me-2 d-none d-md-block">Kwa Kurasa:</div>

                    <!-- Always visible select -->
                    <select class="form-select border border-secondary me-2" wire:model.live="perPage" style="width: 80px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    @if(count($selectedUsers) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal" data-bs-target="#deleteSelectedUserModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedUsers) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal" data-bs-target="#deleteSelectedUserModal">
                            <i class="bi bi-trash text-light"></i> Futa
                        </button>
                    @endif
                </div>

                <!-- Right side: Search + Dropdown -->
                <div class="col-12 col-md d-flex justify-content-between justify-content-md-end align-items-center">

                    <!-- Search bar -->
                    <div class="flex-grow-1 me-2">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent">
                                <i class="bi bi-search"></i>
                            </span>
                            <input wire:model.live="search" type="search" class="form-control border-start-0" placeholder="Tafuta hapa..">
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <div class="dropdown">
                        <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-dark"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">

                            <!-- Only show Futa Zote inside dropdown on sm -->
                            @if(count($selectedUsers) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteSelectedUserModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedUsers) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteSelectedUserModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a wire:click="exportExcel" class="dropdown-item text-success" style="cursor: pointer;">
                                    <i class="bi bi-file-earmark-excel-fill me-1"></i> Hamisha Kwenda CSV
                                </a>
                            </li>
                            <li>
                                <a wire:click="generatePdf" class="dropdown-item text-danger" style="cursor: pointer;">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Hamisha Kwenda PDF
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

        <table wire:loading.class="opacity-25" class="table table-hover w-100 myUsersTable" style="width: 100%;" cellspacing="0" width="100%">
            <thead class="table-secondary text-dark font-semibold">
            <tr class="py-2">
                <th>
                    <input wire:model="isSelectedAll" wire:click="toggleSelectedAll" type="checkbox" id="bulk-select" value="select-all-">
                </th>
                <th>#</th>
                <th>Jina Kamili</th>
                <th>Barua Pepe</th>
                <th>Simu</th>
                <th>Aina ya Mhusika</th>
                <th>Tarehe ya Kuundwa</th>
                <th>Vitendo</th>
            </tr>
            </thead>
            <tbody>
            @php
                $id = $users->firstItem();
            @endphp
            @forelse($users as $user)
                <tr class="py-2" wire:key="user-{{ $user->id }}">
                    <td>
                        <input wire:model.live="selectedUsers" type="checkbox" id="bulk-select" value="{{ $user->id }}">
                    </td>
                    <td>{{ $id++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ Str::ucfirst($user->user_type) }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1000;">
                                <li>
                                    <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}" style="cursor: pointer;" >
                                        <i class="bi bi-eye-fill me-1"></i> Tazama
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" style="cursor: pointer;">
                                        <i class="bi bi-pen-fill me-1"></i> Hariri
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                        <i class="bi bi-trash-fill me-1"></i> Futa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="d-flex align-items-center justify-content-center py-3">
                            <i class="bi bi-inbox fs-2 text-muted"></i>
                            <span class="text-muted mx-3">Hakuna majibu ya '{{ $search }}' </span>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>


    @if($users->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $users->currentPage() }} ya {{ $users->lastPage() }} | Jumla ya Wahusika: {{ $users->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $users->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif

    </div>

    <!-- Modal - ADMIN USER VIEW -->
    @foreach($users as $user)
        <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModal{{ $user->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewUserModal{{ $user->id }}Label">Tazama Mhusika</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                               <div class="mb-3">
                                   <label for="firstname" class="form-label">Jina la Kwanza</label>
                                   <input type="text" id="firstname" class="form-control fw-bold" value="{{ $user->firstname }}">
                               </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Jina la Mwisho</label>
                                    <input type="text" id="lastname" class="form-control fw-bold" value="{{ $user->lastname }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Barua Pepe</label>
                                <input type="text"  value="{{ $user->email }}" id="email" class="form-control fw-bold" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <div class="mb-3">
                                   <label for="phone" class="form-label">Namba ya Simu</label>
                                   <input class="form-control fw-bold" value="{{ Str::title($user->phone) }}" readonly>
                               </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_type" class="form-label">Aina ya Mhusika</label>
                                    <input class="form-control fw-bold" value="{{ Str::title($user->user_type) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tarehe ya Kuundwa</label>
                            <input type="text"  value="{{ $user->created_at }}" class="form-control fw-bold" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal - ADMIN USER EDIT -->
    @foreach($users as $user)
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModal{{ $user->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.user') }}" method="POST" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addUserModalLabel">Hariri Mhusika</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="{{ $user->id }}" name="id" hidden>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Jina la Kwanza</label>
                                        <input type="text" id="firstname" value="{{ old('firstname', $user->firstname) }}" class="form-control" placeholder="Ingiza Jina la Kwanza" name="firstname">
                                        @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Jina la Mwisho</label>
                                        <input type="text" id="lastname" value="{{ old('lastname', $user->lastname) }}" class="form-control" placeholder="Ingiza Jina la Mwisho" name="lastname">
                                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Barua Pepe</label>
                                <input type="text"  value="{{ old('email', $user->email) }}" id="email" class="form-control" placeholder="Ingiza Barua Pepe" name="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Namba ya Simu</label>
                                        <input type="text" value="{{ old('phone', $user->phone) }}" id="phone" class="form-control" placeholder="Ingiza Namba ya Simu" name="phone">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_type" class="form-label">Aina ya Mhusika</label>
                                        <select class="form-select" name="user_type">
                                            @if($user->user_type == 'admin')
                                                <option value="">-- chagua Aina ya Mhusika --</option>
                                                <option value="admin" selected>Admin</option>
                                                <option value="mchungaji">Mchungaji</option>
                                                <option value="katibu">Katibu</option>
                                                <option value="mwasibu">Mwasibu</option>
                                            @elseif($user->user_type == 'mchungaji')
                                                <option value="">-- chagua Aina ya Mhusika --</option>
                                                <option value="admin">Admin</option>
                                                <option value="mchungaji" selected>Mchungaji</option>
                                                <option value="katibu">Katibu</option>
                                                <option value="mwasibu">Mwasibu</option>
                                            @elseif($user->user_type == 'katibu')
                                                <option value="">-- chagua Aina ya Mhusika --</option>
                                                <option value="admin">Admin</option>
                                                <option value="mchungaji">Mchungaji</option>
                                                <option value="katibu" selected>Katibu</option>
                                                <option value="mwasibu">Mwasibu</option>
                                            @elseif($user->user_type == 'mwasibu')
                                                <option value="">-- chagua Aina ya Mhusika --</option>
                                                <option value="admin">Admin</option>
                                                <option value="mchungaji">Mchungaji</option>
                                                <option value="katibu">Katibu</option>
                                                <option value="mwasibu" selected>Mwasibu</option>
                                            @else
                                                <option value="" selected>-- chagua Aina ya Mhusika --</option>
                                                <option value="admin">Admin</option>
                                                <option value="mchungaji">Mchungaji</option>
                                                <option value="katibu">Katibu</option>
                                                <option value="mwasibu">Mwasibu</option>
                                            @endif
                                        </select>
                                        @error('user_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                            {{--                    <button type="submit" class="btn btn-primary">Ongeza Mhusika</button>--}}
                            <button type="submit"
                                    class="btn btn-primary d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Hariri Taarifa</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
{{--    data-bs-toggle="modal" data-bs-target="#deleteSelectedUserModal"--}}

    <!-- Modal - ADMIN USER DELETE -->
    @foreach($users as $user)
        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModal{{ $user->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteUserModal{{ $user->id }}Label">Futa Mhusika</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kumfuta mhusika huyu mwenye jina <span class="fst-italic text-success">{{ '#' . $user->name }}</span>?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.user', $user->id) }}" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Futa Mhusika</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal - ADMIN DELETE SELECTED USERS -->
    <div class="modal fade" id="deleteSelectedUserModal" tabindex="-1" aria-labelledby="deleteSelectedUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteSelectedUserModalLabel">
                            @if(count($selectedUsers) > 1)
                                Futa Wahusika
                            @elseif(count($selectedUsers) == 1)
                                Futa Mhusika
                            @endif
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(count($selectedUsers) > 1)
                            <p>Unauwakika wa kuwafuta wahusika huwa?</span>?</p>
                        @elseif(count($selectedUsers) == 1)
                            <p>Unauwakika wa kumfuta mhusika huyu?</span>?</p>
                        @endif
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit" wire:click="deleteSelectedUsers"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>
                                    @if(count($selectedUsers) > 1)
                                        Futa Wahusika
                                    @elseif(count($selectedUsers) == 1)
                                        Futa Mhusika
                                    @endif
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

