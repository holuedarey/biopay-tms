<div>
    <div class="form-check form-switch tooltip" title="{{ $service->is_available ? 'Deactivate' : 'Activate' }}">
        <input id="checkbox-switch-7" class="form-check-input" type="checkbox"
               @checked($service->is_available) wire:click="update" wire:key="{{ $service->id }}"
        >
    </div>
</div>
