<?php

namespace App\Http\Livewire;

use App\Models\TerminalGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TerminalGroupsTable extends Component
{
    use WithPagination;

    public $component = 'TerminalGroups';
    protected $paginationTheme = 'tailwind';

    public string $message = '';
    public TerminalGroup $group;

    protected $listeners = ['refreshComponent' => '$refresh', "litepickerTerminalGroups"];

    protected $rules = [
        'group.name' => 'required',
        'group.info' => '',
    ];

    public string $perPage;

    public string $fields = '[{field: "id", name: "ID"}, {field: "name", name: "NAME"},{field: "created_at", name: "DATE"}]';

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

                case 'name':
                    if ( $operator == 'like' ) {
                        $value = "%$value%";
                        $value = strtolower($value);
                        $field = DB::raw("lower($field)");
                    }
                    break;

                case 'created_at':
                    $date = explode(' - ', $value);
                    break;

                default:
                    break;
            }


            if ( $field == 'id' ) {
                $value = (int) $value ?? 0;
            }


            if ( $field == 'created_at' ) {
                $groups = TerminalGroup::orderBy($this->order['by'], $this->order['direction'])
                    ->whereDate($field, '>=', $date[0])
                    ->whereDate($field, '<=', $date[1])
                    ->paginate($this->perPage);
            }
            else {
                $groups = TerminalGroup::orderBy($this->order['by'], $this->order['direction'])
                    ->where($field, $operator, $value)
                    ->paginate($this->perPage);
            }
        }
        else {
            $groups = TerminalGroup::orderBy($this->order['by'], $this->order['direction'])
                ->paginate($this->perPage);
        }

        $this->dispatchBrowserEvent('reload-scripts');
        return view('pages.terminal-groups.table-data', compact('groups'));
    }

    public function litepickerTerminalGroups( $date )
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

        $this->emit('refreshComponent');
    }

    public function searchData()
    {
        $this->emit('refreshComponent');
        $this->dispatchBrowserEvent('reload-scripts');
    }

    public function edit( TerminalGroup $group )
    {
        $this->group = $group;
        $this->emit('editGroupModal', $this->group);
    }

    public function delete( TerminalGroup $group )
    {
        $group = $group;
        $group->delete();

        // refresh to get updated content.
        $this->message = 'Group deleted Successfully!';
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
        $this->emit('editGroupModal', 'close');

        // refresh to get updated content.
        $this->emit('refreshComponent');

        // show messages for updated
        $this->dispatchBrowserEvent('success', ['message' => $this->message]);
    }
}
