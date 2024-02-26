<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Http\Requests\TerminalRequest;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TerminalsApi extends Controller
{
    public $component = 'Terminals';

    public TerminalGroup|null $group = null;

    public string $message = '';

    public Terminal $terminal;

    public array $order = [
        'by' => 'id',
        'direction' => 'desc'
    ];

    public array $search = [
        'field' => 'id',
        'operator' => '=',
        'value' => ''
    ];
    public string $perPage;
    public function __construct()
    {
        $this->authorizeResource(Terminal::class);
        $this->perPage = config('app.pagination');
    }


    public function index()
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

        return  MyResponse::staticSuccess('Data Retrieved Successfully',compact('terminals'));
    }


    public function store(TerminalRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        Terminal::create([
            'user_id'   => $user->id,
            'device'    => $request->device,
            'tid'       => Terminal::generateTid($user->phone),
            'mid'       => str_pad('2023', 14, '0', STR_PAD_RIGHT),
            'serial'    => $request->serial,
            'group_id'  => $request->group_id,
        ]);
        return  MyResponse::staticSuccess("New $user->email Terminal - $request->tid awaiting approval! ");
    }

    public function update(TerminalRequest $request, Terminal $terminal)
    {
        $terminal->update($request->validated());
        return  MyResponse::staticSuccess('Terminal update awaiting approval.');
    }
}
