<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use App\Models\TerminalProcessor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalProcessorsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $component = 'TerminalProcessors';

    public string $message = '';

    public TerminalProcessor $terminalProcessor;

    protected $listeners = ['refreshComponent' => '$refresh', "litepickerTerminals"];

    // validation rules [fill the details up]
    protected $rules = [
        'terminal.tid' => 'required',
        'terminal.mid' => 'required',
    ];

    public string $perPage;

    public string $fields = '[{field: "serial", name: "SERIAL"},{field: "tid", name: "TERMINAL ID"},{field: "mid", name: "MERCHANT ID"},{field: "currency_code", name: "CURRENCY CODE"},{field: "country_code", name: "COUNTRY CODE"},{field: "category_code", name: "MERCHANT CODE"},{field: "name_location", name: "NAME/LOCATION"},{field: "created_at", name: "DATE"}]';

    public array $order = [
        'by' => 'id',
        'direction' => 'desc'
    ];

    public array $search = [
        'field' => 'id',
        'operator' => '=',
        'value' => ''
    ];

    public function mount()
    {
        $this->perPage = config('app.pagination');
    }


    public function render()
    {
        $terminalProcessors = TerminalProcessor::with('owner');

        if ( !empty($this->search['value']) ) {
            $field = $this->search['field'];
            $operator = $this->search['operator'];
            $value = $this->search['value'];

            $date = [];

            if ( $operator == 'like' ) {
                $value = "%$value%";
                $value = strtolower($value);
                $field = DB::raw("lower($field)");
            }

            if ( $field == 'id' ) {
                $value = (int) $value ?? 0;
            }

            $terminalProcessors = $terminalProcessors->where($field, $operator, $value);
        }

        if ( $this->order['by'] == 'created_at' ) {
            if ( $this->order['direction'] == 'asc' ) {
                $terminalProcessors = $terminalProcessors->oldest();
            } else {
                $terminalProcessors = $terminalProcessors->latest();
            }
        } else {
            $terminalProcessors = $terminalProcessors->orderBy($this->order['by'], $this->order['direction']);
        }

        // get results
        $terminalProcessors = $terminalProcessors->paginate($this->perPage);

        $this->dispatchBrowserEvent('reload-scripts');

        return view('pages.terminal-processors.table', compact('terminalProcessors'));
    }


    public function litepickerTerminals( $date )
    {
        $this->search['value'] = $date;
    }

    public function changePerPage()
    {
        $this->emit('refreshComponent');
    }

    public function sortBy($column)
    {
        $this->order['by'] =  $column;
        $this->order['direction'] = $this->order['direction'] == 'asc' ? 'desc' : 'asc';

//        $this->dispatchBrowserEvent('console.log', $this->order);
    }

    public function searchData()
    {
        $this->emit('refreshComponent');
    }

    public function edit( Terminal $terminal )
    {
        $this->terminal = $terminal;
        $this->emit('editTerminalModal', $terminal);
    }

    public function delete( Terminal $terminal )
    {
        $terminal->delete();

        // refresh to get updated content.
        $this->message = 'Terminal deleted Successfully!';
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->message]);
    }


    public function update()
    {
        // validate request
        $this->validate();

        //
        $this->updating = true;

        // perform update.
        $this->group->update();

        $this->message = 'Update Successful!';

        sleep(1);

        // close slideOver modal
        $this->emit('editTerminalModal', 'close');

        // refresh to get updated content.
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->message]);
    }
}
