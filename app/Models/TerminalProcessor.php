<?php

namespace App\Models;

use App\Helpers\General;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TerminalProcessor extends Model
{
    use HasFactory, MustBeApproved;

    protected $guarded = ['id'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function processor()
    {
        return $this->hasOne(Processor::class, 'id', 'processor_id');
    }


    public static function createForTerminal(Terminal $terminal): void
    {
        Processor::each(function ($processor) use ($terminal) {
            $terminalProcessor = new TerminalProcessor([
                'user_id' => $terminal->user_id,
                'serial' => $terminal->serial,
                'processor_id' => $processor->id,
                'processor_name' => $processor->name,
                'tid' => '00000000',
                'mid' => '000000000000000',
                'category_code' => '0000',
                'name_location' => General::generateNameLocation($terminal->owner->name)
            ]);

            $terminalProcessor->withoutApproval()->save();
        });
    }
}
