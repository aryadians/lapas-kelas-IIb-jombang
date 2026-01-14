<?php

namespace App\Enums;

enum KunjunganStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CALLED = 'called';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
