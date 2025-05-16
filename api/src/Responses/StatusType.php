<?php

namespace App\Responses;

enum StatusType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case BADRQ = 'bad request';
    case CONFLICT = 'conflict';
}