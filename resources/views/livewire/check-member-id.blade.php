<div>
    <div class="mb-3" wire:loading.class="opacity-25">
        <label for="member_id" class="form-label">Namba ya Mshirika</label>
        <input type="text" class="form-control"
               wire:model.debounce.500ms="inputMemberId"
               wire:change="findMemberId"
               placeholder="Ingiza namba ya Mshirika">

        @if ($memberNameReturned)
            @if (Str::startsWith($memberNameReturned, 'Hakuna'))
                <div class="mt-2 text-danger">{{ $memberNameReturned }}</div>
            @else
                <div class="mt-2 text-success">{{ $memberNameReturned }}</div>
            @endif
        @endif
        @error('member_id') <span class="text-danger mt-2">{{ $message }}</span> @enderror
    </div>
</div>
