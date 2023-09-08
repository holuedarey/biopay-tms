<?php

namespace App\Models;

use App\Enums\Action;
use App\Traits\HasFiltering;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GLT extends Model
{
    use HasFactory, HasFiltering;

    protected $guarded = ['id'];

    protected $table = 'g_l_t_s';

    protected $casts = [
        'type' => Action::class
    ];

    public function generalLedger(): BelongsTo
    {
        return $this->belongsTo(GeneralLedger::class, 'gl_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
