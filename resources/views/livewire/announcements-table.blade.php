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

                    @if(count($selectedAnnouncements) > 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedAnnouncementModal">
                            <i class="bi bi-trash text-light"></i> Futa Zote
                        </button>
                    @elseif(count($selectedAnnouncements) == 1)
                        <!-- Delete button only visible on md+ -->
                        <button class="btn btn-danger d-none d-md-block" data-bs-toggle="modal"
                                data-bs-target="#deleteSelectedAnnouncementModal">
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
                            @if(count($selectedAnnouncements) > 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedAnnouncementModal">
                                        <i class="bi bi-trash-fill me-1"></i> Futa Zote
                                    </a>
                                </li>
                            @elseif(count($selectedAnnouncements) == 1)
                                <!-- Delete button only visible on md+ -->
                                <li class="d-md-none">
                                    <a class="dropdown-item text-danger" href="#" style="cursor: pointer;"
                                       data-bs-toggle="modal" data-bs-target="#deleteSelectedAnnouncementModal">
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
                <th>Aina ya Tangazo</th>
                <th>Maelezo</th>
                <th>Faili la Tangazo</th>
                <th>Alie Unda</th>
                <th>Tarehe ya Kuundwa</th>
                <th>Vitendo</th>
            </tr>
            </thead>
            <tbody>
            @php
                $id = $announcements->firstItem();
            @endphp
            @forelse($announcements as $announcement)
                <tr class="py-2" wire:key="announcement-{{ $announcement->id }}">
                    <td>
                        <input wire:model.live="selectedAnnouncements" type="checkbox" id="bulk-select"
                               value="{{ $announcement->id }}">
                    </td>
                    <td>{{ $id++ }}</td>
                    <td>{{ $announcement->announcement_type }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($announcement->description, 20, '...')  }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $announcement->announcement_asset) }}" class="bi bi-file-earmark-fill text-primary text-decoration-underline" download></a>
                    </td>
                    <td>{{ $announcement->user->name .' ('. Str::title($announcement->user->user_type) .')' }}</td>
                    <td>{{ $announcement->created_at }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="my-dropbtn btn btn-transparent border-0 dropdown-toggle shadow-none"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1000;">
                                <li>
                                    <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#viewAnnouncementModal{{ $announcement->id }}" style="cursor: pointer;">
                                        <i class="bi bi-eye-fill me-1"></i> Tazama
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#editAnnouncementModal{{ $announcement->id }}" style="cursor: pointer;">
                                        <i class="bi bi-pen-fill me-1"></i> Hariri
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#deleteAnnouncementModal{{ $announcement->id }}">
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


        @if($announcements->count() > 0)
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                <div class="text-muted small mb-2">
                    Ukurasa {{ $announcements->currentPage() }} ya {{ $announcements->lastPage() }} | Jumla ya
                    Matangazo: {{ $announcements->total() }}
                </div>
                <nav aria-label="Page navigation">
                    {{ $announcements->links('vendor.pagination.custom-bootstrap') }}
                </nav>
            </div>
        @else
            <div></div>
        @endif

    </div>




    <!-- Modal - ADMIN USER VIEW -->
    @foreach($announcements as $announcement)
        <div class="modal fade" id="viewAnnouncementModal{{ $announcement->id }}" tabindex="-1"
             aria-labelledby="viewAnnouncementModal{{ $announcement->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewAnnouncementModal{{ $announcement->id }}Label">Tazama Tangazo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Aina ya Tangazo</label>
                            <input type="text" value="{{ $announcement->announcement_type }}" class="form-control fw-bold" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Maelezo ya Tangazo</label>
                            {{-- <input type="text" value="{{ $announcement->description }}" class="form-control fw-bold" readonly>--}}
                            <textarea name="description" id="description" class="form-control w-100" style="max-height: 90px; min-height: 60px; height: 70px;">{{ $announcement->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Faili La Tangazo (Jina la Faili)</label>
                            <div class="p-2 rounded d-flex align-items-center justify-content-start w-100" style="background-color: #00000020;">
                                <i class="bi bi-file-earmark-fill text-black mx-2"></i> <div>{{ Str::limit($announcement->announcement_asset, 20, '...') }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Alie Unda</label>
                                    <input type="text" value="{{ $announcement->user->name .' ('. Str::title($announcement->user->user_type) .')' }}" class="form-control fw-bold" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="created_at" class="form-label">Tarehe ya Kuundwa</label>
                                    <input type="text" value="{{ $announcement->created_at }}" class="form-control fw-bold" readonly>
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



    <!-- Modal - ADMIN GROUP EDIT -->
    @foreach($announcements as $announcement)
        <div class="modal fade" id="editAnnouncementModal{{ $announcement->id }}" tabindex="-1"
             aria-labelledby="editAnnouncementModal{{ $announcement->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.edit.group') }}" method="POST" x-data="{ loading: false }"
                          @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editAnnouncementModal{{ $announcement->id }}Label">Hariri Tangazo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $announcement->id }}">
                            <input type="hidden" name="user_id" value="{{ $announcement->user_id }}">

                            <div class="mb-3">
                                <label for="announcement_asset" class="form-label">Faili la Tangazo</label>
                                @php
                                    $value = false;
                                    $value = $announcement->announcement_asset != null;
                                @endphp
                                @if($value)
                                    <div class="p-2 d-flex align-items-center justify-content-start rounded w-100" style="background-color: #00000020">
                                        <button type="button" class="btn bi bi-pen-fill text-primary"></button>
                                        <i class="bi bi-file-earmark-fill text-dark mx-3"></i> {{ Str::limit($announcement->announcement_asset, 20, '...') }}
                                    </div>
                                @else
                                    <input type="file" name="announcement_asset" id="announcement_asset" class="form-control" value="{{ old('announcement_asset', asset('storage/' . $announcement->announcement_asset)) }}">
                                @endif
                                @error('announcement_asset')  <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="announcement_type" class="form-label">Aina ya Tangazo</label>
                                <select name="announcement_type" id="announcement_type" class="form-select">
                                    <option value="">--chagua aina tangazo--</option>
                                    @if($announcement->announcement_type == 'Ibada ya Kwanza (Jumapili)')
                                        <option value="Ibada ya Kwanza (Jumapili)" selected>Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Ibada ya Pili (Jumapili)')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)" selected>Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Ibada ya Tatu (Jumapili)')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)" selected>Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Ibada ya Nne (Jumapili)')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)" selected>Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Ibada ya Kawaida')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida" selected>Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Tanzia')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia" selected>Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Ndoa')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa" selected>Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Watoto (Shule ya Jumapili')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)" selected>Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @elseif($announcement->announcement_type == 'Nyumba kwa Nyumba')
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba" selected>Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo">Nyinginezo</option>
                                    @else
                                        <option value="Ibada ya Kwanza (Jumapili)">Ibada ya Kwanza (Jumapili)</option>
                                        <option value="Ibada ya Pili (Jumapili)">Ibada ya Pili (Jumapili)</option>
                                        <option value="Ibada ya Tatu (Jumapili)">Ibada ya Tatu (Jumapili)</option>
                                        <option value="Ibada ya Nne (Jumapili)">Ibada ya Nne (Jumapili)</option>
                                        <option value="Ibada ya Kawaida">Ibada ya Kawaida</option>
                                        <option value="Tanzia">Tanzia</option>
                                        <option value="Ndoa">Ndoa</option>
                                        <option value="Watoto (Shule ya Jumapili)">Watoto (Shule ya Jumapili)</option>
                                        <option value="Nyumba kwa Nyumba">Nyumba kwa Nyumba</option>
                                        <option value="Nyinginezo" selected>Nyinginezo</option>
                                    @endif
                                </select>
                                @error('announcement_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Maelezo</label>
                                <textarea name="description" id="description" placeholder="Ingiza maelezo" class="form-control w-100" style="max-height: 100px; min-height: 50px; height: 70px;">{{ old('description', $announcement->description) }}</textarea>
                                @error('description')  <span class="text-danger">{{ $message }}</span> @enderror
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
    @foreach($announcements as $announcement)
        <div class="modal fade" id="deleteAnnouncementModal{{ $announcement->id }}" tabindex="-1"
             aria-labelledby="deleteAnnouncementModal{{ $announcement->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-o">
                        <h1 class="modal-title fs-5" id="deleteAnnouncementModal{{ $announcement->id }}Label">Futa Kikundi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Unauwakika wa kufuta kikundi hichi chenye jina <span
                                class="fst-italic text-success">{{ '#' . $announcement->name }}</span>?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sitisha</button>
                        <form method="GET" action="{{ route('admin.delete.group', $announcement->id) }}"
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
    <div class="modal fade" id="deleteSelectedAnnouncementModal" tabindex="-1" aria-labelledby="deleteSelectedAnnouncementModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-o">
                    <h1 class="modal-title fs-5" id="deleteSelectedAnnouncementModalLabel">
                        @if(count($selectedAnnouncements) > 1)
                            Futa Matangazo
                        @elseif(count($selectedAnnouncements) == 1)
                            Futa Tangazo
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($selectedAnnouncements) > 1)
                        <p>Unauwakika wa kufuta matangazo haya?</span>?</p>
                    @elseif(count($selectedAnnouncements) == 1)
                        <p>Unauwakika wa kufuta tangazo hili?</span>?</p>
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
                                @if(count($selectedAnnouncements) > 1)
                                    Futa Vikundi
                                @elseif(count($selectedAnnouncements) == 1)
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

