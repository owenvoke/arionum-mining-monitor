<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Worker
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $name
 * @property string      $ip
 * @property string      $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Worker extends Model
{
    /** @var array */
    protected $fillable = [
        'user_id',
        'name',
        'ip',
        'type',
    ];
}
