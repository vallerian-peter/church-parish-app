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

                    @if(count($selectedLeaders) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedLeaderModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedLeaders) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedLeaderModal">
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
                            @if(count($selectedLeaders) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedLeaderModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedLeaders) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedLeaderModal">
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
                <th>Namba ya Mshirika</th>
                <th>Jina Kamili</th>
                <th>Nafasi</th>
                <th>Kiongozi</th>
                <th>Alie Unda</th>
                <th>Hali ya Kiongozi</th>
                <th>Tarehe ya Kuundwa</th>
                <th>Vitendo</th>
            </tr>
            </thead>
            <tbody>
            @php
                $id = $leaders->firstItem();
            @endphp
            @forelse($leaders as $leader)
                <tr class="py-2" wire:key="leader-{{ $leader->id }}">
                    <td>
                        <input wire:model.live="selectedLeaders" type="checkbox" id="bulk-select"
                               value="{{ $leader->id }}">
                    </td>
                    <td>{{ $id++ }}</td>
                    <td>{{ $leader->member_id }}</td>
                    <td>{{ $leader->member->name }}</td>
                    <td>{{ $leader->leaderPosition->name }}</td>
                    <td>{{ $leader->group->name }}</td>
                    <td>{{ $leader->user->name .' ('. Str::title($leader->user->user_type) .')' }}</td>
                    <td>
                        @if($leader->status == 'Hai')
                            <span class="badge text-bg-success rounded-full">Hai</span>
                        @else
                            <span class="badge text-bg-danger rounded-full">Siohai</span>
                        @endif
                    </td>
                    <td>{{ $leader->created_at }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1000;">
                                <li>
                                    <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#viewLeaderModal{{ $leader->id }}" style="cursor: pointer;">
                                        <i class="bi bi-eye-fill me-1"></i> Tazama
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#editLeaderModal{{ $leader->id }}" style="cursor: pointer;">
                                        <i class="bi bi-pen-fill me-1"></i> Hariri
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#deleteLeaderModal{{ $leader->id }}">
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


        @if($leaders->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $leaders->currentPage() }} ya {{ $leaders->lastPage() }} | Jumla ya
                    Viongozi: {{ $leaders->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $leaders->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif

    </div>


    <!-- Modal - ADMIN LEADER VIEW -->
    @foreach($leaders as $leader)
        <div class="modal fade" id="viewLeaderModal{{ $leader->id }}" tabindex="-1"
             aria-labelledby="viewLeaderModal{{ $leader->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewLeaderModal{{ $leader->id }}Label">Tazama Kiongozi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="member_id" class="form-label">Namba ya Mshirika</label>
                            <input type="text" value="{{ $leader->member_id }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Jina Kamili</label>
                            <input type="text" value="{{ $leader->member->name }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Nafasi</label>
                                    <input type="text" value="{{ $leader->leaderPosition->name }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Kiongozi</label>
                                    <input type="text" value="{{ $leader->group->name }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Alie Kiunda</label>
                                    <input type="text" value="{{ $leader->user->name .' ('. Str::title($leader->user->user_type) .')' }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Hali</label>
                                    <input type="text" value="{{ $leader->status }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tarehe ya Kuundwa</label>
                            <input type="text" value="{{ $leader->created_at }}" class="form-control fw-bold" readonly>
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
    @foreach($leaders as $leader)
        <div class="modal fade" id="editLeaderModal{{ $leader->id }}" tabindex="-1"
             aria-labelledby="editLeaderModal{{ $leader->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.leader') }}" method="POST" x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editLeaderModal{{ $leader->id }}Label">Hariri Kiongozi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="{{ $leader->id }}" name="id" hidden>
                            <input type="text" value="{{ $leader->user_id }}" name="user_id" class="form-control" hidden>
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Namba ya Mshirika</label>
                                <input type="text" class="form-control" value="{{ old('member_id', $leader->member_id) }}"
                                       name="member_id" id="member_id" placeholder="Ingiza namba ya Mshirika">
                                @error('member_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="leader_position_id" class="form-label">Nafasi ya Mshirika</label>
                                        <select name="leader_position_id" id="leader_position_id" class="form-select">
                                            <option value="">--chagua nafasi--</option>
                                            @foreach($leaderPositions as $position)
                                                @if($leader->leader_position_id == $position->id)
                                                    <option value="{{ $position->id }}" selected>{{ $position->name }}</option>
                                                @else
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('leader_position_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Kikundi</label>
                                        <select name="group_id" id="group_id" class="form-select">
                                            <option value="">--chagua kikundi--</option>
                                            @foreach($groups as $group)
                                                @if($leader->group_id == $group->id)
                                                    <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                                @else
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('group_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Hali</label>
                                <select name="status" id="status" class="form-select">
                                    @if($leader->status == 'Hai')
                                        <option value="">-- chagua hali --</option>
                                        <option value="Hai" selected>Hai</option>
                                        <option value="Siohai">Siohai</option>
                                    @elseif($leader->status == 'Siohai')
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
    @foreach($leaders as $leader)
        <div class="modal fade" id="deleteLeaderModal{{ $leader->id }}" tabindex="-1"
             aria-labelledby="deleteLeaderModal{{ $leader->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteLeaderModal{{ $leader->id }}Label">Futa Kiongozi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kumfuta kiongozi huyu mwenye jina <span
                                class="fst-italic text-success">{{ '#' . $leader->member->name }}</span>?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.leader', $leader->id) }}"
                              x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Futa Kiongozi</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN DELETE SELECTED LEADERS -->
    <div class="modal fade" id="deleteSelectedLeaderModal" tabindex="-1" aria-labelledby="deleteSelectedLeaderModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-o">
                    <h1 class="modal-title fs-5" id="deleteSelectedLeaderModalLabel">
                        @if(count($selectedLeaders) > 1)
                            Futa Viongozi
                        @elseif(count($selectedLeaders) == 1)
                            Futa Kiongozi
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($selectedLeaders) > 1)
                        <p>Unauwakika wa kufuta viongozi hawa?</span>?</p>
                    @elseif(count($selectedLeaders) == 1)
                        <p>Unauwakika wa kumfuta kiongozi huyu?</span>?</p>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                    <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        <button type="submit" wire:click="deleteSelectedLeaders"
                                class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                :disabled="loading">
                            <!-- Spinner shown only when loading -->
                            <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                            <span>
                                @if(count($selectedLeaders) > 1)
                                    Futa Viongozi
                                @elseif(count($selectedLeaders) == 1)
                                    Futa Kiongozi
                                @endif
                                </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

