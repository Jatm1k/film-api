<?php

namespace App\Enums\API\v1;

enum ReviewType: string
{
    case Positive = 'positive';
    case Negative = 'negative';
}
