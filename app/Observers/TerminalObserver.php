<?php

namespace App\Observers;

use App\Helpers\General;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\TerminalProcessor;

class TerminalObserver
{
    /**
     * Handle the Terminal "created" event.
     */
    public function creating(Terminal $terminal): void
    {
        $terminal->status = 'ACTIVE';
        $terminal->tmk = strtoupper(General::generateReference(length: 36));
        $terminal->tpk = strtoupper(General::generateReference(length: 36));
        $terminal->tsk = strtoupper(General::generateReference(length: 36));
        $terminal->date_time = now()->format('d/m/y H:i');
        $terminal->category_code = '1234';
        $terminal->name_location = General::generateNameLocation($terminal->owner->name);
    }

    /**
     * Handle the Terminal "updated" event.
     */
    public function created(Terminal $terminal): void
    {
        $terminal->menus()->attach(Service::all());

        TerminalProcessor::createForTerminal($terminal);
    }

    /**
     * Handle the Terminal "updated" event.
     */
    public function updated(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "deleted" event.
     */
    public function deleted(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "restored" event.
     */
    public function restored(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "force deleted" event.
     */
    public function forceDeleted(Terminal $terminal): void
    {
        //
    }
}
