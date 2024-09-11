<?php

namespace Chernogolov\Mtm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'value', 'ordering'
    ];

    public static function getOptions()
    {
        $default = config('mtm.options');
        $db = [];

        try {
            $db = Self::all('name', 'value')->keyBy('name');
        } catch (\Exception $e) {
        }

        $options = [];

        foreach ($default as $key => $value)
        {
            if(isset($db[$key]))
                $options[$key] = $db[$key]->value;
            else
                $options[$key] = $value;
        }

        return $options;
    }
}
