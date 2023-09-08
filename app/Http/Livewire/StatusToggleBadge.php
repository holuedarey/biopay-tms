<?php

namespace App\Http\Livewire;

use App\Models\Terminal;
use App\Models\Wallet;
use Livewire\Component;

class StatusToggleBadge extends Component
{
    public Wallet|Terminal $model;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.status-toggle-badge');
    }

    public function updateStatus()
    {
        if (!$this->model->agent->is_active && !$this->model->is_active) {
            $this->dispatchBrowserEvent('error', [
                'message' => "Cannot change status because {$this->model->agent->name} is {$this->model->agent->status}."
            ]);
        }
        else {
            $this->model->changeStatus();

            $name = class_basename($this->model);
            $msg = $name == 'Wallet' ? ' status updated.' : ' status update awaiting approval.';
            $this->dispatchBrowserEvent('pending', ['message' => $name . $msg]);
        }

        $this->emit('refresh');
    }
}
