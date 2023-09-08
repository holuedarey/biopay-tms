<?php

namespace App\Http\Livewire;

use App\Models\GeneralLedger;
use App\Models\GLT;
use Livewire\Component;
use Livewire\WithPagination;

class GlTable extends Component
{
    use WithPagination;

    public string $title;

    public string $name = 'other';

    public ?GeneralLedger $gl = null;

    public string $date = '';

    public ?array $date_filter = null;

    public function render()
    {
        $glts = is_null($this->gl) ?
            GLT::whereNot('gl_id', 1)
                ->filterByDate($this->date_filter)
                ->with('generalLedger.service')->paginate()
            :
            $this->gl->glts()->latest()->filterByDate($this->date_filter)->paginate();

        return view('pages.general-ledger.table', compact('glts'));
    }

    public function filterDate(string $date = null): void
    {
        $this->date = $date ?? '';

        $this->date_filter = is_null($date) ? null : str($date)->explode(' - ')->toArray();
    }
}
