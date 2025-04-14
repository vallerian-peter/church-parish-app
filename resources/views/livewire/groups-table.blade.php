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

                    @if(count($selectedGroups) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedGroupModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedGroups) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedGroupModal">
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
                            @if(count($selectedGroups) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedGroupModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedGroups) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedGroupModal">
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
                <th>Jina Kamili</th>
                <th>Alie Unda</th>
                <th>Hali</th>
                <th>Tarehe ya Kuundwa</th>
                <th>Vitendo</th>
            </tr>
            </thead>
            <tbody>
            @php
                $id = $groups->firstItem();
            @endphp
            @forelse($groups as $group)
                <tr class="py-2" wire:key="user-{{ $group->id }}">
                    <td>
                        <input wire:model.live="selectedGroups" type="checkbox" id="bulk-select"
                               value="{{ $group->id }}">
                    </td>
                    <td>{{ $id++ }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->user->name .' ('. Str::title($group->user->user_type) .')' }}</td>
                    <td>
                        @if($group->status == 'Hai')
                            <span class="badge text-bg-success rounded-full">Hai</span>
                        @else
                            <span class="badge text-bg-danger rounded-full">Siohai</span>
                        @endif
                    </td>
                    <td>{{ $group->created_at }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1000;">
                                <li>
                                    <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#viewGroupModal{{ $group->id }}" style="cursor: pointer;">
                                        <i class="bi bi-eye-fill me-1"></i> Tazama
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#editGroupModal{{ $group->id }}" style="cursor: pointer;">
                                        <i class="bi bi-pen-fill me-1"></i> Hariri
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#deleteGroupModal{{ $group->id }}">
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


        @if($groups->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $groups->currentPage() }} ya {{ $groups->lastPage() }} | Jumla ya
                    Wahusika: {{ $groups->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $groups->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif

    </div>


    <!-- Modal - ADMIN USER VIEW -->
    @foreach($groups as $group)
        <div class="modal fade" id="viewGroupModal{{ $group->id }}" tabindex="-1"
             aria-labelledby="viewGroupModal{{ $group->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewGroupModal{{ $group->id }}Label">Tazama Kikundi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Jina la Kikundi</label>
                            <input type="text" value="{{ $group->name }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Alie Kiunda</label>
                            <input type="text" value="{{ $group->user->name .' ('. Str::title($group->user->user_type) .')' }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Hali</label>
                            <input type="text" value="{{ $group->status }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tarehe ya Kuundwa</label>
                            <input type="text" value="{{ $group->created_at }}" class="form-control fw-bold" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN GROUP EDIT -->
    @foreach($groups as $group)
        <div class="modal fade" id="editGroupModal{{ $group->id }}" tabindex="-1"
             aria-labelledby="editGroupModal{{ $group->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.group') }}" method="POST" x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editGroupModal{{ $group->id }}Label">Hariri Kikundi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" value="{{ $group->id }}" name="id" hidden>
                            <input type="text" value="{{ $group->user_id }}" name="user_id" class="form-control" hidden>
                            <div class="mb-3">
                                <label for="name" class="form-label">Jina la Kikundi</label>
                                <input type="text" class="form-control" value="{{ old('name', $group->name) }}"
                                       name="name" id="name" placeholder="Ingiza jina la kikundi">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Hali</label>
                                <select name="status" id="status" class="form-select">
                                    @if($group->status == 'Hai')
                                        <option value="">-- chagua hali --</option>
                                        <option value="Hai" selected>Hai</option>
                                        <option value="Siohai">Siohai</option>
                                    @elseif($group->status == 'Siohai')
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
    @foreach($groups as $group)
        <div class="modal fade" id="deleteGroupModal{{ $group->id }}" tabindex="-1"
             aria-labelledby="deleteGroupModal{{ $group->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteGroupModal{{ $group->id }}Label">Futa Kikundi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kufuta kikundi hichi chenye jina <span
                                class="fst-italic text-success">{{ '#' . $group->name }}</span>?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.group', $group->id) }}"
                              x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                    :disabled="loading">
                                <!-- Spinner shown only when loading -->
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                      aria-hidden="true"></span>
                                <span>Futa Kikundi</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modal - ADMIN DELETE SELECTED GROUPS -->
    <div class="modal fade" id="deleteSelectedGroupModal" tabindex="-1" aria-labelledby="deleteSelectedGroupModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-o">
                    <h1 class="modal-title fs-5" id="deleteSelectedGroupModalLabel">
                        @if(count($selectedGroups) > 1)
                            Futa Wahusika
                        @elseif(count($selectedGroups) == 1)
                            Futa Mhusika
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($selectedGroups) > 1)
                        <p>Unauwakika wa kuvifuta vikundi hivi?</span>?</p>
                    @elseif(count($selectedGroups) == 1)
                        <p>Unauwakika wa kukifuta kikundi hiki?</span>?</p>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                    <form x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        <button type="submit" wire:click="deleteSelectedGroups"
                                class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                                :disabled="loading">
                            <!-- Spinner shown only when loading -->
                            <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span>
                            <span>
                                @if(count($selectedGroups) > 1)
                                    Futa Vikundi
                                @elseif(count($selectedGroups) == 1)
                                    Futa Kikundi
                                @endif
                                </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

