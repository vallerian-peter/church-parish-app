<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="father_member_id" class="form-label">Namba ya Mshirika (Baba)</label>
            <input
                type="text"
                class="form-control"
                name="father_member_id"
                wire:model.live="inputFatherMemberId"
                wire:input.live="findFatherMemberId"
                value="{{ old('father_member_id') }}"
                id="father_member_id"
                placeholder="Ingiza namba ya mshirika ya baba...">

            @if ($fatherNameReturned)
                <div class="d-flex align-items-center">
                <span wire:loading.class="spinner-border spinner-border-sm me-2" role="status"
                      aria-hidden="true"></span>

                    @if (\Illuminate\Support\Str::startsWith($fatherNameReturned, 'Hakuna'))
                        <div class="mt-2 text-danger">{{ $fatherNameReturned }}</div>
                    @else
                        <div class="mt-2 text-success">{{ $fatherNameReturned }}</div>
                    @endif
                </div>
            @endif
            @error('father_member_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="mother_member_id" class="form-label">Namba ya Mshirika (Mama)</label>
            <input
                type="text"
                class="form-control"
                name="mother_member_id"
                wire:model.live="inputMotherMemberId"
                value="{{ old('mother_member_id') }}"
                wire:input.live="findMotherMemberId"
                id="mother_member_id"
                placeholder="Ingiza namba ya mshirika ya mama...">

            @if ($motherNameReturned)
                <div class="d-flex align-items-center">
                <span wire:loading.class="spinner-border spinner-border-sm me-2" role="status"
                      aria-hidden="true"></span>

                    @if (\Illuminate\Support\Str::startsWith($motherNameReturned, 'Hakuna'))
                        <div class="mt-2 text-danger">{{ $motherNameReturned }}</div>
                    @else
                        <div class="mt-2 text-success">{{ $motherNameReturned }}</div>
                    @endif
                </div>
            @endif
            @error('mother_member_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
