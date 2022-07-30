<?php

namespace App\Modules\Sites\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @param string $name
     * @return Builder|Model
     */
    public static function findOrCreateByName(string $name){

        return self::query()->firstOrCreate([
            'name' => $name
        ]);
    }
}
