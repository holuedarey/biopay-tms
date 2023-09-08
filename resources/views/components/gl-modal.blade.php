@props(['gl'])

<x-modal :modal-id="'modal'. $gl->id" :modal-title="'Fund ' . $gl->service->name . ' General Ledger'" :is-large="false">
    <form action="{{ route('general-ledger.update', $gl) }}" method="post" class="my-form col-span-12">
        @csrf

        <div class="flex justify-start items-center gap-4">
            <div class="mb-2">
                <label for="amount" class="form-label">Amount</label>
            </div>
            <div class="w-full">
                <input type="number" class="form-control w-full" placeholder="0.00" min="0"
                       aria-label="amount for general ledger" name="amount" value="{{ old('amount') }}" required
                />
                <br />
                <x-input-error :input-name="$error = 'amount'" />
            </div>
        </div>
        <div class="flex justify-end mt-7 pt-3 border-t">
            <button type="submit" class="btn btn-primary w-24 py-1">Fund</button>
        </div>
    </form>
</x-modal>
