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
    /** @var bool */
    public $timestamps = false;
    /** @var string */
    protected $table = 'worker_report';
    /** @var array */
    protected $dates = [
        'date',
    ];
}
