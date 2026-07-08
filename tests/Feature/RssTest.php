<?php

use Cachet\Models\Incident;

it('can get the rss feed', function () {
    $incident = Incident::factory()->create();

    $this->get('/status/rss')
        ->assertOk()
        ->assertSee($incident->name);
});

it('produces valid xml when an incident message contains a cdata terminator', function () {
    Incident::factory()->create([
        'message' => 'Something broke: ]]><script>alert(1)</script>',
    ]);

    $response = $this->get('/status/rss')->assertOk();

    $xml = simplexml_load_string($response->getContent());

    expect($xml)->not->toBeFalse()
        ->and((string) $xml->channel->item[0]->description)
        ->toContain(']]><script>alert(1)</script>');
});
