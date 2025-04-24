<div>
    <div class="mb-3">
        <label for="member_id" class="form-label">Namba ya Mshirika</label>
        <input type="text" class="form-control" name="member_id"
               value="{{ old('member_id', $leader?->member?->member_id) }}"
               wire:model.live="inputMemberId"
               wire:input.live="findMemberId"
               placeholder="Ingiza namba ya Mshirika">


    @if ($memberNameReturned)
            <div class="d-flex align-items-center">
                <span wire:loading.class="spinner-border spinner-border-sm me-2" role="status"
                      aria-hidden="true"></span>

                @if (\Illuminate\Support\Str::startsWith($memberNameReturned, 'Hakuna'))
                    <div class="mt-2 text-danger">{{ $memberNameReturned }}</div>
                @else
                    <div class="mt-2 text-success">{{ $memberNameReturned }}</div>
                @endif
            </div>
        @endif
        @error('member_id') <span class="text-danger mt-2">{{ $message }}</span> @enderror
    </div>
</div>
