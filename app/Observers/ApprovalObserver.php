<?php

namespace App\Observers;

use Cjmellor\Approval\Models\Approval;

class ApprovalObserver
{
    /**
     * Handle the Approval "created" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function creating(Approval $approval)
    {
        $approval->performed_by = auth()->id();
    }

    /**
     * Handle the Approval "created" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function created(Approval $approval)
    {
        // Todo: send mail to approvers for new action
    }

    /**
     * Handle the Approval "updated" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function updated(Approval $approval)
    {
        //
    }

    /**
     * Handle the Approval "deleted" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function deleted(Approval $approval)
    {
        //
    }

    /**
     * Handle the Approval "restored" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function restored(Approval $approval)
    {
        //
    }

    /**
     * Handle the Approval "force deleted" event.
     *
     * @param  \App\Models\Approval  $approval
     * @return void
     */
    public function forceDeleted(Approval $approval)
    {
        //
    }
}
