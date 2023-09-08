<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountConfig extends Model
{
    use HasFactory, MustBeApproved;

    protected $guarded = ['id'];
}
