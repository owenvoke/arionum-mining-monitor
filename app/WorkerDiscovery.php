<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerDiscovery
 *
 * @property int    $worker
 * @property Carbon $date
 * @property int    $difficulty
 * @property int    $dl
 * @property string $nonce
 * @property string $argon
 * @property int    $retries
 * @property bool   $confirmed
 */
class WorkerDiscovery extends Model
{
    /** @var bool */
    public $timestamps = false;
    /** @var string */
    protected $table = 'worker_discovery';
    /** @var array */
    protected $dates = [
        'date',
    ];
}
