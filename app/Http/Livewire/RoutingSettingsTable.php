<?php

namespace App\Http\Livewire;

use App\Models\AmountConfig;
use App\Models\CardConfig;
use App\Models\Processor;
use Livewire\Component;
use Livewire\WithPagination;

class RoutingSettingsTable extends Component
{
    use WithPagination;

    public $component = 'RoutingSettings';

    public array $item = [];
    public string $type = 'AMOUNT';
    public $processors = [];
    public bool $updating = false;
    public string $msg = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'item.min_amount'   => 'required|min:1',
        'item.max_amount'   => 'required|min:1',
        'item.primary_id'   => 'required',
        'item.secondary_id' => 'required',
        'item.card_type'    => '',
    ];
    protected $messages = [
        'item.min_amount.required' => 'Minimum amount is required.',
        'item.max_amount.required' => 'Maximum amount is required.',
    ];


    public array $order = [
        'by' => 'id',
        'direction' => 'desc'
    ];

    public function render()
    {
        if ( $this->type == 'AMOUNT' ) {
            $items = AmountConfig::orderBy($this->order['by'], $this->order['direction'])->get();
        }
        else {
            $items = CardConfig::orderBy($this->order['by'], $this->order['direction'])->get();
        }

        $this->dispatchBrowserEvent('reload-scripts');
        return view('pages.routing.settings-view', compact('items'));
    }

    public function sortBy($column)
    {
        $this->order['by'] =  $column;
        $this->order['direction'] = $this->order['direction'] == 'asc' ? 'desc' : 'asc';

        $this->emit('refreshComponent');
    }

    public function updated($propertyName)
    {
        $this->dispatchBrowserEvent('console.log', $propertyName);
        $this->validateOnly($propertyName);
    }

    public function add()
    {
        $this->item['primary_id'] = 1;
        $this->item['secondary_id'] = 1;

        $this->emit('addRoutingSettingModal', $this->type);
    }

    public function save()
    {
        // validate request
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $m = str_contains($e->getMessage(), '. (') ? explode('. (', $e->getMessage())[0] : $e->getMessage();
            $this->emit('notify-error', $m);
            $this->validate();
        }

        //
        $this->msg = "Adding to {$this->type} setting";
        $this->updating = true;

        // perform update.
        if ( $this->type == 'AMOUNT' ) {
            $data = AmountConfig::firstOrNew(
                ['min_amount' => $this->item['min_amount'], 'max_amount' => $this->item['max_amount']],
                [
                    'primary_id' => $this->item['primary_id'],
                    'secondary_id' => $this->item['secondary_id'],
                    'primary' => Processor::find($this->item['primary_id'])->name,
                    'secondary' => Processor::find($this->item['secondary_id'])->name,
                ]
            );
        }
        else {
            $data = CardConfig::firstOrNew(
                ['card_type' => $this->item['card_type']],
                [
                    'primary_id' => $this->item['primary_id'],
                    'secondary_id' => $this->item['secondary_id'],
                    'primary' => Processor::find($this->item['primary_id'])->name,
                    'secondary' => Processor::find($this->item['secondary_id'])->name,
                ]
            );
        }

        $data->save();

        $this->msg = "Awaiting approval for adding new {$this->type} setting";

        sleep(1);

        // close slideOver modal
        $this->emit('addRoutingSettingModal', 'close');


        // refresh to get updated content.
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->msg]);
    }


    public function edit( $item )
    {
        $this->item = $item;
        $this->emit('editRoutingSettingModal', $item);
    }

    public function delete( $item )
    {
        if ( $this->type == 'AMOUNT' ) {
            AmountConfig::find($item['id'])->delete();
        }
        else {
            CardConfig::find($item['id'])->delete();
        }

        // refresh to get updated content.
        $this->msg = "$this->type Setting deletion awaiting approval!";
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->msg]);
    }


    public function update()
    {
        // validate request
        $this->validate();

        //
        $this->msg = "Updating {$this->type} setting";
        $this->updating = true;

        // perform update.
        if ( $this->type == 'AMOUNT' ) {
            $data = AmountConfig::find($this->item['id']);
            $data->min_amount = $this->item['min_amount'];
            $data->max_amount = (float) $this->item['max_amount'];
            $data->primary_id = $this->item['primary_id'];
            $data->secondary_id = $this->item['secondary_id'];
            $data->primary = Processor::find($data->primary_id)->name;
            $data->secondary = Processor::find($data->secondary_id)->name;
        }
        else {
            $data = CardConfig::find($this->item['id']);
            $data->name = $this->item['name'];
            $data->primary_id = $this->item['primary_id'];
            $data->secondary_id = $this->item['secondary_id'];
            $data->primary = Processor::find($data->primary_id)->name;
            $data->secondary = Processor::find($data->secondary_id)->name;
        }

        $data->save();

        $this->msg = "Awaiting approval for {$this->type} setting update";

        sleep(1);

        // close slideOver modal
        $this->emit('editRoutingSettingModal', 'close');


        // refresh to get updated content.
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->msg]);
    }
}
