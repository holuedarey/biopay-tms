<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get a config value by its name/key
     *
     * @param string $name
     * @return mixed
     */
    public static function getValue(string $name)
    {
        return self::where('name', $name)->first()->value;
    }
}
