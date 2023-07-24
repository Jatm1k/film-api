<?php

namespace App\Enums\API\v1;

enum Role: string
{
    case Viewer = 'viewer';
    case Admin = 'admin';

    public function getId(): int
    {
        return match ($this) {
            Role::Viewer => 1,
            Role::Admin => 2,
        };
    }
}
