<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 *
 * @property Worker|null $worker
 */
class WorkerReport extends Model
{
    /**
     * @return BelongsTo|null
     */
    public function worker(): ?BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
