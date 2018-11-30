<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerReport
 *
 * @property int         $id
 * @property int         $worker_id
 * @property int         $hashes
 * @property int         $elapsed
 * @property float       $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class WorkerReport extends Model
{
}
