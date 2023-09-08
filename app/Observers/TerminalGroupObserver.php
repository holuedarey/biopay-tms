<?php

namespace App\Observers;

use App\Models\Fee;
use App\Models\TerminalGroup;
use Illuminate\Support\Facades\Cache;

class TerminalGroupObserver
{
    public function created(TerminalGroup $terminalGroup)
    {
        Fee::createDefault($terminalGroup->id);

        Cache::forget('terminal_groups');
    }

    public function updated(TerminalGroup $terminalGroup)
    {
        Cache::forget('terminal_groups');
    }
}
