<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceTerminal extends Pivot
{
    use HasFactory;

    protected $table = 'service_terminal';

    public $incrementing = true;
}
