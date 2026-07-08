<?php

namespace Tests\Feature\Filament\Widgets;

use Cachet\Enums\ComponentStatusEnum;
use Cachet\Enums\ResourceVisibilityEnum;
use Cachet\Filament\Widgets\Components;
use Cachet\Models\Component;
use Cachet\Models\ComponentGroup;

use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

it('component smoke test', function () {
    $component = livewire(Components::class);

    $component->assertSuccessful();
});

it('shows component groups of every visibility', function () {
    foreach ([
        'Guest Group' => ResourceVisibilityEnum::guest,
        'Authenticated Group' => ResourceVisibilityEnum::authenticated,
        'Hidden Group' => ResourceVisibilityEnum::hidden,
    ] as $name => $visibility) {
        $componentGroup = ComponentGroup::factory()->create([
            'name' => $name,
            'visible' => $visibility,
        ]);

        Component::factory()->create([
            'component_group_id' => $componentGroup->id,
            'enabled' => true,
        ]);
    }

    $component = livewire(Components::class);

    $component->assertSuccessful();

    $component->assertSee('Guest Group');
    $component->assertSee('Authenticated Group');
    $component->assertSee('Hidden Group');
    $component->assertDontSee('Other Components');
});

it('does not show component groups with no components', function () {
    $componentGroup = ComponentGroup::factory()->create([
        'name' => 'Group With Components',
    ]);

    Component::factory()->create([
        'component_group_id' => $componentGroup->id,
        'enabled' => true,
    ]);

    ComponentGroup::factory()->create([
        'name' => 'Empty Group',
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    $component->assertSee('Group With Components');
    $component->assertDontSee('Empty Group');
});

it('will only show enabled components', function () {
    $componentGroup = ComponentGroup::factory()->create([
        'name' => 'Laravel',
        'visible' => true,
    ]);

    Component::factory()->create([
        'name' => 'Forge',
        'component_group_id' => $componentGroup->id,
        'enabled' => true,
    ]);

    Component::factory()->create([
        'name' => 'Cloud',
        'component_group_id' => $componentGroup->id,
        'enabled' => false,
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    assertCount(1, $component->components);

    $component->assertSee('Forge');
    $component->assertDontSee('Cloud');
});

it('will show component groups in the correct order', function () {
    $componentGroup1 = ComponentGroup::factory()->create([
        'name' => 'Test Component Group 1',
        'visible' => true,
        'order' => 2,
    ]);

    Component::factory()->create([
        'component_group_id' => $componentGroup1->id,
    ]);

    $componentGroup2 = ComponentGroup::factory()->create([
        'name' => 'Test Component Group 2',
        'visible' => true,
        'order' => 1,
    ]);

    Component::factory()->create([
        'component_group_id' => $componentGroup2->id,
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    assertCount(2, $component->components);

    $component->assertSeeInOrder(['Test Component Group 2', 'Test Component Group 1']);
});

it('will show grouped components in the correct order', function () {
    $componentGroup = ComponentGroup::factory()->create([
        'name' => 'Laravel',
        'visible' => true,
    ]);

    Component::factory()->create([
        'name' => 'Forge',
        'component_group_id' => $componentGroup->id,
        'order' => 2,
    ]);

    Component::factory()->create([
        'name' => 'Cloud',
        'component_group_id' => $componentGroup->id,
        'order' => 1,
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    assertCount(2, $component->components);

    $component->assertSeeInOrder(['Cloud', 'Forge']);
});

it('will not show component groups without components', function () {
    ComponentGroup::factory()->create([
        'name' => 'Laravel',
        'visible' => true,
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    $component->assertDontSee('Laravel');
});

it('will show enabled components without group', function () {
    Component::factory()->create([
        'name' => 'Github',
        'enabled' => true,
    ]);

    Component::factory()->create([
        'name' => 'Bitbucket',
        'enabled' => false,
    ]);

    $component = livewire(Components::class);

    $component->assertSuccessful();

    $component->assertSee('Github');
    $component->assertDontSee('Bitbucket');
});

it('can save status of component within component group to have major outage', function () {
    $componentGroup = ComponentGroup::factory()->create([
        'name' => 'Laravel',
        'visible' => true,
    ]);

    $component = Component::factory()->create([
        'name' => 'Forge',
        'component_group_id' => $componentGroup->id,
        'status' => ComponentStatusEnum::operational,
    ]);

    $livewireComponent = livewire(Components::class);

    $livewireComponent->assertSuccessful();

    $livewireComponent->set(
        'formData.'.$component->id.'.status',
        ComponentStatusEnum::major_outage->value
    );

    assertEquals(ComponentStatusEnum::major_outage, $component->fresh()->status);
});

it('can save status of component outside a component group to have major outage', function () {
    $component = Component::factory()->create([
        'name' => 'Github',
        'status' => ComponentStatusEnum::operational,
        'enabled' => true,
    ]);

    $livewireComponent = livewire(Components::class);

    $livewireComponent->assertSuccessful();

    $livewireComponent->set(
        'formData.'.$component->id.'.status',
        ComponentStatusEnum::major_outage->value
    );

    assertEquals(ComponentStatusEnum::major_outage, $component->fresh()->status);
});
