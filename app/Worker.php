<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Worker
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $name
 * @property string $ip
 * @property Carbon $date
 * @property string $type
 */
class Worker extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $dates = [
        'date',
    ];

    /** @var array */
    protected $fillable = [
        'user_id',
        'name',
        'ip',
        'date',
        'type',
    ];
}
