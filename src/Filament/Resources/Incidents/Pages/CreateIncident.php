<?php

namespace Cachet\Filament\Resources\Incidents\Pages;

use Cachet\Actions\Incident\NotifyIncidentSubscribers;
use Cachet\Filament\Resources\Incidents\IncidentResource;
use Cachet\Models\Incident;
use Filament\Resources\Pages\CreateRecord;

class CreateIncident extends CreateRecord
{
    protected static string $resource = IncidentResource::class;

    protected function afterCreate(): void
    {
        /** @var Incident $incident */
        $incident = $this->record;

        app(NotifyIncidentSubscribers::class)->handle($incident);
    }
}
