<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerReport
 *
 * @property int    $worker
 * @property Carbon $date
 * @property int    $hashes
 * @property int    $elapsed
 * @property float  $rate
 */
class WorkerReport extends Model
{
    /** @var string */
    protected $table = 'worker_report';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $dates = [
        'date',
    ];
}
