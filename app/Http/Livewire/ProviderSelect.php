<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\ServiceProvider;
use Livewire\Component;

class ProviderSelect extends Component
{
    public Service $service;

    public int|null $provider_id;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->provider_id = $this->service->provider_id;
    }


    public function render()
    {
        return view('livewire.provider-select');
    }

    public function update(): void
    {
        $this->service->provider_id = $this->provider_id;
        $this->service->save();

        $this->emit('refresh');

        $this->dispatchBrowserEvent('pending', [
            'message' => "Provider update for {$this->service->name} service awaiting approval!"
        ]);
    }
}
