<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserCreated;
use App\Models\Address;

class HandleUserAddress
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
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        
        if (request()->has('addresses')) {
            $addresses = request()->input('addresses');

            foreach ($addresses as $addressData) {
                $user->addresses()->updateOrCreate(
                    ['id' => $addressData['id'] ?? null], 
                    $addressData
                );
            }
        }
    }
}
