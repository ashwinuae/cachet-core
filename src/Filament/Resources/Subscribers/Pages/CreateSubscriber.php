<?php

namespace Cachet\Filament\Resources\Subscribers\Pages;

use Cachet\Filament\Resources\Subscribers\SubscriberResource;
use Cachet\Models\Subscriber;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscriber extends CreateRecord
{
    protected static string $resource = SubscriberResource::class;

    protected function afterCreate(): void
    {
        /** @var Subscriber $subscriber */
        $subscriber = $this->record;

        if (! $subscriber->hasVerifiedEmail()) {
            $subscriber->sendEmailVerificationNotification();
        }
    }
}
