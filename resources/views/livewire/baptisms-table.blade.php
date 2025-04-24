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

                    @if(count($selectedBaptisms) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedBaptismModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedBaptisms) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedBaptismModal">
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
                            @if(count($selectedBaptisms) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedBaptismModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedBaptisms) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedBaptismModal">
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
                    <input wire:model="isSelectedAll" wire:click="toggleSelectedAll" type="checkbox" id="bulk-select"
                           value="select-all-">
                </th>
                <th>#</th>
                <th>Jina la Baba (Namba)</th>
                <th>Jina la Mama (Namba)</th>
                <th>Jina la Mtoto</th>
                <th>Tarehe ya Kuzaliwa</th>
                <th>Umri</th>
                <th>Tarehe ya Kubatizwa</th>
                <th>Alie Unda</th>
                <th>Hali</th>
                <th>Tarehe ya Kuundwa</th>
                <th>Vitendo</th>
            </tr>
            </thead>
            <tbody>
            @php
                $id = $baptisms->firstItem();
            @endphp
            @forelse($baptisms as $baptism)
                <tr class="py-2" wire:key="baptism-{{ $baptism->id }}">
                    <td>
                        <input wire:model.live="selectedBaptisms" type="checkbox" id="bulk-select"
                               value="{{ $baptism->id }}">
                    </td>
                    <td>{{ $id++ }}</td>
                    <td>{{ $baptism->father->firstname .' '. $baptism->father->middlename .' '. $baptism->father->lastname }}</td>
                    <td>{{ $baptism->mother->firstname .' '. $baptism->mother->middlename .' '. $baptism->mother->lastname }}</td>
                    <td>{{ $baptism->baby_firstname .' '. $baptism->baby_middlename .' '. $baptism->baby_lastname }}</td>
                    <td>{{ $baptism->dateOfBirth }}</td>
                    <td>{{ $baptism->age }}</td>
                    <td>{{ $baptism->dateOfBaptism }}</td>
                    <td>{{ $baptism->user->name .' ('. Str::title($baptism->user->user_type) .')' }}</td>
                    <td>
                        @if($baptism->status == 'Hai')
                            <span class="badge text-bg-success rounded-full">Hai</span>
                        @else
                            <span class="badge text-bg-danger rounded-full">Siohai</span>
                        @endif
                    </td>
                    <td>{{ $baptism->created_at }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1000;">
                                <li>
                                    <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#viewBaptismModal{{ $baptism->id }}" style="cursor: pointer;">
                                        <i class="bi bi-eye-fill me-1"></i> Tazama
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#editBaptismModal{{ $baptism->id }}" style="cursor: pointer;">
                                        <i class="bi bi-pen-fill me-1"></i> Hariri
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#deleteBaptismModal{{ $baptism->id }}">
                                        <i class="bi bi-trash-fill me-1"></i> Futa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="10">
                        <div class="d-flex align-items-center justify-content-center py-3">
                            <i class="bi bi-inbox fs-2 text-muted"></i>
                            <span class="text-muted mx-3">Hakuna majibu ya '{{ $search }}' </span>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>


        @if($baptisms->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $baptisms->currentPage() }} ya {{ $baptisms->lastPage() }} | Jumla ya
                    Ubatizo: {{ $baptisms->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $baptisms->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif

    </div>


        <!-- Modal - ADMIN VIEW -->
    @foreach($baptisms as $baptism)
        <div class="modal fade" id="viewBaptismModal{{ $baptism->id }}" tabindex="-1"
             aria-labelledby="viewBaptismModal{{ $baptism->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewBaptismModal{{ $baptism->id }}Label">Tazama Ubatizo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="father_member_id" class="form-label">Jina la Baba (Namba)</label>
                                    <input type="text" value="{{ $baptism->father->firstname .' '. $baptism->father->middlename .' '. $baptism->father->lastname .'('.$baptism->father->member_id .')' }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mother_member_id" class="form-label">Jina la Mama (Namba)</label>
                                    <input type="text" value="{{ $baptism->mother->firstname .' '. $baptism->mother->middlename .' '. $baptism->mother->lastname .'('.$baptism->mother->member_id .')' }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="baby_name" class="form-label">Jina la Mtoto</label>
                                    <input type="text" value="{{ $baptism->baby_firstname .' '. $baptism->baby_middlename  .' '. $baptism->baby_lastname }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateOfBirth" class="form-label">Tarehe ya Kuzaliwa</label>
                                    <input type="text" value="{{ $baptism->dateOfBirth }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="age" class="form-label">Umri</label>
                                    <input type="text" value="{{ $baptism->age }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dateOfBaptism" class="form-label">Tarehe ya Kubatizwa</label>
                                    <input type="text" value="{{ $baptism->dateOfBaptism }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Hali</label>
                                    <input type="text" value="{{ $baptism->status }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Alie Unda</label>
                                    <input type="text" value="{{ $baptism->user->name .'('. $baptism->user->user_type .')' }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="created_at" class="form-label">Tarehe ya Kuundwa</label>
                                    <input type="text" value="{{ $baptism->created_at }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN LEADER EDIT -->
    @foreach($baptisms as $baptism)
        <div class="modal fade" id="editBaptismModal{{ $baptism->id }}" tabindex="-1"
             aria-labelledby="editBaptismModal{{ $baptism->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.baptism') }}" method="POST" x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editBaptismModal{{ $baptism->id }}Label">Hariri Ubatizo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="{{ $baptism->id }}" name="id" hidden>
                            <input type="text" value="{{ $baptism->user_id }}" name="user_id" class="form-control" hidden>

                            {{-- <livewire:update-check-member-id :baptism-id="$baptism->id" /> --}}

                            <livewire:baptism-update-parents-check-id :father-id="$baptism->father->id" :mother-id="$baptism->mother->id" />

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="baby_firstname" class="form-label">Jina la Kwanza (Mtoto)</label>
                                        <input type="text" class="form-control" value="{{ old('baby_firstname', $baptism->baby_firstname ) }}" name="baby_firstname" id="baby_firstname" placeholder="Ingiza jina la kwanza la mtoto...">
                                        @error('baby_firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="baby_middlename" class="form-label">Jina la Kati (Mtoto)</label>
                                        <input type="text" class="form-control" name="baby_middlename" value="{{ old('baby_middlename', $baptism->baby_middlename ) }}" id="baby_middlename" placeholder="Ingiza jina la kati la mtoto...">
                                        @error('baby_middlename') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="baby_lastname" class="form-label">Jina la Mwisho (Mtoto)</label>
                                        <input type="text" class="form-control" name="baby_lastname" id="baby_lastname" value="{{ old('baby_lastname', $baptism->baby_lastname ) }}" placeholder="Ingiza jina la mwisho la mtoto...">
                                        @error('baby_lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Tarehe ya Kuzaliwa (Mtoto)</label>
                                        <input type="date" class="form-control" name="dateOfBirth" value="{{ old('dateOfBirth', $baptism->dateOfBirth) }}" id="dateOfBirth" placeholder="Ingiza tarehe ya kuzaliwa ya mtoto...">
                                        @error('dateOfBirth') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dateOfBaptism" class="form-label">Tarehe ya Kubatizwa (Mtoto)</label>
                                        <input type="date" class="form-control" name="dateOfBaptism" value="{{ old('dateOfBaptism', $baptism->dateOfBaptism) }}" id="dateOfBaptism" placeholder="Ingiza tarehe ya kubatizwa kwa mtoto...">
                                        @error('dateOfBaptism') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Hali</label>
                                <select name="status" id="status" class="form-select">
                                    @if($baptism->status == 'Hai')
                                        <option value="">-- chagua hali --</option>
                                        <option value="Hai" selected>Hai</option>
                                        <option value="Siohai">Siohai</option>
                                    @elseif($baptism->status == 'Siohai')
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
    @foreach($baptisms as $baptism)
        <div class="modal fade" id="deleteBaptismModal{{ $baptism->id }}" tabindex="-1"
             aria-labelledby="deleteBaptismModal{{ $baptism->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteBaptismModal{{ $baptism->id }}Label">Futa Ubatizo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kufuta ubatizo huu wa mtoto mwenye jina <span
                                class="fst-italic text-success">{{ '#' . $baptism->baby_firstname .' '. $baptism->baby_middlename .' '. $baptism->baby_lastname }}</span>?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.baptism', $baptism->id) }}"
                              x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Futa Ubatizo</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN DELETE SELECTED LEADERS -->
    <div class="modal fade" id="deleteSelectedBaptismModal" tabindex="-1" aria-labelledby="deleteSelectedBaptismModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-o">
                    <h1 class="modal-title fs-5" id="deleteSelectedBaptismModalLabel">
                        @if(count($selectedBaptisms) > 1)
                            Futa Ubatizo
                        @elseif(count($selectedBaptisms) == 1)
                            Futa Ubatizo
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($selectedBaptisms) > 1)
                        <p>Unauwakika wa kufuta viongozi hawa?</span>?</p>
                    @elseif(count($selectedBaptisms) == 1)
                        <p>Unauwakika wa kumfuta kiongozi huyu?</span>?</p>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                    <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        <button type="submit" wire:click="deleteSelectedBaptisms"
                                class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                :disabled="loading">
                            <!-- Spinner shown only when loading -->
                            <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                            <span>
                                @if(count($selectedBaptisms) > 1)
                                    Futa Ubatizo
                                @elseif(count($selectedBaptisms) == 1)
                                    Futa Ubatizo
                                @endif
                                </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

