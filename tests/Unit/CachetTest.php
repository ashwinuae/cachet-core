<?php

use Cachet\Cachet;

it('renders markdown to html', function () {
    expect(Cachet::markdown('We are **investigating** this [incident](https://example.com).'))
        ->toContain('<strong>investigating</strong>')
        ->toContain('<a href="https://example.com">incident</a>');
});

it('strips raw html from markdown', function () {
    expect(Cachet::markdown('Hello <script>alert(1)</script> **world**'))
        ->not->toContain('<script>')
        ->toContain('<strong>world</strong>');
});

it('does not link unsafe urls', function () {
    expect(Cachet::markdown('[click me](javascript:alert(1))'))
        ->not->toContain('javascript:');
});

it('renders inline markdown without block elements', function () {
    expect(Cachet::markdown('The **primary** API', inline: true))
        ->toContain('<strong>primary</strong>')
        ->not->toContain('<p>');
});

it('strips raw html from inline markdown', function () {
    expect(Cachet::markdown('<img src=x onerror=alert(1)> down', inline: true))
        ->not->toContain('onerror');
});

it('renders an empty string for null input', function () {
    expect(Cachet::markdown(null))->toBe('');
});
