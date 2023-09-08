<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServiceStatus extends Component
{
    public Service $service;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.service-status');
    }

    public function update() {
        $this->service->is_available = (! $this->service->is_available);
        $this->service->save();

        $this->emit('refresh');
        $this->dispatchBrowserEvent('pending', ['message' => 'Service status update awaiting approval!']);
    }
}
