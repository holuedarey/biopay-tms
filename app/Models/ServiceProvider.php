<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Every service has a provider which ensures a transaction can occur.
 * Providers can be many for a particular service but only one of such would be active
 * at the instance when a transaction for that service occurs.
 */
class ServiceProvider extends Model
{
    use HasFactory;

    protected $hidden = ['class'];
    protected $guarded = ['id'];

// Relationships

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
