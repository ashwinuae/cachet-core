<?php

return [
    'resource_label' => 'API Key|API Keys',
    'show_token' => [
        'heading' => 'Copy your new API token',
        'description' => 'For your security, the token won\'t be shown again.',
        'copy_tooltip' => 'Token copied!',
    ],
    'abilities_label' => ':ability :resource',
    'form' => [
        'name_label' => 'Token name',
        'expires_at_label' => 'Expires at',
        'expires_at_helper' => 'Expires at midnight. Leave empty for no expiration date.',
        'expires_at_validation' => 'The expiration date must be in the future.',
        'abilities_label' => 'Permissions',
        'abilities_hint' => 'Leave this empty to give the token full permissions.',
    ],
    'list' => [
        'actions' => [
            'revoke' => 'Revoke',
        ],
        'headers' => [
            'name' => 'Token name',
            'abilities' => 'Permissions',
            'created_at' => 'Created at',
            'expires_at' => 'Expires at',
            'updated_at' => 'Updated at',
        ],
    ],
];
