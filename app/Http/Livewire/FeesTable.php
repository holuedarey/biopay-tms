<?php

namespace App\Http\Livewire;

use App\Models\Config;
use App\Models\Fee;
use App\Models\TerminalGroup;
use Livewire\Component;
use Livewire\WithPagination;

class FeesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $message = '';

    public $fee;
    public $groupId;

    protected $rules = [
        'fee.title' => 'required',
        'fee.type' => 'required',
        'fee.amount' => 'required',
        'fee.amount_type' => 'required',
        'fee.cap' => 'required',
    ];

    public function render()
    {
        if ( is_null($this->groupId) ) {
            $this->groupId = (int) Config::getValue('DEFAULT_GROUP_ID');
        }

        $group = TerminalGroup::find($this->groupId);

        $title = "FEES for `$group->name`";

        $fees = $group->fees->load(['service', 'group']);

        $this->dispatchBrowserEvent('reload-scripts');
        return view('pages.fees.table-data', compact('fees', 'title'));
    }

    public function edit( Fee $fee )
    {
        $this->fee = $fee;
        return $this->redirect(route('fees.edit', [$fee->id]));
//        $this->emit('editFeeModal', $this->fee);
    }


    public function update()
    {
        // validate request
        $this->validate();

        //
        $this->updating = true;

        // perform update.
        $this->fee->update();

        $this->message = 'Update Successful!';

        sleep(1);

        // close slideOver modal
        $this->emit('editFeeModal', 'close');

        // refresh to get updated content.
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->message]);
    }
}
