<?php

namespace App\Listeners;

use App\Events\Approval;
use App\Jobs\ApprovalEmailJob;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailForApproval
{
    public $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  Approval  $event
     * @return void
     */
    public function handle(Approval $event)
    {
        $delay = now()->addSeconds(10);
        ApprovalEmailJob::dispatch($event->user)->delay($delay);
    }
}
