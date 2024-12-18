<?php

namespace App\Observer;

use App\Models\Usage;
use App\Models\User;
use Exception;
use Spatie\Newsletter\Facades\Newsletter;

class UserObserver
{
    public function created($user): void
    {

        Usage::getSingle()->updateUserCount(1);

        $user->update(['entity_credits' => User::getFreshCredits()]);

        if ((int) setting('mailchimp_register') === 1) {
            try {
                Newsletter::subscribeOrUpdate(
                    $user->email,
                    ['FNAME' => $user->name, 'LNAME' => $user->surname],
                );
            } catch (Exception $e) {
            }
        }

        if ((int) setting('hubspot_crm_contact_register') === 1) {
            try {
                (new \App\Extensions\Hubspot\System\Services\HubspotService)->createCrmContacts($user->email, $user->name, $user->surname);
            } catch (Exception $e) {
            }
        }
    }
}
