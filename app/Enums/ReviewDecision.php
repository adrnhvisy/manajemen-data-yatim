<?php

namespace App\Enums;

enum ReviewDecision: string
{
    case FORWARD = 'forward';
    case RETURN = 'return';
    case APPROVE = 'approve';
    case REJECT = 'reject';
}
