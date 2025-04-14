<div>
        <div class="px-3">
            {{-- Download Example File --}}
            <div class="mb-3">
                <label class="form-label">Chukua Faili (Download)</label>
                <div class="rounded-2 p-3" style="background-color: rgba(101,101,101,0.13);">
                    <a class="text-dark text-decoration-none" href="{{ asset('assets/mfano-washirika-excel.xlsx') }}" download>
                        <i class="fs-3 bi bi-file-earmark-excel-fill mx-3"></i>
                        <span style="font-size: 15px;">Mfano wa Excel ya Washirika na Orodha ya Vikundi</span>
                    </a>
                </div>
            </div>


            {{-- Upload Filled Excel File --}}
            <div class="mb-3">
                <label class="form-label">
                    Weka Faili Lililojazwa (Kufuata Mpangilio wa File Hapo Juu)
                </label>

                <div id="fileBox" class="rounded-2 p-3 d-flex justify-content-between align-items-center"
                     style="background-color: rgba(101,101,101,0.13); cursor: pointer;"
                     onclick="document.getElementById('membersExcel').click();">

                    <span id="fileLabel">
                        <i class="bi bi-paperclip mx-3 fs-3"></i> Chagua kutoka kwenye kifaa chako
                    </span>

                    {{-- Cancel Button (Initially Hidden) --}}
                    <button id="cancelBtn" type="button" class="btn btn-close text-light d-none"
                            onclick="cancelFileSelection(event)">
{{--                        <i class="bi bi-x"></i>--}}
                    </button>
                </div>

                @error('membersExcel') <span class="text-danger">{{ $message }}</span> @enderror

                {{-- Hidden File Input --}}
                <input type="file" name="membersExcel" id="membersExcel" class="d-none" required onchange="updateFileLabel(this)">
            </div>

            {{-- JavaScript --}}
            <script>
                function updateFileLabel(input) {
                    const label = document.getElementById('fileLabel');
                    const fileBox = document.getElementById('fileBox');
                    const cancelBtn = document.getElementById('cancelBtn');

                    if (input.files && input.files.length > 0) {
                        label.innerHTML = `<i class="bi bi-check-circle-fill text-success me-2"></i> Faili imeshikiliwa kikamilifu`;
                        fileBox.style.backgroundColor = "rgba(60,179,113,0.65)";
                        cancelBtn.classList.remove('d-none');
                    }
                }

                function cancelFileSelection(event) {
                    event.stopPropagation(); // prevent triggering file select

                    const fileInput = document.getElementById('membersExcel');
                    const label = document.getElementById('fileLabel');
                    const fileBox = document.getElementById('fileBox');
                    const cancelBtn = document.getElementById('cancelBtn');

                    // Reset file input
                    fileInput.value = '';
                    // Reset UI
                    label.innerHTML = `<i class="bi bi-paperclip mx-3 fs-3"></i> Chagua kutoka kwenye kifaa chako`;
                    fileBox.style.backgroundColor = "rgba(101,101,101,0.13)";
                    cancelBtn.classList.add('d-none');
                }
            </script>
        </div>
</div>
