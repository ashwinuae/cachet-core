<?php

namespace Tests\Feature\Filament\Resources;

use Cachet\Filament\Resources\Users\Pages\EditUser;
use Filament\Facades\Filament;
use Workbench\App\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('cachet'));

    actingAs(User::factory()->create(['is_admin' => true]));
});

it('can edit a user without changing their email', function () {
    $user = User::factory()->create(['email' => 'james@example.com']);

    livewire(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm(['name' => 'Renamed User'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->fresh())
        ->name->toBe('Renamed User')
        ->email->toBe('james@example.com');
});

it('cannot change a user email to one that is already taken', function () {
    User::factory()->create(['email' => 'taken@example.com']);
    $user = User::factory()->create(['email' => 'james@example.com']);

    livewire(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm(['email' => 'taken@example.com'])
        ->call('save')
        ->assertHasFormErrors(['email']);
});
