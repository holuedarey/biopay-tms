<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $component = 'Terminals';

    public TerminalGroup|null $group = null;

    public string $message = '';

    public Terminal $terminal;

    protected $listeners = ['refreshComponent' => '$refresh', "litepickerTerminals"];

    // validation rules [fill the details up]
    protected $rules = [
        'terminal.tid' => 'required',
        'terminal.mid' => 'required',
    ];

    public string $perPage;

    public string $fields = '[{field: "device", name: "DEVICE ID"},{field: "tid", name: "TERMINAL ID"},{field: "mid", name: "MERCHANT ID"},{field: "serial", name: "SERIAL NUMBER"},{field: "created_at", name: "DATE"}]';

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
        $terminals = is_null($this->group) ? Terminal::with('agent') :
            Terminal::whereBelongsTo($this->group, 'group')->with('agent');

        if ( !empty($this->search['value']) ) {
            $field = $this->search['field'];
            $operator = $this->search['operator'];
            $value = $this->search['value'];

            $date = [];

            switch ( $field ) {
                case 'id':
                    if ( $operator == 'like' ) {
                        $operator = '=';
                    }
                    break;

                case 'created_at':
                    $date = explode(' - ', $value);
                    break;

                default:
                    if ( $operator == 'like' ) {
                        $value = "%$value%";
                        $value = strtolower($value);
                        $field = DB::raw("lower($field)");
                    }
                    break;
            }


            if ( $field == 'id' ) {
                $value = (int) $value ?? 0;
            }


            if ( $field == 'created_at' ) {
                $terminals = $terminals->whereDate($field, '>=', $date[0])
                    ->whereDate($field, '<=', $date[1]);
            }
            else {
                $terminals = $terminals->where($field, $operator, $value);
            }
        }

        if ( $this->order['by'] == 'created_at' ) {
            if ( $this->order['direction'] == 'asc' ) {
                $terminals = $terminals->oldest();
            } else {
                $terminals = $terminals->latest();
            }
        } else {
            $terminals = $terminals->orderBy($this->order['by'], $this->order['direction']);
        }

        // get results
        $terminals = $terminals->with('menus')->paginate($this->perPage);

        $this->dispatchBrowserEvent('reload-scripts');

        return view('pages.terminals.table', compact('terminals'));
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
