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
                    <select class="form-select border border-secondary me-2" wire:model.live="perPage"
                            style="width: 80px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    @if(count($selectedMembers) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedMemberModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedMembers) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedMemberModal">
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
                            <input wire:model.live="search" type="search" class="form-control border-start-0"
                                   placeholder="Tafuta hapa..">
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <div class="dropdown">
                        <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-dark"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">

                            <!-- Only show Futa Zote inside dropdown on sm -->
                            @if(count($selectedMembers) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedMemberModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedMembers) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedMemberModal">
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


        <table wire:loading.class="opacity-25" class="table table-hover w-100 myUsersTable" style="width: 100%;"
                   cellspacing="0" width="100%">
                <thead class="table-secondary text-dark font-semibold">
                <tr class="py-2">
                    <th>
                        <input wire:model="isSelectedAll" wire:click="toggleSelectedAll" type="checkbox"
                               id="bulk-select" value="select-all-">
                    </th>
                    <th>#</th>
                    <th>Namba ya Mshirika</th>
                    <th>Jina Kamili</th>
{{--                    <th>Tarehe ya Kuzaliwa</th>--}}
                    <th>Umri</th>
                    <th>Jinsia</th>
                    <th>Simu</th>
                    <th>Balozi</th>
{{--                    <th>Mtaa</th>--}}
                    <th>Ni Mgeni?</th>
{{--                    <th>Kikundi</th>--}}
                    <th>Hali</th>
                    <th>Tarehe ya Kuundwa</th>
                    <th>Vitendo</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $id = $members->firstItem();
                @endphp
                @forelse($members as $member)
                    <tr class="py-2" wire:key="member-{{ $member->id }}">
                        <td>
                            <input wire:model.live="selectedMembers" type="checkbox" id="bulk-select"
                                   value="{{ $member->id }}">
                        </td>
                        <td>{{ $id++ }}</td>
                        <td>{{ $member->member_id }}</td>
                        <td>{{ $member->firstname .' '. $member->middlename .' '. $member->lastname }}</td>
{{--                        <td>{{ $member->dateOfBirth }}</td>--}}
                        <td>{{ $member->age }}</td>
                        <td>{{ $member->sex }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->ambassador }}</td>
{{--                        <td>{{ $member->street }}</td>--}}
                        <td>
                            @if($member->is_guest)
                                <span class="badge text-bg-primary rounded-full">Mgeni</span>
                            @else
                                <span class="badge text-bg-warning rounded-full">Simgeni</span>
                            @endif
                        </td>
{{--                        <td>{{ $member->group->name }}</td>--}}
                        <td>
                            @if($member->status == 'Hai')
                                <span class="badge text-bg-success rounded-full">Hai</span>
                            @else
                                <span class="badge text-bg-danger rounded-full">Siohai</span>
                            @endif
                        </td>
                        <td>{{ $member->created_at }}</td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-dark"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button type="button" class="dropdown-item text-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewMemberModal{{ $member->id }}"
                                                style="cursor: pointer;">
                                            <i class="bi bi-eye-fill me-1"></i> Tazama
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal{{ $member->id }}"
                                                style="cursor: pointer;">
                                            <i class="bi bi-pen-fill me-1"></i> Hariri
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteMemberModal{{ $member->id }}">
                                            <i class="bi bi-trash-fill me-1"></i> Futa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                @empty
{{--                    my-dropbtn--}}

                    <tr>
                        <td colspan="11">
                            <div class="d-flex align-items-center justify-content-center py-3">
                                <i class="bi bi-inbox fs-2 text-muted"></i>
                                <span class="text-muted mx-3">Hakuna majibu ya '{{ $search }}' </span>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        @if($members->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $members->currentPage() }} ya {{ $members->lastPage() }} | Jumla ya
                    Wahusika: {{ $members->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $members->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif
    </div>


    <!-- Modal - ADMIN USER VIEW -->
    @foreach($members as $member)
        <div class="modal fade" id="viewMemberModal{{ $member->id }}" tabindex="-1"
             aria-labelledby="viewMemberModal{{ $member->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewMemberModal{{ $member->id }}Label">Tazama Mshirika</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="member_id" class="form-label">Namba ya Mshirika</label>
                                    <input type="text" id="member_id" class="form-control fw-bold"
                                           value="{{ $member->member_id }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="member_id" class="form-label">Mhusika Aliemsjali</label>
                                    <input type="text" id="member_id" class="form-control fw-bold"
                                           value="{{ $member->user->name .'('. Str::title($member->user->user_type) .')' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Jina la Kwanza</label>
                                    <input type="text" id="firstname" class="form-control fw-bold"
                                           value="{{ $member->firstname }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="middlename" class="form-label">Jina la Kati</label>
                                    <input type="text" id="middlename" class="form-control fw-bold"
                                           value="{{ $member->middlename }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Jina la Mwisho</label>
                                    <input type="text" id="lastname" class="form-control fw-bold"
                                           value="{{ $member->lastname }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                               <div class="mb-3">
                                   <label for="phone" class="form-label">Umri</label>
                                   <input class="form-control fw-bold" value="{{ $member->age }}" readonly>
                               </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dateOfBirth" class="form-label">Tarehe ya Kuzaliwa</label>
                                    <input class="form-control fw-bold" value="{{ $member->dateOfBirth }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Namba ya Simu</label>
                                    <input class="form-control fw-bold" value="{{ $member->phone }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sex" class="form-label">Jinsia</label>
                                    <input class="form-control fw-bold" value="{{ $member->sex }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if($member->is_guest == 1)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mtaa</label>
                                        <input class="form-control fw-bold" value="{{ $member->street }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sex" class="form-label">Ni Mgeni?</label>
                                        @if ($member->is_guest == 1)
                                            <input class="form-control fw-bold" value="Ndio" readonly>
                                        @else
                                            <input class="form-control fw-bold" value="Hapana" readonly>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Balozi</label>
                                        <input class="form-control fw-bold" value="{{ $member->ambassador ?? 'null' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mtaa</label>
                                        <input class="form-control fw-bold" value="{{ $member->street }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sex" class="form-label">Ni Mgeni?</label>
                                        @if ($member->is_guest == 1)
                                            <input class="form-control fw-bold" value="Ndio" readonly>
                                        @else
                                            <input class="form-control fw-bold" value="Hapana" readonly>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($member->is_guest == 1)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Hali</label>
                                        <input class="form-control fw-bold" value="{{ $member->status }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Tarehe ya Kuundwa</label>
                                        <input type="text" value="{{ $member->created_at }}" class="form-control fw-bold" readonly>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Kikundi</label>
                                        <input class="form-control fw-bold" value="{{ $member->group->name ?? 'null' }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Hali</label>
                                        <input class="form-control fw-bold" value="{{ $member->status }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Tarehe ya Kuundwa</label>
                                        <input type="text" value="{{ $member->created_at }}" class="form-control fw-bold" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN MEMBER EDIT -->
    @foreach($members as $member)
        <div class="modal fade" id="editMemberModal{{ $member->id }}" tabindex="-1"
             aria-labelledby="editMemberModal{{ $member->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.member') }}" method="POST" x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editMemberModalLabel">Hariri Mshirika</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="{{ $member->id }}" name="id" hidden>
                            <input type="text" value="{{ $member->user_id }}" name="user_id" hidden>

                            <div class="mb-3">
                                <label for="member_id" class="form-label">Namba ya Mshirika</label>
                                <input type="text" id="member_id" value="{{ old('member_id', $member->member_id) }}"
                                       class="form-control" placeholder="Ingiza Namba ya Mshirika" name="member_id">
                                @error('member_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                   <div class="mb-3">
                                       <label for="firstname" class="form-label">Jina la Kwanza</label>
                                       <input type="text" id="firstname" value="{{ old('firstname', $member->firstname) }}"
                                              class="form-control" placeholder="Ingiza Jina la Kwanza" name="firstname">
                                       @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="middlename" class="form-label">Jina la Kati</label>
                                        <input type="text" id="middlename"
                                               value="{{ old('middlename', $member->middlename) }}" class="form-control"
                                               placeholder="Ingiza Jina la Kati" name="middlename">
                                        @error('middlename') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Jina la Mwisho</label>
                                        <input type="text" id="lastname" value="{{ old('lastname', $member->lastname) }}"
                                               class="form-control" placeholder="Ingiza Jina la Mwisho" name="lastname">
                                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Namba ya Simu</label>
                                        <input type="text" value="{{ old('phone', $member->phone) }}" id="phone"
                                               class="form-control" placeholder="Ingiza Namba ya Simu" name="phone">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Tarehe ya Kuzaliwa</label>
                                        <input type="date" value="{{ old('dateOfBirth', $member->dateOfBirth) }}"
                                               id="dateOfBirth" class="form-control" placeholder="Ingiza Tarehe ya Kuzaliwa"
                                               name="dateOfBirth">
                                        @error('dateOfBirth') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                   <div class="mb-3">
                                       <label for="sex" class="form-label">Jinsia</label>
                                       <select name="sex" id="sex" class="form-select">
                                           @if($member->sex == 'Mwanaume')
                                               <option>-- chagua jinsia --</option>
                                               <option value="Mwanaume" selected>Mwanaume</option>
                                               <option value="Mwanamke">Mwanamke</option>
                                           @elseif($member->sex == 'Mwanamke')
                                               <option>-- chagua jinsia --</option>
                                               <option value="Mwanaume">Mwanaume</option>
                                               <option value="Mwanamke" selected>Mwanamke</option>
                                           @else
                                               <option selected>-- chagua jinsia --</option>
                                               <option value="Mwanaume">Mwanaume</option>
                                               <option value="Mwanamke">Mwanamke</option>
                                           @endif
                                       </select>
                                       @error('sex') <span class="text-danger">{{ $message }}</span> @enderror
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Mtaa</label>
                                        <input type="text" value="{{ old('street', $member->street) }}" id="street"
                                               class="form-control" placeholder="Ingiza Mtaa" name="street">
                                        @error('street') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="switchCheckDefault" class="form-label">Ni Mgeni?</label>
                                        <div class="d-flex align-items-center gap-2 flex-wrap mx-3">
                                            <div class="form-check form-switch">
                                                @if($member->is_guest == 1)
                                                    <input
                                                        name="is_guest"
                                                        class="form-check-input fs-4"
                                                        type="checkbox"
                                                        role="switch"
                                                        id="switchCheckDefault"
                                                        checked>
                                                @else
                                                    <input
                                                        name="is_guest"
                                                        class="form-check-input fs-4"
                                                        type="checkbox"
                                                        role="switch"
                                                        id="switchCheckDefault">
                                                @endif

                                            </div>
                                            <small class="text-muted fst-italic">
                                                Ikiwa imewaka basi <b>Ni-mgeni</b>, laasivyo sio
                                            </small>
                                        </div>
                                        @error('is_guest')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Kikundi <span class="fst-italic text-muted"> @if(empty($member->group_id)) '(null)' @endif </span> </label>
                                        <select name="group_id" id="group_id" class="form-select">
                                            <option value="">-- chagua kikundi --</option>
                                            @foreach($groups as $group)
                                                @if($group->id == $member->group_id)
                                                    <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                                @else
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('group_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="ambassador" class="form-label">Balozi</label>
                                        <input type="text" value="{{ old('ambassador', $member->ambassador ?? 'null') }}"
                                               id="ambassador" class="form-control" placeholder="Ingiza Balozi"
                                               name="ambassador">
                                        @error('ambassador') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Hali</label>
                                        <select name="status" id="status" class="form-select">
                                            @if($member->status == 'Hai')
                                                <option value="">-- chagua hali --</option>
                                                <option value="Hai" selected>Hai</option>
                                                <option value="Siohai">Siohai</option>
                                            @elseif($member->status == 'Siohai')
                                                <option>-- chagua hali --</option>
                                                <option value="Hai">Hai</option>
                                                <option value="Siohai" selected>Siohai</option>
                                            @else
                                                <option value="" selected>-- chagua hali --</option>
                                                <option value="Hai">Hai</option>
                                                <option value="Siohai">Siohai</option>
                                            @endif
                                        </select>
                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
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


    <!-- Modal - ADMIN USER DELETE -->
    @foreach($members as $member)
        <div class="modal fade" id="deleteMemberModal{{ $member->id }}" tabindex="-1"
             aria-labelledby="deleteMemberModal{{ $member->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteMemberModal{{ $member->id }}Label">Futa Mshirika</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kumfuta mshirika huyu mwenye jina <span
                                class="fst-italic text-success">{{ '#' . $member->firstname .' '. $member->middlename .' '. $member->lastname }}</span>?
                        </p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.member', $member->id) }}"
                              x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Futa Mshirika</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal - ADMIN DELETE SELECTED MEMBERS -->
    <div class="modal fade" id="deleteSelectedMemberModal" tabindex="-1"
         aria-labelledby="deleteSelectedMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-o">
                    <h1 class="modal-title fs-5" id="deleteSelectedMemberModalLabel">
                        @if(count($selectedMembers) > 1)
                            Futa Washirika
                        @elseif(count($selectedMembers) == 1)
                            Futa Mshirika
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
{{--                    @if(count($selectedMembers) > 1)--}}
{{--                        --}}
{{--                    @elseif(count($selectedUsers) == 1)--}}
{{--                        x--}}
{{--                    @else--}}
{{--                        <p>Hakuna Alie chaguliwa</p>--}}
{{--                    @endif--}}
                    @if(!empty($selectedMembers) && count($selectedMembers) > 1)
                        <p>Unauwakika wa kuwafuta washirika hawa?</span>?</p>
                    @elseif(!empty($selectedMembers) && count($selectedMembers) === 1)
                        <p>Unauwakika wa kuwafuta washirika hawa?</span>?</p>
                    @else
                        Hakuna Mshirika Alichaguliwa
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                    <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        <button type="submit" wire:click="deleteSelectedMembers"
                                class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                :disabled="loading">
                            <!-- Spinner shown only when loading -->
                            <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                            <span>
                                @if(!empty($selectedMembers) && count($selectedMembers) > 1)
                                    Futa Washirika
                                @elseif(!empty($selectedMembers) && count($selectedMembers) === 1)
                                    Futa Mshirika
                                @else
                                    Hakuna Mshirika Alichaguliwa
                                @endif
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

