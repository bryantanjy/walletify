<?php

namespace App\Listeners;

use App\Models\Account;
use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultAccount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $account = new Account([
            'name' => 'Cash',
            'type' => 'General', // Adjust the type as needed
        ]);

        // Save the account in relation to the new user
        $event->user->accounts()->save($account);
    }
}
